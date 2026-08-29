---
type: Architecture Decision
title: GitHub Environment sandbox for DB secrets
description: Sandbox DB credentials and related config are supplied via GitHub Actions Environment named sandbox; never as literals in git or workflow YAML.
tags: [architecture, secrets, ci, gcp]
timestamp: 2026-08-29
status: proposed
---

# Context
Multimodalis needs operator-supplied MySQL name/user/password for the Cloud SQL sandbox instance without committing secrets. Cloud Run Secret Manager mounts for login attach are deferred with Better Auth. Deploy already uses repo-level `GCP_SA_KEY`; DB config needs a scoped home that matches the sandbox phase.

# Decision
Sandbox DB credentials and related non-secret DB config are stored in GitHub Actions Environment **`sandbox`** (variables and secrets). Workflows that need those values reference Environment `sandbox` and use secret/var *names* only in YAML. Environment **`production`** is out of scope until a later work item. Real values never appear in the repository or as workflow literals; local developers use gitignored `.env`.

# Consequences
Implementers wire `environment: sandbox` (or equivalent) for deploy/jobs that consume DB config. Docs list placeholder key names (`DB_NAME`, `DB_USER`, `DB_PASSWORD`, `INSTANCE_CONNECTION_NAME`, …). Live connectivity proof may be blocked-on-secrets until operators fill the Environment and local `.env`.

# Rejected alternatives
- [Secrets only in Secret Manager this slice]: login attach / mounts deferred; GHA Environment is the required supply path for sandbox now.
- [Repo-level secrets for DB password]: weaker scoping; human chose Environment `sandbox`.
- [Invented sample credentials in `.env.example`]: forbidden; empty/marked placeholders only.

# Citations
[1] Work item: [00005-cloudsql-sandbox-connection architecture](/work-items/00005-cloudsql-sandbox-connection/architecture.md)
