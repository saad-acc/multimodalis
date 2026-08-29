# Request

**Submitted by:** Human (piecemeal legacy migration)
**Date:** 2026-08-29

## Problem statement
No `?page=`. JSON: `tariff_query_results_external`, `tariff_purchase_details_external`, `get_tariff_headers_external` under `/Users/saadkhan/Documents/MyRepos/modal/api/` (exact filenames as modal).

## Why now
External read models after query + purchase details.
This is one deployable slice of the piecemeal port from `../modal/` into v2, not a module-wide rewrite.

## Known constraints
One deployable. Keep `?page=` URLs. Do not dump `api/` to REST on day one. Match behaviour vs `/Users/saadkhan/Documents/MyRepos/modal/`. Do not ship a giant “migrate all Core” in this slice.
Keep `/api/` filenames.
Public JSON stays under the same `/api/`, `apiltl/`, `apipp/`, `apisales/`, or `externapi/` paths as modal.

## Legacy paths
Compare implementation to `/Users/saadkhan/Documents/MyRepos/modal/` (views, `viewsltl/`, `viewspp/`, `views_sales/`, `api/`, `apiltl/`, `apipp/`, `apisales/`, `externapi/`).
Exact `?page=` slugs and JSON filenames are named in the problem statement; do not invent REST resources.

## In scope
Those three JSON URLs.
Match legacy behaviour vs `../modal/` for this slice only.

## Out of scope
Browser purchase details page (00030). intermodaltariffs (00135).
Do not migrate unrelated Core/LTL/P2P/Sales pages in this item. Do not change `?page=` strings.

## Dependencies
depends_on: 00024, 00030.
Suggested program order follows `depends_on` in `item.yaml` (folder ids).

## Match-legacy verification
Those `/api/*_external.php` URLs match modal auth and payload.
Exercise the same query strings and JSON URLs a user or cron would hit on modal. Confirm chrome/permissions only if this item includes a page that uses layout.
Unknown slugs still 404 like modal. Do not require a new SPA route.

## Notes for discovery
Planner should list modal files 1:1. If a view is missing in modal, stop for human clarification rather than inventing UI.
