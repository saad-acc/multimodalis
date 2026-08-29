# Verification Report

Work item: `00005-cloudsql-sandbox-connection`  
Verifier: implementer (self-check)  
Date: 2026-08-29

## Automated
| Check | Command | Result |
|---|---|---|
| PHP lint (touched) | `php -l public/includes/db.php`; `php -l scripts/check-db-connection.php`; `php -l public/includes/auth.php`; `php -l public/includes/config.php` | **pass** |
| Shell lint | `bash -n scripts/sync-sandbox-db-env-from-sm.sh` | **pass** |
| Compose config | `docker compose config -q` | **pass** |
| Unit/integration test suite | none in repo (`package.json` / PHPUnit / Makefile absent) | **n/a** |
| Scope: no Cloud SQL attach flag | grep `--add-cloudsql-instances` in `deploy.yml` (comments/forbids only; not a deploy arg) | **pass** |
| Scope: stub auth on deploy | `set-env-vars=…AUTH_MODE=stub…`; no `AUTH_MODE=db` | **pass** |
| Scope: no password mount | `secrets.DB_PASSWORD` unused in workflow; `.env.example` has empty `DB_PASSWORD=` | **pass** |
| Secrets hygiene | `.env` gitignored and untracked | **pass** |
| GHA Environment `sandbox` | `gh variable list` / `gh secret list --env sandbox` | **pass** (vars set; secret `DB_PASSWORD` present by name) |
| Runtime SA | `gcloud iam service-accounts describe multimodalis-run@bestmodal-492819.iam.gserviceaccount.com` | **pass** |

## Conformance
- vs. `architecture.md`: **match** (Auth Proxy TCP + connectivity script + Environment `sandbox` + `multimodalis-run`; no attach / no `AUTH_MODE=db`; reuse `db_pdo()` / optional `db_ping()`). Minor reconciled drift: architecture originally required empty `DB_NAME`/`DB_USER` placeholders in git; clarifications later supplied non-secret `bestmodal2` / `bestmodal`, which `.env.example` / docs now record — password still never in git. SM used for **local** password fetch / GHA secret fill; Cloud Run SM mounts remain deferred.
- vs. `ux-spec.md`: **match** — no product UI change; login chrome untouched; developer/ops docs + CLI only.
- vs. accepted `knowledge/decisions/`: **n/a** (no `accepted` ADRs yet). Proposed ADRs / anti-pattern for this item followed: env-based sandbox targets, Unix-socket attach deferred, GHA Environment `sandbox`, dedicated runtime SA, invent-credentials anti-pattern honored.

## Live verification
| Feature (`knowledge/features/`) | Driven? | Evidence |
|---|---|---|
| [sandbox-db-connectivity.md](../../knowledge/features/sandbox-db-connectivity.md) | **proven** | `knowledge/features/evidence/00005-cloudsql-sandbox-connection/select1-proof.log` — `OK: SELECT 1 succeeded via db_pdo() (DB_DSN_MODE=tcp, 127.0.0.1:3306, db=bestmodal2).` exit=0; password not printed |
| Deploy scope (infra check) | **proven** | `…/deploy-scope-check.log` — `AUTH_MODE=stub` in `set-env-vars`; no attach flag |
| [login.md](../../knowledge/features/login.md) (regression: stub unchanged) | **proven** | `…/01-login.html` title Login Multimodalis HTTP 200; `compose-auth-mode.log` = `stub`; `04-success-login.headers` 302 → `page=tariff_query` |
| [tarifabfrage-landing.md](../../knowledge/features/tarifabfrage-landing.md) | **n/a** (not materially changed this item; success redirect only spot-checked via login) | — |

## Documentation hygiene
| Check | Status |
|---|---|
| Flagged `knowledge/` promotions written | **done** (env-based ADR refine; GHA sandbox ADR; multimodalis-run ADR; invent-credentials anti-pattern; cloudsql-sandbox-mysql component; Unix-socket citation) |
| Drift from plan reconciled in `knowledge/` + work-item artifacts | **done** (non-secret DB name/user from clarifications reflected in docs/components; `implementation-log.md` complete) |
| New components captured in `knowledge/components/` | **done** (`cloudsql-sandbox-mysql.md`; `multimodalis-php-app.md` updated for scripts) |
| Feature map (`knowledge/features/`) current for every touched feature | **done** (`sandbox-db-connectivity.md` + harness index link + evidence dir) |
| No dangling question in `clarifications.md` | **done** (all Qs answered, including blocked-on-secrets unblock) |
| `knowledge/log.md` entry per promotion | **done** (2026-08-29 entries including verification-time feature/component updates) |

## Verdict
**pass** → `done` (pending human acceptance)

Scope confirmed: login stub; no `--add-cloudsql-instances`; no password in git/workflow/evidence; Auth Proxy `SELECT 1` proven; GitHub Environment `sandbox` vars/secrets set; Cloud Run SQL attach / Better Auth deferred.

## Human acceptance
**Accepted by:**
**Date:**
