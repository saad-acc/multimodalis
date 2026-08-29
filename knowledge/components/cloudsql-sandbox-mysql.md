---
type: Component
title: Cloud SQL sandbox MySQL (bestmodal2-sandbox-mysql)
description: Existing GCP Cloud SQL for MySQL sandbox instance for Multimodalis local + Cloud Run connectivity; no credentials in git.
resource: bestmodal-492819:europe-west1:bestmodal2-sandbox-mysql
tags: [gcp, cloud-sql, mysql, sandbox]
timestamp: 2026-08-29
---

# Responsibility
Hosts the sandbox MySQL data for Multimodalis v2. Connection name: `bestmodal-492819:europe-west1:bestmodal2-sandbox-mysql`. **This phase:** local connectivity via Cloud SQL Auth Proxy (TCP `127.0.0.1:3306`) proved with `scripts/check-db-connection.php`; non-secret `DB_NAME=bestmodal2` / `DB_USER=bestmodal`; password from Secret Manager `bestmodal2-sandbox-database-url` into gitignored `.env` / GitHub Environment `sandbox` secret `DB_PASSWORD`. Cloud Run Unix-socket attach + `AUTH_MODE=db` remain deferred (Better Auth). Credentials never in git.

# Depends on / depended on by
- Used by [Multimodalis PHP app (v2)](multimodalis-php-app.md) (`public/includes/db.php`, connectivity scripts under `scripts/`).
- Same GCP project as Cloud Run service `multimodalis` (`bestmodal-492819`, region `europe-west1`); runtime SA `multimodalis-run@…` (Cloud SQL Client when attach enabled later).
- Distinct from [Sandbox BestModal](sandbox-bestmodal.md) (external v1 app at sandbox.bestmodal.de); may share data lineage but source of truth for schema is the instance itself / ops, not this repo.
