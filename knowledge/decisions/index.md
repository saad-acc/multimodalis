# Architecture Decisions

ADR-style records. `status: accepted` decisions are binding on new work
items unless explicitly superseded — see `WORKFLOW.md` for how a work item
proposes superseding one.

# Accepted

# Proposed
- [Cloud SQL Unix socket on Cloud Run](cloud-sql-unix-socket-on-cloudrun.md) — native `/cloudsql/${INSTANCE_CONNECTION_NAME}` from Cloud Run (attach deferred until Better Auth / login attach)
- [Env-based DB targets](env-based-db-targets.md) — env-selected targets; local Auth Proxy → sandbox; Cloud Run → same sandbox this phase; Compose fallback; stub auth
- [GitHub Environment sandbox for DB secrets](github-environment-sandbox-db-secrets.md) — DB vars/secrets in Environment `sandbox`; no literals in git/YAML
- [Dedicated multimodalis-run runtime SA](multimodalis-run-runtime-sa.md) — runtime SA separate from deployer; Cloud SQL Client when attach enabled

# Superseded
