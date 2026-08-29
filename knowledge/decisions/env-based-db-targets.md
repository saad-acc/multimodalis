---
type: Architecture Decision
title: Env-based DB targets
description: Database host/socket and credentials are selected by environment variables so local, sandbox, and prod can differ without code forks; Compose MySQL is an optional fallback.
tags: [architecture, database, local-dev]
timestamp: 2026-08-28
status: proposed
---

# Context
Operators need localhost app → remote sandbox DB and Cloud Run → a named Cloud SQL target without code forks. Hardcoding one topology would block either local proof or Cloud Run deploy. Work item `00005` named the sandbox instance and confirmed **both** local and Cloud Run `multimodalis` use that sandbox instance for the current phase; production Environment / prod DB remain later.

# Decision
All DB connectivity is env-driven (`DB_DSN_MODE` socket|tcp, `INSTANCE_CONNECTION_NAME` / `DB_SOCKET`, `DB_HOST`/`DB_PORT`, `DB_NAME`/`DB_USER`/`DB_PASSWORD`). Preferred local path is Cloud SQL Auth Proxy → sandbox on `127.0.0.1:3306` with `DB_DSN_MODE=tcp`. Compose MySQL is optional fallback. Until a production Environment work item says otherwise, Cloud Run `multimodalis` targets the **same sandbox** instance (`bestmodal-492819:europe-west1:bestmodal2-sandbox-mysql`) when attach is enabled. `AUTH_MODE=stub` remains allowed (and is required for the current slice) for offline UI work without DB login.

# Consequences
No secrets in git; `.env.example` documents keys and the non-secret instance connection name only. Implementers must not bake hostnames into PHP. Future work items reuse the same env contract when adding real Tarifabfrage queries or flipping `AUTH_MODE=db` after Better Auth assessment. GitHub Environment `sandbox` holds sandbox DB var/secret values (names only in repo).

# Rejected alternatives
- [Compose MySQL as the only supported local path]: conflicts with the recorded sandbox-DB preference.
- [Single hardcoded DSN in source]: cannot span local vs Cloud Run safely.
- [Cloud Run → prod DB while local → sandbox in this phase]: contradicted by `00005` clarification (both → sandbox).

# Citations
[1] Work item: [00001-v2-php-cloudrun-login architecture](/work-items/00001-v2-php-cloudrun-login/architecture.md)
[2] Work item: [00005-cloudsql-sandbox-connection architecture](/work-items/00005-cloudsql-sandbox-connection/architecture.md)
