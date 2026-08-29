# Requirements

**Status:** approved
**Approved by:** human
**Approved on:** 2026-08-29

## Business requirement
Enable Multimodalis (local and Cloud Run service `multimodalis`) to reach the existing Cloud SQL MySQL sandbox instance `bestmodal-492819:europe-west1:bestmodal2-sandbox-mysql` for connectivity and non-login DB use, with secrets scoped to GitHub Environment `sandbox` — without wiring login to DB users until a later Better Auth assessment.

## Stakeholder requirements
- **Developers (local):** Can run Cloud SQL Auth Proxy → `127.0.0.1:3306`, configure the app with `DB_DSN_MODE=tcp`, and prove a simple DB connection (app or one-off script) against the sandbox instance using operator-supplied placeholders filled in local `.env`. Offline `AUTH_MODE=stub` remains available; login is not switched to DB this slice.
- **Operators / deployers:** Can place sandbox DB credential *names* and non-secret vars in GitHub Actions Environment **`sandbox`** (no secrets in git or workflow YAML literals); may prepare deploy env scaffolding for sandbox vars. Cloud Run Cloud SQL attach and `AUTH_MODE=db` remain deferred. Dedicated runtime SA **`multimodalis-run`** is created (ratecardwiz pattern), with Cloud SQL Client granted when attach is later enabled.
- **Product / end users (sandbox):** No change to login behavior this slice — login stays stub (or unchanged). DB-backed login is out of scope until Better Auth assessment.
- **Security / compliance:** No real DB passwords or SA private keys in the repository or workflow YAML; real values live only in gitignored local `.env` and GitHub Environment `sandbox` secrets/vars (exact Secret Manager / Cloud Run secret mounts deferred with attach).

## Solution requirements

### Functional
- FR1: **Sandbox target only** — Local Multimodalis and Cloud Run service `multimodalis` **MUST** treat Cloud SQL instance connection name `bestmodal-492819:europe-west1:bestmodal2-sandbox-mysql` (project `bestmodal-492819`, region `europe-west1`) as the sole DB target this slice. Non-secret instance name **MAY** appear in env docs / deploy scaffolding; passwords and invented DB name/user values **MUST NOT**.
- FR2: **Local Auth Proxy path** — Local Multimodalis **MUST** be able to open a MySQL connection via the existing TCP PDO path (`DB_DSN_MODE=tcp`, `DB_HOST=127.0.0.1`, `DB_PORT=3306`) when Cloud SQL Auth Proxy listens on `127.0.0.1:3306` for that instance — without inventing a new connection stack.
- FR3: **Local feasibility test (mandatory)** — Docs / verification for this item **MUST** include how to: (a) run Cloud SQL Auth Proxy against `bestmodal-492819:europe-west1:bestmodal2-sandbox-mysql` on `127.0.0.1:3306`; (b) prove a **simple DB connection** from the local app or a one-off script using operator-supplied env (placeholders until filled). This proof is **connectivity only** — **MUST NOT** invent or exercise DB login auth / users-table mapping.
- FR4: **No DB login auth this slice** — `AUTH_MODE=db`, users-table mapping (`DB_USERS_*`), and login against sandbox user rows are **deferred** until after a Better Auth assessment. Login **MUST** stay stub (or unchanged). Connectivity / non-login DB use only as needed.
- FR5: **GitHub Environment `sandbox`** — Sandbox DB credentials and related config **MUST** be supplied via GitHub Actions Environment named **`sandbox`** (variables/secrets scoped there). Placeholder secret/variable *names* in docs/workflow references are OK; real DB name, user, and password **MUST NOT** be invented or committed. Environment **`production`** is out of scope.
- FR6: **Secrets hygiene in deploy artifacts** — Workflow YAML and committed files **MUST NOT** contain real `DB_PASSWORD`, DB user passwords, or SA private keys — only secret/var *references* (or placeholders) for Environment `sandbox`. Local `.env` remains gitignored.
- FR7: **Cloud Run preference & deferral** — Prefer proving sandbox connectivity **locally first**. Cloud Run `--add-cloudsql-instances` and `AUTH_MODE=db` login flip are **deferred** with Better Auth. This slice **MAY** prepare deploy env scaffolding for sandbox environment vars **without** attaching Cloud SQL for login or flipping `AUTH_MODE` to `db`.
- FR8: **Runtime service account** — Create dedicated Cloud Run runtime service account **`multimodalis-run`** (ratecardwiz pattern). Grant **Cloud SQL Client** when Cloud SQL attach is later enabled — not required to enable login attach in this slice.
- FR9: **Docs** — README / `.env.example` (or equivalent) **MUST** document: Auth Proxy local path (`127.0.0.1:3306`, `DB_DSN_MODE=tcp`), instance connection name, placeholder env key *names* for GitHub Environment `sandbox` / local `.env`, and that DB login / Cloud Run SQL attach are deferred — **without** embedding real passwords or invented DB name/user values.
- FR10: **External systems** — This work item **MUST NOT** require changes to the external Sandbox BestModal v1 app at sandbox.bestmodal.de, invent credentials, or invent a users schema.

### Non-functional
- NFR1: **Secrets hygiene** — No real `DB_PASSWORD`, Cloud SQL user passwords, or SA private keys in git, workflow YAML literals, or committed `.env`. Verification: repo scan / review shows only placeholders and Environment `sandbox` secret/var *names*.
- NFR2: **Hosting / DB scope** — Cloud Run target remains service `multimodalis`, project `bestmodal-492819`, region `europe-west1`; database is Cloud SQL MySQL instance `bestmodal2-sandbox-mysql` in that project/region for **both** local and Cloud Run this slice.
- NFR3: **Local connector posture** — Primary local sandbox path is Auth Proxy → TCP `127.0.0.1:3306`. Compose MySQL remains optional fallback only, not the primary sandbox path. Cloud Run Unix-socket attach remains the intended later path (per prior ADR) but is **not** required for acceptance of this slice’s login-related attach.
- NFR4: **Reuse over rewrite** — Prefer configuring existing `public/includes/{config,db,auth}.php` and deploy/env scaffolding over introducing a parallel DB client.
- NFR5: **Least privilege (ops)** — Runtime SA `multimodalis-run` **MUST** be created for future use; Cloud SQL Client granted when attach is later enabled. No broader roles invented beyond that need.
- NFR6: **Verifiability (this slice)** — A human can demonstrate: (a) Auth Proxy running for the named instance on `127.0.0.1:3306`; (b) a simple local DB connection proof (app or one-off script) once operators have filled placeholder secrets — **or** documented blocked-on-secrets if live values are not yet in Environment `sandbox` / local `.env`; (c) GitHub Environment `sandbox` scaffolding / references exist without secrets in YAML; (d) `multimodalis-run` SA created (or creation steps executed); (e) login still stub/unchanged — **no** requirement to prove Cloud Run SQL attach or `AUTH_MODE=db` login this slice.
- NFR7: **Out of scope floors** — No Better Auth implementation, no DB login wiring, no forgot-password, no user admin UI, no production environment, no Tarifabfrage live search/data features beyond incidental non-login connectivity needs.

## Out of scope
- Better Auth assessment or implementation.
- Wiring login to DB (`AUTH_MODE=db`, users-table / column mapping, `password_verify` against sandbox rows).
- Cloud Run `--add-cloudsql-instances` / Unix-socket attach when that step is login-related (deferred with Better Auth); may still scaffold non-attach sandbox env vars.
- GitHub Environment **`production`** and any prod Cloud SQL instance.
- Inventing or committing real DB name, user, password, or SA private keys.
- Inventing or migrating a users schema / user CRUD.
- Changing product branding or login UX chrome.
- Replacing `GCP_SA_KEY` deploy auth (already configured).

## Operator-supplied values (not blocking approval)
These are **answered as “placeholders until operators supply”** (clarifications 2026-08-29). They do **not** block requirements approval. Implementation **MUST NOT** invent real values. Live Auth Proxy connection proof may be **blocked at implementation/verification** until operators fill:

| Value | Where it goes | Doc treatment |
| --- | --- | --- |
| MySQL database name | GitHub Environment `sandbox` + local `.env` | Placeholder name only (e.g. env key `DB_NAME`) |
| MySQL user | Same | Placeholder name only (e.g. env key `DB_USER`) |
| MySQL password | Same (secret) | Placeholder / secret *name* only; never in git or workflow YAML |

Exact Secret Manager ids and Cloud Run secret mounts for login attach remain deferred with Cloud Run SQL attach / `AUTH_MODE=db`.

## Clarifications resolved (2026-08-29)
No open questions remain that block approval. Human decisions recorded in `clarifications.md`:

1. **DB name / user / password** — Placeholders only; operators supply via Environment `sandbox` and local `.env`.
2. **Password storage this slice** — GitHub Environment `sandbox`; no secrets in git/YAML; Secret Manager / Cloud Run mounts deferred with attach.
3. **Users table / `AUTH_MODE=db`** — Deferred until Better Auth assessment; no DB login this slice.
4. **Local Auth Proxy** — Proceed with Proxy → `127.0.0.1:3306`, `DB_DSN_MODE=tcp`; **mandatory feasibility test** (document + prove simple connection).
5. **Cloud Run attach + SA** — Login-related attach deferred; create `multimodalis-run`; grant Cloud SQL Client when attach later enabled; may scaffold sandbox env vars without flip.
6. **`AUTH_MODE` flip** — Deferred with Better Auth; login stays stub/unchanged.
7. **Deploy / CI** — Credentials via Environment `sandbox`; `production` out of scope; deploy scaffolding OK without SQL attach / db login.
8. **Who uses which DB** — Local + Cloud Run `multimodalis` → sandbox instance only this slice.
