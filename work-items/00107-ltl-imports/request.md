# Request

**Submitted by:** Human (piecemeal legacy migration)
**Date:** 2026-08-29

## Problem statement
`?page=ltl_imports`. View: `viewsltl/ltl_imports.php` uses `$pdo_ltl` directly (no fetch API).

## Why now
Import history.
This is one deployable slice of the piecemeal port from `../modal/` into v2, not a module-wide rewrite.

## Known constraints
One deployable. Keep `?page=` URLs. Do not dump `api/` to REST on day one. Match behaviour vs `/Users/saadkhan/Documents/MyRepos/modal/`. Do not ship a giant “migrate all Core” in this slice.
No new REST; keep in-view queries like modal.
Public JSON stays under the same `/api/`, `apiltl/`, `apipp/`, `apisales/`, or `externapi/` paths as modal.

## Legacy paths
Compare implementation to `/Users/saadkhan/Documents/MyRepos/modal/` (views, `viewsltl/`, `viewspp/`, `views_sales/`, `api/`, `apiltl/`, `apipp/`, `apisales/`, `externapi/`).
Exact `?page=` slugs and JSON filenames are named in the problem statement; do not invent REST resources.

## In scope
History page with direct `$pdo_ltl`.
Match legacy behaviour vs `../modal/` for this slice only.

## Out of scope
Adding a fetch API modal does not have.
Do not migrate unrelated Core/LTL/P2P/Sales pages in this item. Do not change `?page=` strings.

## Dependencies
depends_on: 00106.
Suggested program order follows `depends_on` in `item.yaml` (folder ids).

## Match-legacy verification
`?page=ltl_imports` matches modal SQL/UI; 503 if `$pdo_ltl` null.
Exercise the same query strings and JSON URLs a user or cron would hit on modal. Confirm chrome/permissions only if this item includes a page that uses layout.
Unknown slugs still 404 like modal. Do not require a new SPA route.

## Notes for discovery
Planner should list modal files 1:1. If a view is missing in modal, stop for human clarification rather than inventing UI.
