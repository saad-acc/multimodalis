# Architecture

Work item: `00005-cloudsql-sandbox-connection`  
Inputs: approved `requirements.md`, `ux-spec.md`, `clarifications.md`  
Prior art: [`00001-v2-php-cloudrun-login/architecture.md`](../00001-v2-php-cloudrun-login/architecture.md) (PDO + env contract already shipped).  
Knowledge: proposed ADRs [Env-based DB targets](../../knowledge/decisions/env-based-db-targets.md), [Cloud SQL Unix socket on Cloud Run](../../knowledge/decisions/cloud-sql-unix-socket-on-cloudrun.md); component [Cloud SQL sandbox MySQL](../../knowledge/components/cloudsql-sandbox-mysql.md). No `accepted` ADRs or architecture anti-patterns yet. Session-auth pattern is **out of scope** (login stays stub).

Slice type: **infra / connectivity** — no product UI, no Better Auth, no `AUTH_MODE=db` flip.

---

## In scope vs deferred (architectural)

| Decision | This slice | Deferred (later / Better Auth) |
| --- | --- | --- |
| Sandbox instance as sole DB target | **In scope** — `bestmodal-492819:europe-west1:bestmodal2-sandbox-mysql` for local + Cloud Run `multimodalis` | Prod instance / GitHub Environment `production` |
| Local Auth Proxy → TCP `127.0.0.1:3306`, `DB_DSN_MODE=tcp` | **In scope** (mandatory feasibility path) | — |
| Simple DB connectivity proof (no login) | **In scope** (docs + script/app path) | Users-table login proof |
| GitHub Environment `sandbox` for DB var/secret *names* | **In scope** | Secret Manager → Cloud Run secret mounts for login attach |
| Create runtime SA `multimodalis-run` | **In scope** | Grant **Cloud SQL Client** when attach enabled |
| Deploy env scaffolding (non-secret instance name / stub auth) | **May** | — |
| Cloud Run `--add-cloudsql-instances` / Unix-socket PDO on service | **Deferred** | Enable with attach + Client role |
| `AUTH_MODE=db` / `DB_USERS_*` / Better Auth | **Deferred** | After Better Auth assessment |
| Invented credentials or schema | **Forbidden** | Ops supply real values out-of-band |

**Blocked?** Not for architecture. Live Auth Proxy proof may be **blocked-on-secrets** at implementation/verification until operators fill `DB_NAME` / `DB_USER` / `DB_PASSWORD` in local `.env` and Environment `sandbox` — document that; do not invent values.

---

## Components

### Extend (no parallel DB stack)

| Piece | Change this slice |
| --- | --- |
| `public/includes/config.php` | No contract change required. Keep env keys: `DB_DSN_MODE`, `DB_HOST`/`DB_PORT`, `INSTANCE_CONNECTION_NAME`, `DB_NAME`/`DB_USER`/`DB_PASSWORD`. Leave `AUTH_MODE` default/stub on documented Cloud Run path. |
| `public/includes/db.php` | **Reuse** `db_pdo()` for connectivity proof. Do **not** call `db_find_user_password_hash()` for this item’s acceptance. Optional tiny helper (e.g. `db_ping()` → `SELECT 1`) only if it clarifies the proof script — not a second client. |
| `public/includes/auth.php` | **Unchanged** — login stays stub / existing behavior. |
| `.env.example` | Set `INSTANCE_CONNECTION_NAME=bestmodal-492819:europe-west1:bestmodal2-sandbox-mysql` (non-secret). Replace sample `DB_NAME=bestmodal` / `DB_USER=app` with **empty or clearly marked placeholders** (ops fill). Document GitHub Environment `sandbox` key *names*. State Auth Proxy local path + deferred attach/login. |
| `README.md` | Document mandatory local feasibility steps; decouple connectivity proof from `AUTH_MODE=db` (today’s README wrongly couples them). |
| `docker-compose.yml` | Keep TCP defaults + Auth Proxy / `host.docker.internal` comments; Compose MySQL profile remains optional fallback only. Default `AUTH_MODE=stub`. |
| `.github/workflows/deploy.yml` | Bind deploy job to GitHub Environment **`sandbox`**. Reference DB-related vars/secrets by *name* only. May scaffold non-secret env (e.g. `INSTANCE_CONNECTION_NAME`) and/or attach runtime SA `multimodalis-run`. **Do not** add `--add-cloudsql-instances`, **do not** set `AUTH_MODE=db`, **do not** embed password literals. Keep existing `GCP_SA_KEY` deploy auth (out of scope to replace). |
| Docs / ops notes | Steps to create SA `multimodalis-run` (ratecardwiz-style dedicated runtime SA); note Cloud SQL Client granted **when attach is later enabled**. |

### New (minimal)

| Piece | Role |
| --- | --- |
| One-off connectivity proof | Prefer a small CLI under e.g. `scripts/check-db-connection.php` (or Compose `php -r` / documented `php scripts/...`) that loads `config` + `db_pdo()`, runs `SELECT 1`, prints success/failure, exits non-zero on failure. **Not** a product page; **not** login. |

### External / unchanged products

- Cloud SQL instance `bestmodal2-sandbox-mysql` (existing) — no schema migrations.
- Cloud Run service `multimodalis` — remains `AUTH_MODE=stub` for end users.
- Sandbox BestModal v1 (`sandbox.bestmodal.de`) — no changes (FR10).

---

## Local topology (FR2, FR3, NFR3)

```
Developer machine
  ┌─────────────────────────────┐
  │ Cloud SQL Auth Proxy        │
  │ listen 127.0.0.1:3306       │
  │ → bestmodal-492819:         │
  │   europe-west1:             │
  │   bestmodal2-sandbox-mysql  │
  └─────────────┬───────────────┘
                │ TCP MySQL
  ┌─────────────▼───────────────┐
  │ App (host PHP or Compose)   │
  │ DB_DSN_MODE=tcp             │
  │ DB_HOST=127.0.0.1           │
  │ DB_PORT=3306                │
  │ (+ DB_NAME/USER/PASSWORD    │
  │    from local .env)         │
  │ AUTH_MODE=stub (unchanged)  │
  └─────────────────────────────┘
```

**Compose note:** If the app runs in Docker and the proxy on the host, set `DB_HOST=host.docker.internal` (already commented in `docker-compose.yml`). Prefer proving with host-run PHP or documented Compose + `host.docker.internal` — same PDO TCP path.

### Feasibility test approach (mandatory)

1. Operator/developer authenticates to GCP as needed for Auth Proxy (IAM already used for deploy; do not invent SA keys in git).
2. Start proxy for **only** this instance on `127.0.0.1:3306`, e.g.  
   `cloud-sql-proxy bestmodal-492819:europe-west1:bestmodal2-sandbox-mysql --port 3306`  
   (exact binary/flags left to Implementer docs; listen address/port fixed by requirements).
3. Fill local `.env` from placeholders (`DB_NAME`, `DB_USER`, `DB_PASSWORD`) — never commit.
4. Run connectivity proof script → `db_pdo()` + `SELECT 1`.
5. Leave product login on stub; do **not** set `AUTH_MODE=db` or exercise `DB_USERS_*`.

If secrets are missing: document **blocked-on-secrets** for live proof; scaffolding/docs/SA/Environment wiring can still complete.

---

## Secrets / CI (FR5, FR6, NFR1)

| Location | What lives there |
| --- | --- |
| Git (`.env.example`, README, workflow YAML) | Key *names*, non-secret instance connection name, comments — **no** passwords, no SA private keys, no invented real DB name/user values presented as truth |
| Local `.env` (gitignored) | Operator-supplied `DB_*` for Auth Proxy proof |
| GitHub Environment **`sandbox`** | Variables/secrets for sandbox DB config (e.g. var `INSTANCE_CONNECTION_NAME`, var or secret `DB_NAME` / `DB_USER`, secret `DB_PASSWORD` — exact names documented; values ops-owned) |
| GitHub Environment **`production`** | **Out of scope** |
| Secret Manager / Cloud Run secret mounts | **Deferred** with Cloud SQL attach / `AUTH_MODE=db` |

Workflow: `jobs.deploy.environment: sandbox` so `${{ vars.* }}` / `${{ secrets.* }}` for DB scaffolding resolve from that Environment. Deployer secret `GCP_SA_KEY` may remain repo-level as today (already configured; replacing with WIF is out of scope).

---

## Runtime service account (FR8, NFR5)

**Create** dedicated Cloud Run runtime SA **`multimodalis-run`** in project `bestmodal-492819` (email form `multimodalis-run@bestmodal-492819.iam.gserviceaccount.com`), following the ratecardwiz pattern: **deployer** SA (`GCP_SA_KEY`) ≠ **runtime** SA.

This slice:

- Create the SA (gcloud / console / documented one-shot in Implementer plan).
- Optionally point Cloud Run service `--service-account=multimodalis-run@…` during deploy scaffolding.
- **Do not** require `roles/cloudsql.client` until `--add-cloudsql-instances` is enabled later.
- No broader roles invented for this item.

---

## Cloud Run (deferred attach; optional scaffolding)

**Intended later path** (binding proposed ADR, not executed this slice): native Unix socket at `/cloudsql/bestmodal-492819:europe-west1:bestmodal2-sandbox-mysql` via `--add-cloudsql-instances=…`, `DB_DSN_MODE=socket`, runtime SA with Cloud SQL Client — per [Cloud SQL Unix socket on Cloud Run](../../knowledge/decisions/cloud-sql-unix-socket-on-cloudrun.md).

**This slice may:**

- Document the instance connection name on the service as non-secret env scaffolding.
- Keep `AUTH_MODE=stub` and `APP_ENV` / `ENVIRONMENT` labels as today.
- Assign `multimodalis-run` as runtime identity.

**This slice must not:**

- Enable Cloud SQL attach for login.
- Flip `AUTH_MODE` to `db`.
- Mount DB password secrets solely to unlock login (Secret Manager mapping deferred with attach).

---

## Data model

- **No migrations, no new tables, no invented users schema.**
- Connectivity proof uses whatever database name ops put in `DB_NAME` — Architecture does not name it.
- Session/auth state unchanged (stub login).
- No data-model ADR beyond “reuse existing Cloud SQL content when later slices need it.”

---

## Integration points

| Boundary | Contract |
| --- | --- |
| App ↔ MySQL (local) | PDO TCP via Auth Proxy; env `DB_DSN_MODE=tcp`, host/port `127.0.0.1:3306`; credentials from `.env` |
| App ↔ MySQL (Cloud Run, later) | PDO Unix socket `/cloudsql/${INSTANCE_CONNECTION_NAME}`; attach + Client role — **deferred** |
| Auth Proxy ↔ Cloud SQL | Instance connection name only; IAM of the identity running the proxy |
| GHA ↔ GCP deploy | Existing `GCP_SA_KEY`; Environment `sandbox` for DB-scoped config *names* |
| GHA ↔ Cloud Run | Deploy image; stub env; optional runtime SA + non-secret instance name; no attach this slice |
| Humans / ops | Supply real `DB_NAME` / `DB_USER` / `DB_PASSWORD` into Environment `sandbox` + local `.env` |

---

## Env contract (names only)

| Variable | This slice |
| --- | --- |
| `INSTANCE_CONNECTION_NAME` | Fixed non-secret: `bestmodal-492819:europe-west1:bestmodal2-sandbox-mysql` |
| `DB_DSN_MODE` | Local proof: `tcp`; Cloud Run later: `socket` |
| `DB_HOST` / `DB_PORT` | `127.0.0.1` / `3306` (or `host.docker.internal` from Compose) |
| `DB_NAME` / `DB_USER` / `DB_PASSWORD` | Placeholders in git; real values only in `.env` / Environment `sandbox` |
| `AUTH_MODE` | Remain `stub` (local default + Cloud Run) |
| `DB_USERS_*` | Documented as deferred; unused for acceptance |

---

## Risks

| Risk | Door type | Mitigation |
| --- | --- | --- |
| Missing real DB credentials | Reversible / ops gate | Explicit **blocked-on-secrets** for live proof; complete docs, Environment scaffolding, SA creation without inventing values |
| README couples Auth Proxy to `AUTH_MODE=db` | Confusion | Rewrite docs so connectivity proof ≠ login flip |
| Sample `.env.example` `bestmodal`/`app` look “real” | Compliance / NFR1 | Empty or marked placeholders only |
| Creating `multimodalis-run` without Client role | Expected | Document grant-when-attach; avoid premature broad IAM |
| Accidental `--add-cloudsql-instances` or `AUTH_MODE=db` in deploy | Scope creep | Architecture forbids; verification checks stub login + no attach |
| Proxy not reachable from Compose | Reversible | Document `host.docker.internal` or host-run proof script |
| Proposed ADR “Cloud Run → prod” vs this slice “both → sandbox” | Drift | Refine env-based ADR (below); production env still future |

**Security shaping design:** secrets never in git/YAML literals; least-privilege runtime SA; no login against DB until Better Auth assessment.

---

## Rejected alternatives

- **Auth Proxy sidecar / public IP TCP on Cloud Run:** Rejected by proposed Unix-socket ADR; still rejected — and attach itself is deferred this slice.
- **New PDO / mysqli client or ORM for connectivity:** Violates NFR4; reuse `db_pdo()`.
- **Proving connectivity via login / `AUTH_MODE=db`:** Forbidden by FR4; Better Auth gate.
- **Compose MySQL as primary sandbox path:** Conflicts with Auth Proxy preference (NFR3); keep fallback only.
- **Inventing DB name/user/password in docs or workflow:** Forbidden (FR1, FR6, NFR1).
- **GitHub Environment `production` or prod Cloud SQL:** Out of scope.
- **Replacing `GCP_SA_KEY` with WIF this slice:** Explicitly out of scope.
- **Product UI for connection errors / secret entry:** UX spec: no product UI.
- **Granting Cloud SQL Client before attach:** Unnecessary privilege this slice; grant when attach enabled.

---

## Conformance to project knowledge

- **Proposed** [Env-based DB targets](../../knowledge/decisions/env-based-db-targets.md): followed (env-driven DSN; Auth Proxy preferred local; Compose fallback; stub auth). **Refined this slice:** local **and** Cloud Run `multimodalis` target the **sandbox** instance only until a production Environment/work item says otherwise (not “Cloud Run → prod” yet).
- **Proposed** [Cloud SQL Unix socket on Cloud Run](../../knowledge/decisions/cloud-sql-unix-socket-on-cloudrun.md): still the **intended** Cloud Run connector when attach is enabled; **not implemented** this slice (deferred with Better Auth / login attach).
- **Pattern** session-auth: not modified.
- **Anti-patterns:** none listed; promoting “invent credentials / flip db auth early” as an anti-pattern so later slices do not re-litigate.

No `accepted` decision is contradicted; nothing requires `blocked` for supersession.

---

## Project knowledge promoted

1. Refined [`knowledge/decisions/env-based-db-targets.md`](../../knowledge/decisions/env-based-db-targets.md) — both targets → sandbox this phase.
2. New proposed [`knowledge/decisions/github-environment-sandbox-db-secrets.md`](../../knowledge/decisions/github-environment-sandbox-db-secrets.md).
3. New proposed [`knowledge/decisions/multimodalis-run-runtime-sa.md`](../../knowledge/decisions/multimodalis-run-runtime-sa.md).
4. New anti-pattern [`knowledge/anti-patterns/invent-credentials-or-early-db-auth.md`](../../knowledge/anti-patterns/invent-credentials-or-early-db-auth.md).
5. Citation update on Unix-socket ADR (attach deferred, connector unchanged).
