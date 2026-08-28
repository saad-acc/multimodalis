---
type: Architecture Decision
title: Env-based DB targets
description: Database host/socket and credentials are selected by environment variables so local, sandbox, and prod can differ without code forks; Compose MySQL is an optional fallback.
tags: [architecture, database, local-dev]
timestamp: 2026-08-28
status: proposed
---

# Context
Operators prefer localhost app → remote sandbox DB and Cloud Run → prod DB (initially the same data), while developers may lack sandbox connectivity. Hardcoding one topology would block either local proof or Cloud Run deploy.

# Decision
All DB connectivity is env-driven (`DB_DSN_MODE` socket|tcp, `INSTANCE_CONNECTION_NAME` / `DB_SOCKET`, `DB_HOST`/`DB_PORT`, `DB_NAME`/`DB_USER`/`DB_PASSWORD`). Preferred local path is Auth Proxy to sandbox; Compose MySQL is optional fallback. Cloud Run uses prod (or shared) credentials via secrets. `AUTH_MODE=stub` remains allowed for offline UI work without a DB.

# Consequences
No secrets in git; `.env.example` documents keys only. Implementers must not bake hostnames into PHP. Future work items reuse the same env contract when adding real Tarifabfrage queries.

# Rejected alternatives
- [Compose MySQL as the only supported local path]: conflicts with the recorded sandbox-DB preference.
- [Single hardcoded DSN in source]: cannot span local vs Cloud Run safely.

# Citations
[1] Work item: [00001-v2-php-cloudrun-login architecture](/work-items/00001-v2-php-cloudrun-login/architecture.md)
