# Project Knowledge Log

Chronological record of additions/changes to `knowledge/`, newest first.
Every agent that mints or edits a concept here appends one entry.

## 2026-08-28
* **Creation**: Added [Multimodalis PHP app (v2)](/components/multimodalis-php-app.md) — `public/` PHP login + Tarifabfrage; work item `00001-v2-php-cloudrun-login` verification.
* **Update**: [Multimodalis delivery workflow](/components/multimodalis-workflow.md) — repo now also hosts the PHP app component.
* **Creation**: Seeded feature harness + [Login](/features/login.md) + [Tarifabfrage landing](/features/tarifabfrage-landing.md); evidence under `features/evidence/00001-v2-php-cloudrun-login/`.
* **Creation**: Added [Cloud SQL Unix socket on Cloud Run](/decisions/cloud-sql-unix-socket-on-cloudrun.md) — proposed; work item `00001-v2-php-cloudrun-login`.
* **Creation**: Added [Env-based DB targets](/decisions/env-based-db-targets.md) — proposed; work item `00001-v2-php-cloudrun-login`.
* **Creation**: Added [PHP public docroot with session auth](/patterns/php-public-docroot-session-auth.md) — architecture pattern from `00001-v2-php-cloudrun-login`.
* **Creation**: Added [Tarifabfrage](/domain/tarifabfrage.md) — post-login landing from sandbox capture; work item `00001-v2-php-cloudrun-login`.
* **Update**: [Sandbox BestModal](/components/sandbox-bestmodal.md) — first page is `page=tariff_query`, not an uncaptured dashboard.
* **Creation**: Added [BestModal](/domain/bestmodal.md) — product name from sandbox login; work item `00001-v2-php-cloudrun-login`.
* **Creation**: Added [Tariff administration](/domain/tariff-administration.md) — logo subtitle only; no domain model yet.
* **Creation**: Added [Sandbox BestModal](/components/sandbox-bestmodal.md) — live v1 at sandbox.bestmodal.de, not in this repo.
* **Creation**: Added [Multimodalis delivery workflow](/components/multimodalis-workflow.md) — repo process tooling.

## Example entry format
## YYYY-MM-DD
* **Creation**: Added [Decision title](/decisions/slug.md) — one line why.
* **Update**: Marked [Old decision](/decisions/old.md) superseded by [New decision](/decisions/new.md).
* **Creation**: Added [Anti-pattern title](/anti-patterns/slug.md) — rejected in work item `<id>`.
