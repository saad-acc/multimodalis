# Discovery

Work item `00005-cloudsql-sandbox-connection` — connect local Multimodalis and Cloud Run `multimodalis` to the existing Cloud SQL MySQL sandbox instance. Builds on accepted `00001-v2-php-cloudrun-login` (PDO + AUTH_MODE wiring already shipped; live instance attach deferred).

## Existing systems / prior art

### Named Cloud SQL target (new for this item)
- **Instance connection name (given):** `bestmodal-492819:europe-west1:bestmodal2-sandbox-mysql`
- **GCP project / region:** `bestmodal-492819` / `europe-west1`
- **Cloud Run service:** `multimodalis` (already deployed via GHA from 00001; currently `AUTH_MODE=stub`)
- Instance was deferred in 00001 clarifications (“do later”); this request supplies the name. No credentials, schema dump, or DB user inventory are in-repo (by design).

### Multimodalis PHP app (v2) — already in tree
- Docroot `public/`; session login via `api/check_login.php`; Tarifabfrage chrome.
- **`public/includes/config.php`:** env-driven `AUTH_MODE` (`stub`|`db`), `DB_DSN_MODE` (`socket`|`tcp`), `INSTANCE_CONNECTION_NAME` → default socket path `/cloudsql/...`, `DB_HOST`/`DB_PORT`/`DB_NAME`/`DB_USER`/`DB_PASSWORD`, `DB_USERS_TABLE` + email/hash column env hooks.
- **`public/includes/db.php`:** PDO factory (Unix socket for Cloud Run; TCP for Auth Proxy / Compose); `db_find_user_password_hash()` queries **existing** table/columns from env only — no migrations, no invented schema.
- **`public/includes/auth.php`:** `attempt_login` stub vs `password_verify` against DB hash when `AUTH_MODE=db`.
- **`.env.example`:** documents the env contract; placeholders only (`INSTANCE_CONNECTION_NAME=PROJECT:REGION:INSTANCE`, sample `DB_NAME=bestmodal` / `DB_USER=app` — **not** confirmed against the live sandbox instance).
- **`docker-compose.yml`:** default `AUTH_MODE=stub`; DB env passthrough; comments for Auth Proxy via `host.docker.internal`; optional `mysql` Compose profile as fallback only.
- **`README.md`:** stub path documented; optional Cloud SQL Auth Proxy steps sketched; notes first Cloud Run deploy stays stub until Cloud SQL + user schema are wired.

### Deploy path
- **`.github/workflows/deploy.yml`:** tag `v0.0.1` + `workflow_dispatch`; auth via `secrets.GCP_SA_KEY` (already configured per request); deploys image to Cloud Run `multimodalis` in `bestmodal-492819` / `europe-west1`.
- **Current deploy env:** `APP_ENV=prod,AUTH_MODE=stub,ENVIRONMENT=sandbox` only — **no** `--add-cloudsql-instances`, **no** `INSTANCE_CONNECTION_NAME` / DB_* / Secret Manager mounts on the service.
- Workflow comment explicitly: stub until Cloud SQL instance + user schema are wired.

### Prior architecture / decisions (constraints, not re-decided here)
- ADR (proposed): [Cloud SQL Unix socket on Cloud Run](../../knowledge/decisions/cloud-sql-unix-socket-on-cloudrun.md) — native `/cloudsql/${INSTANCE_CONNECTION_NAME}` + `--add-cloudsql-instances`; Auth Proxy sidecar / public IP rejected for Cloud Run.
- ADR (proposed): [Env-based DB targets](../../knowledge/decisions/env-based-db-targets.md) — all connectivity via env; local preferred path Auth Proxy → sandbox; Compose MySQL fallback.
- 00001 preference (clarified / recorded): localhost app → remote **sandbox** DB; Cloud Run → remote DB (initially same). This request confirms both local and Cloud Run use **this sandbox** instance for now.
- 00001 verification: local stub path proven; **live** `AUTH_MODE=db` against Cloud SQL and Cloud SQL attach on Cloud Run **not** proven.

### Knowledge inventory consulted
- Components: Multimodalis PHP app, Sandbox BestModal (external v1), Multimodalis workflow.
- Domain: BestModal, Tarifabfrage, tariff administration (no DB schema vocabulary yet).
- **Gap filled this Discovery:** Cloud SQL sandbox instance was not previously inventoried as a component (see knowledge promotion below).

### Not found / not in scope to invent
- No DB password, no Secret Manager secret **names**, no confirmed MySQL database name or app user, no confirmed users table / column / hash format against the sandbox instance.
- Sandbox BestModal v1 source is external (`sandbox.bestmodal.de`); this repo must not invent a users schema to match it — ops/human must confirm existing tables for `AUTH_MODE=db`.

## Constraints found

1. **Do not invent or commit secrets** — `DB_PASSWORD` and SA keys stay in Secret Manager / GitHub secrets / local gitignored `.env` only (NFR from 00001; restated in this request).
2. **Reuse existing PDO / AUTH_MODE contract** — prefer env + deploy wiring over new connection code paths; Architecture already chose socket (Cloud Run) vs Auth Proxy TCP (local).
3. **Instance connection name is now known** — `bestmodal-492819:europe-west1:bestmodal2-sandbox-mysql`; `.env.example` / deploy still use placeholders until this item updates them (non-secret name may live in env/docs; password must not).
4. **Both targets → same sandbox DB for now** — localhost (via Auth Proxy) and Cloud Run `multimodalis` (via Unix socket attach).
5. **`GCP_SA_KEY` already configured** for deploys; runtime Cloud Run SA still needs Cloud SQL Client (+ Secret Manager accessor) as required by attach — confirm/least-privilege is Architecture/ops, not invented here.
6. **`AUTH_MODE` remains stub on Cloud Run today** — flipping to `db` is an explicit ops/product choice once credentials + users table env are known; stub must remain usable for offline UI work.
7. **No user CRUD / migrations** in prior slice — login reads existing rows only; schema discovery is human/ops input, not Implementer invention.
8. **Deploy trigger still tag `v0.0.1` / workflow_dispatch** — GHA/Cloud Run env updates (attach, env vars, secrets) are in scope for this item’s planning; do not invent credential values in workflow YAML.

## Open questions

These do **not** prevent completing Discovery (systems and constraints are clear). They **do** need human answers before requirements can be fully testable / before Implementation can flip `AUTH_MODE=db` safely. Captured append-only in `clarifications.md` for `business_clarification`.

1. **MySQL database name** for Multimodalis on this instance (`.env.example` says `bestmodal` — confirm or correct).
2. **DB user** (and whether one shared user for local + Cloud Run, or separate).
3. **DB password storage:** Secret Manager secret id(s), how Cloud Run and local `.env` obtain them (never commit).
4. **Users table for `AUTH_MODE=db`:** table name + email + password-hash columns (and confirm hashes are `password_verify`-compatible).
5. **Local Auth Proxy:** required developer setup (binary/IAM), listen address, and Compose `host.docker.internal` vs host-run app — document vs mandate.
6. **Cloud Run attach:** confirm `--add-cloudsql-instances=bestmodal-492819:europe-west1:bestmodal2-sandbox-mysql` (or equivalent) and runtime SA roles.
7. **`AUTH_MODE` flip:** when Cloud Run (and local default docs) move from `stub` → `db` — same change, staged, or keep stub available as fallback.
8. **Deploy cadence:** update existing `v0.0.1` workflow only, new tag, or `workflow_dispatch`-only for this wiring change.
