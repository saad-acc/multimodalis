# Verification Report

Work item: `00001-v2-php-cloudrun-login`  
Verifier: implementer  
Date: 2026-08-28

## Automated
| Check | Command | Result |
|---|---|---|
| Build | `docker build -t multimodalis:verify .` | **pass** (log: `knowledge/features/evidence/00001-v2-php-cloudrun-login/docker-build.log`) |
| Compose up | `docker compose up -d --build` | **pass** |
| Lint | (none in repo — no PHPStan/phpcs/`package.json` lint script) | **n/a** |
| Unit/integration tests | (none in repo) | **n/a** |
| Compose down | `docker compose down` | **pass** |

## Conformance
- vs. `architecture.md`: **match** — `public/` layout (`index.php`, `api/check_login.php`, `includes/{config,db,auth}.php`, `pages/{login,tariff_query}.php`, images); root URLs (no `/modal/`); stub + db `AUTH_MODE`; PDO socket/TCP via env; session cookie flags; Dockerfile `php:8.3-apache` + docroot; Compose port 8080 + stub default; GHA tag `v0.0.1` → Cloud Run `multimodalis` / `bestmodal-492819` / `europe-west1` with WIF + `INSTANCE_CONNECTION_NAME` placeholders. No invented Cloud SQL instance id; no user CRUD / migrations / live search.
- vs. `ux-spec.md`: **match** — DE login card (navy gradient, greens, Bootstrap 5.3.0 + icons 1.10.5 CDN, real host label, labeled fields, Anmelden, Passwort vergessen? inert, Acceltra footer); failure **„Anmeldung fehlgeschlagen.“** with `role="alert"`; success → Tarifabfrage chrome; unauth deep link no chrome flash; Tarifabfrage landmarks / `aria-current`; empty results / stub search.
- vs. accepted `knowledge/decisions/`: **n/a (none accepted yet)** — proposed ADRs [Cloud SQL Unix socket on Cloud Run](../../knowledge/decisions/cloud-sql-unix-socket-on-cloudrun.md) and [Env-based DB targets](../../knowledge/decisions/env-based-db-targets.md) are honored in code/Compose/GHA (socket path + env targets + stub offline). Anti-patterns index empty — nothing to violate.
- **Explicitly not proven here:** live Cloud Run deploy, Cloud SQL `AUTH_MODE=db` against a real instance, Artifact Registry push. Workflow file exists; human must configure WIF/secrets and push tag `v0.0.1`.

## Live verification
| Feature (`knowledge/features/`) | Driven? | Evidence |
|---|---|---|
| [login.md](../../knowledge/features/login.md) | **proven** | `knowledge/features/evidence/00001-v2-php-cloudrun-login/01-login.html` (+ headers); `02-unauth-tariff.headers`; `03-fail-login.html` (+ headers); `04-success-login.headers` |
| [tarifabfrage-landing.md](../../knowledge/features/tarifabfrage-landing.md) | **proven** | `knowledge/features/evidence/00001-v2-php-cloudrun-login/05-tariff.html` (+ headers) |
| Cloud Run tag deploy | **not proven** | GHA present at `.github/workflows/deploy.yml` — no tag push / no GCP deploy this turn |

Drive summary (`AUTH_MODE=stub` with `STUB_EMAIL`/`STUB_PASSWORD`): login 200 + host `localhost:8080`; unauth tariff → 302 login; wrong password → failure copy; correct password → 302 `tariff_query` + 200 shell with empty results; `set_password` → 302 login. Assertions scripted in verification run.

## Documentation hygiene
| Check | Status |
|---|---|
| Flagged `knowledge/` promotions written | **done** (decisions, pattern, domain, components from earlier stages; features + PHP app component this verification) |
| Drift from plan reconciled in `knowledge/` + work-item artifacts | **done** (workflow component description updated — repo now has PHP app; no architecture/ux rework needed) |
| New components captured in `knowledge/components/` | **done** (`multimodalis-php-app.md`) |
| Feature map (`knowledge/features/`) current for every touched feature | **done** (harness seeded; login + tarifabfrage-landing recipes driven) |
| No dangling question in `clarifications.md` | **done** (all answered; Cloud SQL instance deferred by human, not open) |
| `knowledge/log.md` entry per promotion | **done** |

## Verdict
**pass** → `done` (**pending human acceptance**)

Local stub path and conformance are proven. Cloud Run live deploy remains an ops/config step outside this verification drive — not a fail of the implementation slice.

## How to test locally
```bash
docker compose up --build
# http://localhost:8080 — stub login → Tarifabfrage
# Optional closed stub:
# STUB_EMAIL=you@example.com STUB_PASSWORD=change-me docker compose up --build
docker compose down
```

## Still needed for Cloud Run (human / ops)
1. Configure GitHub secrets: `GCP_WORKLOAD_IDENTITY_PROVIDER`, `GCP_SERVICE_ACCOUNT`
2. Configure vars: Artifact Registry repo, optional `INSTANCE_CONNECTION_NAME`, `CLOUD_SQL_ATTACH=true` when instance exists, Secret Manager mapping for `DB_PASSWORD`
3. Confirm existing users table/columns for `AUTH_MODE=db` (`DB_USERS_*`)
4. Push git tag **`v0.0.1`** (do not invent instance name; do not treat Actions green as proven until that run succeeds)

## Human acceptance
**Accepted by:**
**Date:**
