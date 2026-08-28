# Multimodalis

PHP 8.3 (Apache) Multimodalis v2 app: login + Tarifabfrage chrome, deployable to Cloud Run.

## Local test (stub auth — no Cloud SQL)

```bash
docker compose up --build
```

Open [http://localhost:8080](http://localhost:8080).

1. Login screen title **Login Multimodalis**; host label should show `localhost:8080` (real `HTTP_HOST`, not a hardcoded sandbox name).
2. Enter any non-empty email + password (default `AUTH_MODE=stub` with no `STUB_*` set).
3. After **Anmelden**, you land on **Tarifabfrage** chrome (empty results; search does not hit a DB).
4. Wrong stub credentials (when `STUB_EMAIL` / `STUB_PASSWORD` are set) show **„Anmeldung fehlgeschlagen.“** and never open Tarifabfrage.
5. Opening `/index.php?page=tariff_query` while logged out redirects to login before chrome.

Stop with `Ctrl+C` (or `docker compose down`).

### Optional: stub with fixed credentials

Copy `.env.example` → `.env` and set:

```env
AUTH_MODE=stub
STUB_EMAIL=you@example.com
STUB_PASSWORD=change-me
```

Compose reads these if present (see `docker-compose.yml`).

### Optional: Cloud SQL Auth Proxy (local → sandbox DB)

Preferred when sandbox credentials exist (not required for stub testing):

1. Start Cloud SQL Auth Proxy listening on `127.0.0.1:3306`.
2. Set `AUTH_MODE=db`, `DB_DSN_MODE=tcp`, `DB_HOST` / `DB_PORT` / `DB_NAME` / `DB_USER` / `DB_PASSWORD`, and `DB_USERS_TABLE` (+ email/hash column env vars once ops confirms the existing table).
3. From Docker Desktop / Compose, point `DB_HOST` at the host (e.g. `host.docker.internal`) so the container reaches the proxy.
4. `docker compose up --build`

### Optional: Compose MySQL profile (fallback)

```bash
docker compose --profile mysql up --build
```

Use only when sandbox connectivity is painful. Still set `AUTH_MODE=db` and user-table env vars against that local MySQL — this slice does **not** invent or migrate a users schema.

## Deploy (GitHub Actions)

Pushing git tag **`v0.0.1`** runs [`.github/workflows/deploy.yml`](.github/workflows/deploy.yml):

- Authenticate with repository secret **`GCP_SA_KEY`** (deployer SA JSON, same pattern as ratecardwiz)
- Ensure Artifact Registry repo + enable APIs
- Cloud Build → push image → `gcloud run deploy multimodalis` in project `bestmodal-492819`, region `europe-west1`, port `80`
- First deploy uses **`AUTH_MODE=stub`** until Cloud SQL instance + user schema are wired

### GitHub configuration

| Type | Name | Value |
|------|------|--------|
| Secret | `GCP_SA_KEY` | Deployer service-account JSON |
| Variable | `PROJECT_ID` | `bestmodal-492819` |
| Variable | `REGION` | `europe-west1` |
| Variable | `ENVIRONMENT` | `sandbox` |
| Variable | `ARTIFACT_REGISTRY_REPO` | `multimodalis` |

Never commit `.env`, service-account JSON, or real DB passwords.

## Layout

```
public/           Apache document root
  index.php
  api/check_login.php
  includes/       config, db, auth
  pages/          login, tariff_query
  images/         logo + favicon
Dockerfile
docker-compose.yml
.github/workflows/deploy.yml
```
