# Request

**Submitted by:** Human (piecemeal legacy migration)
**Date:** 2026-08-29

## Problem statement
Legacy `/Users/saadkhan/Documents/MyRepos/modal/` uses `connectdb.inc.php` (and host/env) to expose `$pdo`, `$pdo_ltl`, `$pdo_sales`. v2 must connect the same way without rewriting query SQL.

## Why now
Every feature that hits MySQL needs tenant/host bootstrap before page ports.
This is one deployable slice of the piecemeal port from `../modal/` into v2, not a module-wide rewrite.

## Known constraints
One deployable. Keep `?page=` URLs. Do not dump `api/` to REST on day one. Match behaviour vs `/Users/saadkhan/Documents/MyRepos/modal/`. Do not ship a giant “migrate all Core” in this slice.
Do not change query SQL. Do not merge three PDOs into one connection.
Public JSON stays under the same `/api/`, `apiltl/`, `apipp/`, `apisales/`, or `externapi/` paths as modal.

## Legacy paths
Compare implementation to `/Users/saadkhan/Documents/MyRepos/modal/` (views, `viewsltl/`, `viewspp/`, `views_sales/`, `api/`, `apiltl/`, `apipp/`, `apisales/`, `externapi/`).
Exact `?page=` slugs and JSON filenames are named in the problem statement; do not invent REST resources.

## In scope
Env/host connection bootstrap equivalent to `connectdb.inc.php`: `$pdo`, `$pdo_ltl`, `$pdo_sales` nullable when a tenant DB is missing. No `?page=` slug of its own.
Match legacy behaviour vs `../modal/` for this slice only.

## Out of scope
Rewriting SELECT/INSERT. Schema migrations. Changing Cloud SQL instance IDs beyond env.
Do not migrate unrelated Core/LTL/P2P/Sales pages in this item. Do not change `?page=` strings.

## Dependencies
depends_on: 00001. Suggested order: foundation before geocode/tariff/LTL/Sales.
Suggested program order follows `depends_on` in `item.yaml` (folder ids).

## Match-legacy verification
App boots with the same PDO variables as modal include graph. Missing LTL/Sales DB leaves those handles null (LTL later returns 503). No SQL text changes.
Exercise the same query strings and JSON URLs a user or cron would hit on modal. Confirm chrome/permissions only if this item includes a page that uses layout.
Unknown slugs still 404 like modal. Do not require a new SPA route.

## Notes for discovery
Planner should list modal files 1:1. If a view is missing in modal, stop for human clarification rather than inventing UI.
