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

## Local sandbox DB (Auth Proxy — connectivity only)

Primary local path to Cloud SQL instance
`bestmodal-492819:europe-west1:bestmodal2-sandbox-mysql`. This proves **PDO connectivity only**. It does **not** flip login to DB (`AUTH_MODE` stays `stub`).

### 1. Start Cloud SQL Auth Proxy

Authenticate to GCP with an identity that can connect to the instance (same project as deploy). Then:

```bash
cloud-sql-proxy bestmodal-492819:europe-west1:bestmodal2-sandbox-mysql --address 127.0.0.1 --port 3306
```

Proxy must listen on `127.0.0.1:3306` for this instance only.

### 2. Fill local `.env` (password from Secret Manager — never commit)

Non-secret values for this sandbox: `DB_NAME=bestmodal2`, `DB_USER=bestmodal`. Password is **not** on the Cloud SQL API; it lives in Secret Manager:

`projects/bestmodal-492819/secrets/bestmodal2-sandbox-database-url` (MySQL URL).

**Recommended** (writes gitignored `.env`, never prints the password):

```bash
# Authenticate as deployer (or any identity with secretAccessor on that secret), e.g.:
#   export GOOGLE_APPLICATION_CREDENTIALS=/path/to/deployer.json
#   gcloud auth activate-service-account --key-file="$GOOGLE_APPLICATION_CREDENTIALS"
./scripts/sync-sandbox-db-env-from-sm.sh
```

Or manually: `cp .env.example .env`, then set `DB_PASSWORD` from the SM URL locally — do not commit `.env`.

Keep:

```env
AUTH_MODE=stub
DB_DSN_MODE=tcp
DB_HOST=127.0.0.1
DB_PORT=3306
INSTANCE_CONNECTION_NAME=bestmodal-492819:europe-west1:bestmodal2-sandbox-mysql
DB_NAME=bestmodal2
DB_USER=bestmodal
```

### 3. Connectivity proof (not login)

From repo root (host PHP with `pdo_mysql`), with Auth Proxy running:

```bash
php scripts/check-db-connection.php
# or one-shot after SM sync:
./scripts/sync-sandbox-db-env-from-sm.sh --check
```

Exit 0 + `OK: SELECT 1…` means Auth Proxy + credentials work. The script uses `db_pdo()` / `db_ping()` only — it never calls users-table auth.

**Compose note:** If the app runs in Docker and the proxy on the host, set `DB_HOST=host.docker.internal` (and enable `extra_hosts` in `docker-compose.yml` as commented). Prefer host-run `php scripts/check-db-connection.php` for the feasibility proof.

### Deferred (do not enable this slice)

- Better Auth assessment / implementation
- `AUTH_MODE=db`, `DB_USERS_*`, login against sandbox user rows
- Cloud Run `--add-cloudsql-instances` / Unix-socket PDO attach
- GitHub Environment `production` / prod Cloud SQL

### Optional: Compose MySQL profile (fallback only)

```bash
docker compose --profile mysql up --build
```

Use only when Auth Proxy / sandbox credentials are unavailable. Not the primary sandbox path. Still leave product login on `AUTH_MODE=stub` unless a later work item flips it.

## Deploy (GitHub Actions)

Pushing git tag **`v0.0.1`** (or manual `workflow_dispatch`) runs [`.github/workflows/deploy.yml`](.github/workflows/deploy.yml):

- Job uses GitHub Environment **`sandbox`**
- Authenticate with **`GCP_SA_KEY`** (deployer SA JSON; may be repo- or environment-scoped)
- Ensure Artifact Registry repo + enable APIs
- Cloud Build → push image → `gcloud run deploy multimodalis` in project `bestmodal-492819`, region `europe-west1`
- Runtime SA: `multimodalis-run@bestmodal-492819.iam.gserviceaccount.com`
- Non-secret env scaffolding: `INSTANCE_CONNECTION_NAME`, `DB_NAME`, `DB_USER` (from Environment `sandbox` vars)
- **`AUTH_MODE=stub`** — no Cloud SQL attach, no `AUTH_MODE=db`, no `DB_PASSWORD` mount this slice

### GitHub Environment `sandbox` configuration

Environment **`sandbox`** holds DB config. Workflow YAML references *names* only (no password literals).

| Type | Name | Notes |
|------|------|--------|
| Secret | `GCP_SA_KEY` | Deployer service-account JSON (repo-level OK if already set) |
| Variable | `PROJECT_ID` | `bestmodal-492819` |
| Variable | `REGION` | `europe-west1` |
| Variable | `ENVIRONMENT` | `sandbox` |
| Variable | `ARTIFACT_REGISTRY_REPO` | `multimodalis` |
| Variable | `INSTANCE_CONNECTION_NAME` | `bestmodal-492819:europe-west1:bestmodal2-sandbox-mysql` |
| Variable | `DB_NAME` | `bestmodal2` |
| Variable | `DB_USER` | `bestmodal` |
| Secret | `DB_PASSWORD` | From SM `bestmodal2-sandbox-database-url` (password segment only; never in git) |

To refresh Environment secret `DB_PASSWORD` without echoing it: access SM `bestmodal2-sandbox-database-url`, parse the MySQL URL password, and pipe to `gh secret set DB_PASSWORD --env sandbox` (deployer SA needs `secretAccessor`). For local only, use `./scripts/sync-sandbox-db-env-from-sm.sh`.

`DB_NAME` / `DB_USER` are passed as Cloud Run env scaffolding; **`DB_PASSWORD` is not mounted** onto Cloud Run this slice (deferred with Better Auth / SQL attach).

Never commit `.env`, service-account JSON, or real DB passwords.

### Runtime service account

Dedicated runtime SA (created for this project):

`multimodalis-run@bestmodal-492819.iam.gserviceaccount.com`

Cloud SQL Client (`roles/cloudsql.client`) is granted **when** `--add-cloudsql-instances` is later enabled — not required while attach is deferred.

If the SA is missing in a fresh project, create it (no Client role yet):

```bash
gcloud iam service-accounts create multimodalis-run \
  --project=bestmodal-492819 \
  --display-name="Multimodalis Cloud Run runtime"
```

## Layout

```
public/           Apache document root
  index.php
  api/check_login.php
  includes/       config, db, auth
  pages/          login, tariff_query
  images/         logo + favicon
scripts/          check-db-connection.php; sync-sandbox-db-env-from-sm.sh
Dockerfile
docker-compose.yml
.github/workflows/deploy.yml
```
