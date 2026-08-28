# Architecture

Work item: `00001-v2-php-cloudrun-login`  
Inputs: approved `requirements.md`, `ux-spec.md`, `clarifications.md`  
Knowledge: no accepted ADRs / architecture patterns / anti-patterns yet; components = workflow repo + external sandbox v1.

Greenfield PHP app in this repo (workflow-only today, plus early scaffold: `Dockerfile`, `docker-compose.yml`, `public/includes/auth.php`, logo/favicon). Design below is normative for Implementation; existing stub files may be extended, not treated as a second product.

---

## Components

### New: Multimodalis PHP app (this repo)

| Piece | Role |
| --- | --- |
| `public/` | Apache document root (`php:8.3-apache`) |
| `public/index.php` | Front controller: `?page=` routes (`login`, `tariff_query`; unknown authenticated pages → Tarifabfrage) |
| `public/api/check_login.php` | Login check (sandbox analogue of `/modal/api/check_login.php`) |
| `public/includes/` | Shared PHP: config, DB, session/auth helpers |
| `public/pages/` (or equivalent includes) | Login view; Tarifabfrage chrome+layout view |
| `public/images/` | `bestmodal-logo.svg`, `favicon.svg` (already present) |
| `Dockerfile` | Image from `php:8.3-apache`; docroot → `public/`; `pdo_mysql` + rewrite |
| `docker-compose.yml` | Local app (and optional MySQL profile) |
| `.github/workflows/deploy.yml` | Tag `v0.0.1` → build/push → Cloud Run `multimodalis` |
| `.env.example` | Non-secret env documentation (no real credentials) |

**URL shape:** Serve at **app root** on Cloud Run / localhost (`/index.php?page=…`, `/api/check_login.php`). Do **not** require a `/modal/` prefix (sandbox path is external v1; v2 is a new service). Behavior stays analogous to the capture.

**Fits existing structure:** Extends the empty app surface called out in [Multimodalis delivery workflow](../../knowledge/components/multimodalis-workflow.md); visual/auth contract mirrors [Sandbox BestModal](../../knowledge/components/sandbox-bestmodal.md) without copying that codebase into this repo.

### Unchanged / external

- GCP project `bestmodal-492819`, region `europe-west1`, Cloud Run service `multimodalis`
- Cloud SQL MySQL in the same project (instance name **deferred** — placeholder only)
- Sandbox BestModal remains the visual reference, not a deploy dependency

---

## App layout (PHP pages / API)

```
public/
  index.php                 # ?page=login | tariff_query | …
  api/check_login.php       # POST email, password
  includes/
    config.php              # env → typed settings
    db.php                  # PDO factory (socket / TCP)
    auth.php                # session + require_auth + attempt_login
  pages/
    login.php
    tariff_query.php        # chrome + layout; stubbed search
  images/
    bestmodal-logo.svg
    favicon.svg
```

**Routing rules**

1. Unauthenticated default / `page=login` → login screen (FR1).
2. `POST /api/check_login.php` with `email`, `password` → auth; success → redirect `302` to `/index.php?page=tariff_query`; failure → redirect/back to login with minimal error (no session) (FR2, FR4).
3. `page=tariff_query` and any other authenticated shell URL → `require_auth()`; if missing session → redirect to login **before** emitting Tarifabfrage chrome (UX risk #6).
4. Already authenticated + `page=login` → redirect to `tariff_query`.
5. `page=set_password` / “Passwort vergessen?” → **no recovery flow**; keep link for visual match; target may hit a handler that redirects to login (or inert `#`) — do not implement set-password (FR-out-1).
6. Sidebar Dashboard / News-Board / other Tarife-verwalten links → chrome only; navigating them may re-show Tarifabfrage or stay put — **no feature pages** (FR-out-4).
7. Host label = `HTTP_HOST` (or equivalent) of the serving environment (NFR7).

**Assets:** Bootstrap 5.3.0 + bootstrap-icons 1.10.5 via **jsDelivr** (match sandbox; no asset pipeline this slice). Font stack as captured.

**Tarifabfrage stub strategy (UX risk #3):** Keep full layout and local UI affordances; **Tarife suchen** and filters do **not** call the DB. Prefer submit → remain on page with **empty results** (calm no-op), not fake tariff rows and not inventing error toasts.

**Failure copy (UX risk #1):** If capture does not supply wording, use minimal German: **„Anmeldung fehlgeschlagen.“** Clear password field; keep email; `role="alert"`.

---

## Session / auth approach

- **Mechanism:** Native PHP sessions (cookie session id). On success: `session_regenerate_id(true)` and store at least `user_email` in `$_SESSION`.
- **Cookie flags:** `HttpOnly`; `SameSite=Lax`; `Secure` when the request is HTTPS (Cloud Run).
- **Gate:** Shared `require_auth()` on authenticated pages; unauthenticated deep links never flash protected chrome.
- **Login transport:** Form POST (classic), not a SPA. Prefer **server redirect** on success/failure (simple, capture-aligned). JSON response is optional only if needed to match a later capture; default is redirect.
- **Auth modes (env `AUTH_MODE`):**
  - `stub` — local/offline: credentials via optional `STUB_EMAIL` / `STUB_PASSWORD`, or any non-empty pair if unset (current scaffold). Satisfies FR5 without Cloud SQL.
  - `db` — lookup against Cloud SQL MySQL (FR8). No user CRUD UI.
- **Password verification:** Prefer `password_verify()` against a stored hash column when the live schema is known. Until instance/schema are confirmed, Implementer wires a thin repository behind `attempt_login()` with table/column names from env or a single documented discovery step — **do not invent a new users schema** in this slice.
- **Out of scope:** lockout, CSRF hardening, remember-me, rate limits (FR-out-3).

Existing `public/includes/auth.php` is a valid starting point; Implementation extends it for `AUTH_MODE=db` and production cookie flags.

---

## Data model

- **No migrations / no new tables** in this work item.
- Login reads **existing** Cloud SQL user rows (user management is FR-out-2).
- Session state only (server-side PHP session store — default files in container is acceptable for v0.0.1; sticky sessions not required for single-revision Cloud Run proof).
- Tarifabfrage does **not** read tariff/search tables yet (FR-out-8).

**Placeholder until instance/schema are named:** env documents intended DB name and connection; Implementer confirms hash algorithm and user table when ops provides access. If DB auth cannot be verified before tag deploy, Cloud Run may ship with documented `AUTH_MODE` fallback only by explicit human choice — default design remains `db` on Cloud Run.

---

## Integration points

### Cloud SQL (MySQL)

| Environment | Target | How |
| --- | --- | --- |
| Cloud Run | Prod DB (same as sandbox initially) | **Native Cloud SQL attachment → Unix socket** at `/cloudsql/${INSTANCE_CONNECTION_NAME}` |
| Local (preferred) | Remote sandbox DB | App on localhost/Compose; DB via **Cloud SQL Auth Proxy** (TCP `127.0.0.1:3306`) or equivalent |
| Local (fallback) | Compose MySQL | Optional Compose profile when sandbox connectivity is painful |

**Recommended Cloud Run connector: Unix socket (built-in Cloud SQL connection)**

Rationale: Cloud Run’s first-class Cloud SQL integration mounts the socket; PDO uses `unix_socket=/cloudsql/<INSTANCE_CONNECTION_NAME>`; IAM service account + Secret Manager for DB user password; no Auth Proxy sidecar container, no public IP requirement for the instance from the internet. Matches GCP’s default guidance for Cloud Run ↔ Cloud SQL.

**Local connector:** Cloud SQL Auth Proxy (developer machine or Compose sidecar) so the app still speaks plain TCP to `DB_HOST`/`DB_PORT` while the proxy handles IAM/SSL to GCP. Same PDO code path as “TCP DSN”; only env changes.

**Instance name:** Deferred (FR-out-7). Use env placeholder `INSTANCE_CONNECTION_NAME` (form `PROJECT:REGION:INSTANCE`). Deploy workflow and Cloud Run service config reference the placeholder/secret; do not hardcode a fake instance id in git.

### GCP / Cloud Run

- Service: `multimodalis`
- Project: `bestmodal-492819`
- Region: `europe-west1`
- Image: Artifact Registry (or GCR) in the same project/region
- Runtime SA: least privilege — Cloud SQL Client + Secret Manager accessor as needed
- Secrets: DB password (and any deploy keys) via **Secret Manager / GitHub secrets** — never committed (NFR6)

### GitHub Actions (tag `v0.0.1`)

Trigger: `push` tags matching `v0.0.1` (exact tag for this slice).

Pipeline sketch:

1. Authenticate to GCP (prefer **Workload Identity Federation**; avoid long-lived JSON keys in the repo).
2. `docker build` from repo `Dockerfile`.
3. Push image tagged with git tag / digest.
4. `gcloud run deploy multimodalis` with region, image, env, Cloud SQL instance attachment (`--add-cloudsql-instances` / equivalent when name exists), secrets, port `80` (or map container 80 → Cloud Run port as required by platform).
5. Failures visible in Actions (NFR4).

### Local run

```bash
# Preferred path once proxy + sandbox creds exist:
# 1) start Cloud SQL Auth Proxy → 127.0.0.1:3306
# 2) docker compose up --build
# Browse http://localhost:8080 → login → Tarifabfrage

# Offline / no sandbox access:
# AUTH_MODE=stub (default in compose) — no DB required
# Optional: compose profile with MySQL for AUTH_MODE=db against local DB
```

Document commands in Implementation (README or work-item notes); Architecture only requires the topology above.

---

## Env vars (non-exhaustive)

| Variable | Purpose |
| --- | --- |
| `APP_ENV` | `local` \| `sandbox` \| `prod` (labeling / cookie Secure hints) |
| `AUTH_MODE` | `stub` \| `db` |
| `STUB_EMAIL` / `STUB_PASSWORD` | Optional stub gate |
| `INSTANCE_CONNECTION_NAME` | `project:region:instance` placeholder for Cloud Run socket |
| `DB_SOCKET` | e.g. `/cloudsql/${INSTANCE_CONNECTION_NAME}` on Cloud Run |
| `DB_HOST` / `DB_PORT` | TCP for local proxy or Compose (`127.0.0.1`, `3306`) |
| `DB_NAME` / `DB_USER` / `DB_PASSWORD` | MySQL credentials (`DB_PASSWORD` = secret) |
| `DB_DSN_MODE` | `socket` \| `tcp` — selects PDO DSN shape |

Deploy-only (Actions / GCP, not app runtime): `PROJECT_ID`, `REGION`, service name, image repo, WIF provider — stored as GitHub Actions variables/secrets.

---

## Dockerfile

- Base: **`php:8.3-apache`** (NFR1).
- Enable `pdo`, `pdo_mysql`; Apache `rewrite` (+ `headers` as useful).
- Document root: **`/var/www/html/public`**.
- Copy `public/` into the image; do not bake `.env` or secrets.
- Expose `80`.
- Cloud Run: listen on container port 80 (or set `PORT` only if the platform requires remapping — prefer keeping Apache on 80 and configuring Cloud Run container port accordingly).

Scaffold already matches this; Implementation should keep it aligned.

---

## Risks

| Risk | Door type | Mitigation |
| --- | --- | --- |
| Cloud SQL instance / schema unknown | Reversible wiring | Placeholder `INSTANCE_CONNECTION_NAME`; stub auth for local; confirm hash/table before relying on `AUTH_MODE=db` in prod |
| Session files on ephemeral Cloud Run disks | Reversible | Acceptable for v0.0.1 proof; revisit Redis/Memorystore if multi-instance sessions matter later |
| Public Bootstrap CDN dependency | Reversible | Matches sandbox; bundle later if offline/air-gap needed |
| “Passwort vergessen?” looks live | Product confusion | Inert / redirect-to-login; no set-password UI |
| Stub Tarifabfrage looks interactive | Tester confusion | Empty results / no-op; no fake success data |
| Secrets in git | One-way if leaked | `.env` gitignored; Secret Manager + GH secrets only |
| Auth Proxy / network blocked for local→sandbox | Reversible | Compose MySQL fallback + `AUTH_MODE=stub` |
| Path difference vs `/modal/` on sandbox | Documentation only | Root paths on v2 by design |

**Security NFRs shaping design:** secrets out of git; HttpOnly sessions; DB only via socket (Cloud Run) or Auth Proxy (local); no user-management surface.

---

## Rejected alternatives

- **Cloud SQL Auth Proxy as a Cloud Run sidecar:** Unnecessary when native Unix socket attachment exists; more moving parts.
- **Cloud SQL public IP + raw TCP from Cloud Run:** Weaker posture; avoid for default design.
- **Framework (Laravel/Symfony) for this slice:** Repo is greenfield thin PHP matching sandbox; framework would add scope without FR benefit.
- **Mandatory Compose MySQL as primary local path:** Conflicts with recorded preference (localhost → sandbox DB); keep as fallback only.
- **Hardcoded host label `sandbox.BestModal.de`:** Forbidden by NFR7 / clarifications.
- **Invented dashboard as post-login home:** Forbidden; landing is Tarifabfrage only.
- **New users schema / seed-only auth as the Cloud Run path:** User CRUD deferred; use existing DB when available; stub is local-only convenience.
- **Serving under `/modal/` prefix:** Sandbox legacy path; v2 Cloud Run service is cleaner at `/`.
- **Full CSRF/lockout/rate-limit parity:** Explicitly out of scope (FR-out-3).

---

## Project knowledge to promote

Cross-cutting choices future work items should not contradict — proposed ADRs:

1. [`knowledge/decisions/cloud-sql-unix-socket-on-cloudrun.md`](../../knowledge/decisions/cloud-sql-unix-socket-on-cloudrun.md) — Cloud Run ↔ Cloud SQL via native Unix socket + `INSTANCE_CONNECTION_NAME`.
2. [`knowledge/decisions/env-based-db-targets.md`](../../knowledge/decisions/env-based-db-targets.md) — env-selected DB targets (local→sandbox preference, Cloud Run→prod, Compose optional).

Reusable approach (pattern):

3. [`knowledge/patterns/php-public-docroot-session-auth.md`](../../knowledge/patterns/php-public-docroot-session-auth.md) — `public/` docroot + PHP session gate + `api/check_login.php`.
