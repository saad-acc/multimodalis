# Implementation Plan

Work item: `00005-cloudsql-sandbox-connection`  
Inputs: `architecture.md`, `ux-spec.md`, approved `requirements.md`  
Slice: infra / connectivity — no product UI, no Better Auth, no `AUTH_MODE=db`, no Cloud Run SQL attach.

**Blocked-on-secrets rule:** If live Auth Proxy proof needs real `DB_NAME` / `DB_USER` / `DB_PASSWORD` and they are missing from local `.env` (and/or Environment `sandbox`), the Implementer **MUST NOT** invent credentials. Complete scaffolding/docs/SA/Environment wiring; for the live proof task, set work item `blocked` with `resume_state: implementation` (or note blocked-on-secrets in `implementation-log.md` / verification) per NFR6 — do not fake success.

---

## Deferred (explicit — do not implement this slice)

| Deferred item | Traces to |
| --- | --- |
| Better Auth assessment / implementation | FR4, FR7, NFR7; architecture “In scope vs deferred” |
| DB login / `AUTH_MODE=db` / `DB_USERS_*` / users-table mapping | FR4, FR7; UX “no login UX change” |
| Cloud Run `--add-cloudsql-instances` / Unix-socket PDO for login attach | FR7; architecture Cloud Run section |
| Grant `roles/cloudsql.client` on `multimodalis-run` (until attach enabled) | FR8, NFR5 |
| Secret Manager → Cloud Run secret mounts for DB password | FR5 clarifications; architecture Secrets/CI |
| GitHub Environment `production` / prod Cloud SQL | FR5, NFR7; out of scope |
| Replacing `GCP_SA_KEY` with WIF | architecture rejected alternatives |

Verification of this slice **MUST** confirm login still stub/unchanged and deploy has **no** `--add-cloudsql-instances` and **no** `AUTH_MODE=db`.

---

## Tasks

| # | Task | Traces to | Depends on |
|---|---|---|---|
| 1 | **Env contract docs — Auth Proxy local.** Update `.env.example`: set non-secret `INSTANCE_CONNECTION_NAME=bestmodal-492819:europe-west1:bestmodal2-sandbox-mysql`; keep `DB_DSN_MODE=tcp`, `DB_HOST=127.0.0.1`, `DB_PORT=3306`; replace sample `DB_NAME=bestmodal` / `DB_USER=app` with empty or clearly marked placeholders (ops fill); document GitHub Environment `sandbox` key *names* (`INSTANCE_CONNECTION_NAME`, `DB_NAME`, `DB_USER`, `DB_PASSWORD`); state Auth Proxy local path and that DB login / Cloud Run attach are deferred. Do not embed real passwords or invent real DB name/user values. | FR1, FR2, FR6, FR9, NFR1; architecture “Components / `.env.example`”, “Env contract”; UX developer flow | — |
| 2 | **README — decouple connectivity from login.** Rewrite Auth Proxy / sandbox DB section so mandatory local feasibility is: proxy on `127.0.0.1:3306` → TCP env → simple connection proof, with `AUTH_MODE=stub` unchanged. Remove or correct guidance that couples Auth Proxy to `AUTH_MODE=db` / `DB_USERS_*`. Document Compose note: if app in Docker and proxy on host, `DB_HOST=host.docker.internal`. Mark Compose MySQL as optional fallback only. Explicitly list deferred: Better Auth, DB login, Cloud Run SQL attach, production env. | FR2, FR3, FR4, FR7, FR9, NFR3, NFR6; architecture risks (README coupling); UX developer + deferral notes | 1 |
| 3 | **Connectivity proof script (not login).** Add a small CLI (architecture preference: `scripts/check-db-connection.php`) that loads existing `config` + `db_pdo()`, runs `SELECT 1` (optional thin `db_ping()` helper in `db.php` only if it clarifies the script — no second DB client), prints success/failure, exits non-zero on failure. **Must not** call `db_find_user_password_hash()`, flip `AUTH_MODE`, or hit users-table mapping. Document how to run it in README (task 2) / script header. | FR3, FR4, NFR4, NFR6; architecture “New / connectivity proof”, “Feasibility test approach”; UX developer flow | 1 |
| 4 | **Auth Proxy feasibility — document + prove (or block).** Document exact local steps: authenticate to GCP as needed for proxy; start Auth Proxy for **only** `bestmodal-492819:europe-west1:bestmodal2-sandbox-mysql` listening on `127.0.0.1:3306` (e.g. `cloud-sql-proxy … --port 3306`; binary/flags in docs); fill local `.env` from placeholders; run task-3 script. **Live proof:** if operator secrets are present, run and record success in `implementation-log.md`. **If secrets missing:** do not invent values; set `blocked` (or document blocked-on-secrets) rather than claiming proof. Leave product login on stub. | FR2, FR3, NFR3, NFR6; architecture “Local topology”, “Feasibility test approach”; UX error/blocked states | 2, 3 |
| 5 | **GitHub Environment `sandbox` scaffolding (names only).** Document required Environment **`sandbox`** variable/secret *names* (e.g. var `INSTANCE_CONNECTION_NAME`; var or secret `DB_NAME` / `DB_USER`; secret `DB_PASSWORD` — match `.env.example` / architecture). Update `.github/workflows/deploy.yml` so the deploy job references `environment: sandbox` and uses `${{ vars.* }}` / `${{ secrets.* }}` *by name only* for any DB scaffolding. **MUST NOT** put password literals, invent real DB name/user, or configure Environment `production`. Creating the GitHub Environment UI and filling live secret *values* is ops-owned; if values are absent, scaffolding/docs still complete — live deploy secret use may note blocked-on-secrets. | FR5, FR6, NFR1, NFR6; architecture “Secrets / CI”; UX operator flow | 1 |
| 6 | **Create runtime SA `multimodalis-run` (or document IAM gap).** Create dedicated Cloud Run runtime SA `multimodalis-run` in project `bestmodal-492819` (email `multimodalis-run@bestmodal-492819.iam.gserviceaccount.com`) via gcloud/console, following ratecardwiz pattern (deployer ≠ runtime). **Do not** grant Cloud SQL Client this slice. If the Implementer’s deployer identity cannot create the SA, document the exact create command / IAM needed and treat SA creation as blocked-on-ops (do not invent broader roles or SA keys in git). | FR8, NFR5, NFR6; architecture “Runtime service account”; UX operator flow | — |
| 7 | **Optional deploy scaffolding — no attach / no db auth flip.** Optionally: pass non-secret `INSTANCE_CONNECTION_NAME` (and/or Environment `sandbox` refs) into Cloud Run deploy env; optionally set `--service-account=multimodalis-run@bestmodal-492819.iam.gserviceaccount.com`. **MUST keep** `AUTH_MODE=stub`. **MUST NOT** add `--add-cloudsql-instances`, mount DB password for login, or set `AUTH_MODE=db`. Keep existing `GCP_SA_KEY` deploy auth. | FR1, FR5, FR7, FR8, NFR2; architecture “Cloud Run (deferred attach; optional scaffolding)” | 5, 6 |
| 8 | **Sanity check — deferred scope + secrets hygiene.** Confirm: no real secrets in git/workflow YAML; `.env` still gitignored; login path untouched (`auth.php` / stub behavior); no Better Auth; no production env; verification notes can demonstrate NFR6 (a)–(e) or blocked-on-secrets for (b). Record outcomes in `implementation-log.md`. | FR4, FR6, FR7, FR10, NFR1, NFR6, NFR7; architecture conformance / rejected alternatives; UX “no product UI” | 2, 4, 5, 6, 7 |

Each task is small enough for the Implementer to verify independently. No task invents scope beyond requirements / architecture / UX.

---

## Suggested order (critical path)

```
1 → 2 → 3 → 4 (live proof may block on secrets)
1 → 5 ─┐
6 ──────┼→ 7 → 8
```

Tasks 1, 5, and 6 can start in parallel after plan handoff. Task 4’s *documentation* can complete without secrets; *live proof* may block. Task 7 is optional scaffolding but, if done, must respect attach/`AUTH_MODE` forbids.

---

## Human / ops gates (may block Implementer)

| Gate | Affects task(s) | Implementer action if unmet |
| --- | --- | --- |
| Real `DB_NAME` / `DB_USER` / `DB_PASSWORD` in local `.env` | 4 (live proof) | Blocked-on-secrets; do not invent |
| Same values in GitHub Environment `sandbox` | 5 (live secret *values*; refs OK without) | Scaffold names + workflow refs; ops fills values |
| Permission to create SA `multimodalis-run` | 6 | Document IAM/create steps; blocked-on-ops if cannot create |
| GCP auth for Auth Proxy | 4 | Document; blocked if identity/proxy cannot run |

Scaffolding, docs, workflow Environment binding, and placeholder hygiene are **not** blocked by missing secret *values*.
