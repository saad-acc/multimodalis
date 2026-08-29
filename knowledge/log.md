# Project Knowledge Log

Chronological record of additions/changes to `knowledge/`, newest first.
Every agent that mints or edits a concept here appends one entry.

## 2026-08-29
* **Creation**: Added [Sandbox DB connectivity proof (Auth Proxy)](/features/sandbox-db-connectivity.md) — live SELECT 1 evidence under `features/evidence/00005-cloudsql-sandbox-connection/`; work item `00005`.
* **Update**: [Multimodalis PHP app (v2)](/components/multimodalis-php-app.md) — connectivity scripts + sandbox env; login attach deferred.
* **Update**: [Cloud SQL sandbox MySQL (bestmodal2-sandbox-mysql)](/components/cloudsql-sandbox-mysql.md) — Auth Proxy proof path; SM / GHA sandbox secrets; attach deferred.
* **Update**: [Env-based DB targets](/decisions/env-based-db-targets.md) — both local and Cloud Run → sandbox instance this phase; stub required for `00005`.
* **Creation**: Added [GitHub Environment sandbox for DB secrets](/decisions/github-environment-sandbox-db-secrets.md) — proposed; work item `00005-cloudsql-sandbox-connection`.
* **Creation**: Added [Dedicated multimodalis-run runtime SA](/decisions/multimodalis-run-runtime-sa.md) — proposed; Client role when attach enabled.
* **Creation**: Added [Invent credentials or flip AUTH_MODE=db before Better Auth](/anti-patterns/invent-credentials-or-early-db-auth.md) — rejected in `00005`.
* **Creation**: Added [Legacy BestModal PHP (modal repo)](/components/legacy-bestmodal-php.md) — sibling `modal/` source for kernel routing/nav/PDO/API slices.
* **Creation**: Added [Page module and view_path](/domain/page-module-view-path.md) — `$allowed_pages` defaults `bestmodal` / `views`.
* **Creation**: Added [can_view](/domain/can-view.md) — session `permissions[slug].can_view`; 403 not redirect.
* **Creation**: Added [Cloud SQL sandbox MySQL (bestmodal2-sandbox-mysql)](/components/cloudsql-sandbox-mysql.md) — instance connection name for work item `00005-cloudsql-sandbox-connection`.
* **Update**: [Multimodalis PHP app (v2)](/components/multimodalis-php-app.md) — links to named sandbox Cloud SQL; users-table env still ops-confirmed.

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
