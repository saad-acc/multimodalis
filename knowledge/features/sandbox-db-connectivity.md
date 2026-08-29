---
type: Feature
title: Sandbox DB connectivity proof (Auth Proxy)
description: Developer/ops CLI proves PDO TCP connectivity to Cloud SQL sandbox via Auth Proxy; does not flip login to AUTH_MODE=db.
resource: scripts/check-db-connection.php
tags: [infra, database, ops]
timestamp: 2026-08-29
---

# Sub-features
- Auth Proxy listen `127.0.0.1:3306` for `bestmodal-492819:europe-west1:bestmodal2-sandbox-mysql`
- Local gitignored `.env` with `DB_NAME=bestmodal2`, `DB_USER=bestmodal`, `DB_PASSWORD` (from SM or ops)
- Optional `./scripts/sync-sandbox-db-env-from-sm.sh` writes `.env` from Secret Manager without echoing password
- `php scripts/check-db-connection.php` → `db_pdo()` / `db_ping()` / `SELECT 1`
- Product login remains `AUTH_MODE=stub`

# How to get to it (user POV)
Not an end-user product page. Developers/operators run the scripts from the repo root after starting Cloud SQL Auth Proxy (see README).

# Driving it with harness + Auth Proxy
Preconditions: GCP identity that can run Auth Proxy + access SM `bestmodal2-sandbox-database-url` (or a filled gitignored `.env`); `pdo_mysql` on host PHP.

1. **Proxy** — `cloud-sql-proxy bestmodal-492819:europe-west1:bestmodal2-sandbox-mysql --address 127.0.0.1 --port 3306`
2. **Env** — `./scripts/sync-sandbox-db-env-from-sm.sh` (or manual `.env`); never commit `.env`
3. **Proof** — `php scripts/check-db-connection.php` → exit 0 and `OK: SELECT 1… db=bestmodal2`
4. **Stub unchanged** — compose doctor: login page 200; `AUTH_MODE=stub`; open stub POST still redirects to `tariff_query`

Evidence for item `00005-cloudsql-sandbox-connection`: `knowledge/features/evidence/00005-cloudsql-sandbox-connection/select1-proof.log`, `deploy-scope-check.log`, `01-login.*`, `04-success-login.headers`, `compose-auth-mode.log`.

# Gotchas
- Never print or commit `DB_PASSWORD`. Evidence logs must not contain mysql URLs with credentials.
- Port 3306 conflict if Compose MySQL profile is also bound.
- Connectivity proof must not call `db_find_user_password_hash()` or set `AUTH_MODE=db`.
