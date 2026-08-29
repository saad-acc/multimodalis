# Implementation Log

Work item: `00005-cloudsql-sandbox-connection`  
Plan: `implementation-plan.md`  
Implementer sessions: 2026-08-29 (scaffold + blocked-on-secrets); 2026-08-29 (unblocked resume)

---

## Summary

All planned tasks **1–8** complete. Live Auth Proxy `SELECT 1` proven (and re-proven this session). GitHub Environment **`sandbox`** created and filled. No Better Auth, no `AUTH_MODE=db`, no `--add-cloudsql-instances`, no `DB_PASSWORD` mount on Cloud Run. Local `.env` written from Secret Manager via helper script and remains **gitignored** (never committed).

**Blocked for orchestrator:** no  
**Ready for verification:** yes

---

## Tasks

### 1. Env contract docs — Auth Proxy local — **done**

- `.env.example`: sandbox `INSTANCE_CONNECTION_NAME`; TCP defaults; `DB_NAME=bestmodal2` / `DB_USER=bestmodal` (non-secret, from clarifications); empty `DB_PASSWORD`; SM secret id documented; Environment `sandbox` key names; deferred attach/login noted

### 2. README — decouple connectivity from login — **done**

- Auth Proxy → TCP → `php scripts/check-db-connection.php` with `AUTH_MODE=stub`
- SM → local `.env` via `./scripts/sync-sandbox-db-env-from-sm.sh` (no password echo)
- Compose `host.docker.internal` note; Compose MySQL optional fallback
- Deferred list unchanged: Better Auth, DB login, Cloud Run SQL attach, production env

### 3. Connectivity proof script — **done**

- `scripts/check-db-connection.php` + `db_ping()` in `public/includes/db.php`
- Header documents SM sync path; does not call users-table auth

### 4. Auth Proxy feasibility — document + prove — **done**

- Docs in README (`cloud-sql-proxy … --address 127.0.0.1 --port 3306`)
- **Prior proof (clarifications):** Live Auth Proxy + SM `bestmodal2-sandbox-database-url` already proved `SELECT 1` (password not recorded)
- **Re-proof this session:** `./scripts/sync-sandbox-db-env-from-sm.sh --check` after starting Auth Proxy →  
  `OK: SELECT 1 succeeded via db_pdo() (DB_DSN_MODE=tcp, 127.0.0.1:3306, db=bestmodal2).`  
  Password not printed. Product login left on stub.

### 5. GitHub Environment `sandbox` — **done** (names + live values)

- Created Environment `sandbox` via `gh api`
- Set variables (values OK to record):
  - `DB_NAME` = `bestmodal2`
  - `DB_USER` = `bestmodal`
  - `INSTANCE_CONNECTION_NAME` = `bestmodal-492819:europe-west1:bestmodal2-sandbox-mysql`
- Set secret (name only): `DB_PASSWORD` — value from `gcloud secrets versions access` on `bestmodal2-sandbox-database-url`, parsed from mysql URL, piped to `gh secret set` (never echoed)
- `.github/workflows/deploy.yml`: `environment: sandbox`; refs `${{ vars.INSTANCE_CONNECTION_NAME }}`, `${{ vars.DB_NAME }}`, `${{ vars.DB_USER }}`

### 6. Runtime SA `multimodalis-run` — **done** (prior session)

- `multimodalis-run@bestmodal-492819.iam.gserviceaccount.com`
- No `roles/cloudsql.client` this slice

### 7. Optional deploy scaffolding — **done** (within forbids)

- `--service-account=multimodalis-run@…`
- Cloud Run env scaffolding: `INSTANCE_CONNECTION_NAME`, `DB_NAME`, `DB_USER`
- Keeps `AUTH_MODE=stub`
- **No** `--add-cloudsql-instances`
- **No** `DB_PASSWORD` mount
- Keeps `GCP_SA_KEY` deploy auth

### 8. Sanity check — deferred scope + secrets hygiene — **done**

| Check | Result |
| --- | --- |
| No real secrets in git/workflow YAML | Pass |
| `.env` gitignored; not committed | Pass |
| Login path / stub unchanged (`auth.php` not edited) | Pass |
| No Better Auth | Pass |
| No production Environment | Pass |
| No `--add-cloudsql-instances` | Pass |
| `AUTH_MODE=stub` in deploy | Pass |
| NFR6 (b) live SELECT 1 | **Pass** (re-proven) |

Also: `docker-compose.yml` defaults `DB_NAME`/`DB_USER` to sandbox non-secret identity; password still from env only.

---

## Deferred (explicit — not implemented)

Per plan table: Better Auth; `AUTH_MODE=db` / `DB_USERS_*`; Cloud Run SQL attach; Cloud SQL Client grant; Secret Manager → Cloud Run password mounts; Environment `production`; WIF replacing `GCP_SA_KEY`.

---

## Blocked (orchestrator)

**No** — secrets unblocked via clarifications (SM `bestmodal2-sandbox-database-url` + known `DB_NAME`/`DB_USER`). Live proof recorded above.

---

## Files touched (this work item)

| Path | Change |
| --- | --- |
| `.env.example` | Sandbox identity + SM / Environment docs |
| `README.md` | Auth Proxy + SM sync + GHA sandbox filled |
| `scripts/check-db-connection.php` | Connectivity CLI |
| `scripts/sync-sandbox-db-env-from-sm.sh` | **New** — SM → gitignored `.env`; optional `--check` |
| `public/includes/db.php` | `db_ping()` helper |
| `docker-compose.yml` | Sandbox DB name/user defaults; comments |
| `.github/workflows/deploy.yml` | `environment: sandbox`; runtime SA; DB scaffolding env; stub only |

Not touched: `public/includes/auth.php`, Better Auth, Cloud Run SQL attach flags.  
Not committed: local `.env` (gitignored).
