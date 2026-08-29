# Clarifications

Log every human touchpoint here, in order: business sign-off, and any
`blocked` question/answer regardless of which state raised it.

## 2026-08-29 — discovery — asked by: delivery-planner
**Question:** What is the MySQL **database name** on Cloud SQL instance `bestmodal-492819:europe-west1:bestmodal2-sandbox-mysql` that Multimodalis should use? (`.env.example` currently samples `bestmodal` — confirm or correct; do not invent.)

**Answer:** Not provided this round. Use placeholders in `.env.example` and GitHub Environment secret/variable *names* only — do not invent real DB name values. Exact value to be supplied by operators when creating GitHub Environment `sandbox` secrets/vars (and local `.env`).

**Decided by:** human
**Date:** 2026-08-29

## 2026-08-29 — discovery — asked by: delivery-planner
**Question:** What **DB user** should local Multimodalis and Cloud Run `multimodalis` use against the sandbox instance? One shared user for both, or separate users? (Do not invent credentials.)

**Answer:** Not provided this round. Same as DB name — placeholders / secret *names* only; operators supply real user when configuring GitHub Environment `sandbox` and local `.env`. Local + Cloud Run both target the same sandbox instance this slice.

**Decided by:** human
**Date:** 2026-08-29

## 2026-08-29 — discovery — asked by: delivery-planner
**Question:** How should the DB password be stored and injected — Secret Manager secret id(s), Cloud Run secret mount / env mapping, and local `.env` only (gitignored)? Confirm no secrets belong in git or workflow YAML.

**Answer:** Sandbox DB credentials must also be available as **GitHub Actions environment** config. Create/use GitHub Environment named **`sandbox`** (variables/secrets scoped there). **`production`** environment later — out of this slice. No secrets in git or workflow YAML literals; local `.env` gitignored. (Exact Secret Manager ids / Cloud Run secret mounts for login attach deferred with Cloud Run SQL attach / AUTH_MODE=db.)

**Decided by:** human
**Date:** 2026-08-29

## 2026-08-29 — discovery — asked by: delivery-planner
**Question:** For `AUTH_MODE=db`, which **existing** table and columns hold login email and password hash? Confirm hash format is compatible with PHP `password_verify`. (App already reads `DB_USERS_TABLE` / `DB_USERS_EMAIL_COLUMN` / `DB_USERS_PASSWORD_HASH_COLUMN` — do not invent schema.)

**Answer:** Defer until after a **Better Auth assessment**. This slice is **not** wiring login to DB users. Connectivity / non-login DB use only as needed; login stays stub (or unchanged) until that later assessment.

**Decided by:** human
**Date:** 2026-08-29

## 2026-08-29 — discovery — asked by: delivery-planner
**Question:** What is the required **local Cloud SQL Auth Proxy** setup for developers (install/IAM, listen on `127.0.0.1:3306`, Compose via `host.docker.internal` vs app on host)? Document-only guidance, or mandatory for verifying this work item?

**Answer:** Proceed with recommended **Cloud SQL Auth Proxy** → `127.0.0.1:3306`, app `DB_DSN_MODE=tcp`. Explicitly **test that this option is feasible** (document how to run proxy + prove a simple DB connection from local app or a one-off script — not inventing login auth).

**Decided by:** human
**Date:** 2026-08-29

## 2026-08-29 — discovery — asked by: delivery-planner
**Question:** Confirm Cloud Run should attach with `--add-cloudsql-instances=bestmodal-492819:europe-west1:bestmodal2-sandbox-mysql` (or equivalent) and which **runtime service account** roles (Cloud SQL Client, Secret Manager accessor) must be granted.

**Answer:** If that step is **login-related**, **defer** it. Prefer: prove sandbox connectivity locally first; Cloud Run Cloud SQL attach / AUTH_MODE=db login flip deferred with Better Auth. Still may prepare deploy env scaffolding for sandbox environment vars without flipping login to db. Runtime SA: **B** — create dedicated **`multimodalis-run`** service account (like ratecardwiz pattern), grant Cloud SQL Client as needed when attach is later enabled.

**Decided by:** human
**Date:** 2026-08-29

## 2026-08-29 — discovery — asked by: delivery-planner
**Question:** When should Cloud Run (and documented local defaults) flip `AUTH_MODE` from `stub` to `db` — immediately with this wiring, staged after login proves against sandbox rows, or keep stub as an explicit fallback env?

**Answer:** Defer until after a **Better Auth assessment**. This slice is **not** wiring login to DB users; login stays stub (or unchanged). Cloud Run AUTH_MODE=db flip deferred with Better Auth / Cloud SQL attach.

**Decided by:** human
**Date:** 2026-08-29

## 2026-08-29 — discovery — asked by: delivery-planner
**Question:** How should this wiring ship via GitHub Actions — update the existing tag `v0.0.1` deploy workflow only, introduce a new tag, or rely on `workflow_dispatch` for the Cloud SQL attach / env / secrets change? (`GCP_SA_KEY` is already configured.)

**Answer:** Sandbox DB credentials / vars via GitHub Environment named **`sandbox`**. Prepare deploy env scaffolding for sandbox environment vars without flipping login to db / without requiring Cloud Run SQL attach this slice. **`production`** environment later — out of this slice. (Exact tag vs dispatch cadence may follow existing deploy path; secrets/vars scoped to Environment `sandbox`.)

**Decided by:** human
**Date:** 2026-08-29

## 2026-08-29 — business_clarification — asked by: human (chat)
**Question:** Who uses which DB this slice? Local vs Cloud Run vs prod?

**Answer:** Confirmed — local + Cloud Run `multimodalis` target **sandbox** MySQL instance only this slice: `bestmodal-492819:europe-west1:bestmodal2-sandbox-mysql`.

**Decided by:** human
**Date:** 2026-08-29

## 2026-08-29 — business_clarification — sign-off
**Decision:** Requirements to be updated to **approved** reflecting the answers above (Auth Proxy local feasibility test; GitHub Environment `sandbox`; no DB login auth this slice; Cloud Run SQL attach / AUTH_MODE=db deferred; dedicated `multimodalis-run` SA; sandbox instance only). Proceed to UX → Architecture → Plan → Implementation → Verification.

**Decided by:** human
**Date:** 2026-08-29

## 2026-08-29 — blocked (implementation) — asked by: implementer
**Question:** Please supply operator MySQL credentials for `bestmodal-492819:europe-west1:bestmodal2-sandbox-mysql` into a local gitignored `.env` (`DB_NAME`, `DB_USER`, `DB_PASSWORD`) and optionally GitHub Environment `sandbox` (same names as secrets/vars). Confirm when filled so Implementer can re-run Auth Proxy + `php scripts/check-db-connection.php` and record live proof. Do not invent values in-repo.

**Answer:** Credentials discovered via deployer SA probe (human authorized self-check):
- Instance: `bestmodal-492819:europe-west1:bestmodal2-sandbox-mysql`
- `DB_NAME=bestmodal2`
- `DB_USER=bestmodal`
- Password is **not** on Cloud SQL API; it lives in Secret Manager: `projects/bestmodal-492819/secrets/bestmodal2-sandbox-database-url` (MySQL URL form). Deployer SA can access the secret.
- Live Auth Proxy + that secret already proved `SELECT 1`. **Never** print/commit the password value.
- Implementer may set GitHub Environment `sandbox` vars/secrets from these values (password via `gcloud secrets versions access` piped to `gh secret set` — no echo), document SM → local `.env` without committing `.env`, and finish remaining scaffolding. Still no `AUTH_MODE=db`, no `--add-cloudsql-instances`.

**Decided by:** human (probe + chat confirmation)
**Date:** 2026-08-29
