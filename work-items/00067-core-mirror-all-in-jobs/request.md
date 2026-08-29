# Request

**Submitted by:** Human (piecemeal legacy migration)
**Date:** 2026-08-29

## Problem statement
No `?page=`. APIs `mirror_all_in_tariff*` invoked from tariff_list in `/Users/saadkhan/Documents/MyRepos/modal/api/`.

## Why now
Split from 00029 so list can ship without background mirrors.
This is one deployable slice of the piecemeal port from `../modal/` into v2, not a module-wide rewrite.

## Known constraints
One deployable. Keep `?page=` URLs. Do not dump `api/` to REST on day one. Match behaviour vs `/Users/saadkhan/Documents/MyRepos/modal/`. Do not ship a giant “migrate all Core” in this slice.
Keep public `/api/` filenames.
Public JSON stays under the same `/api/`, `apiltl/`, `apipp/`, `apisales/`, or `externapi/` paths as modal.

## Legacy paths
Compare implementation to `/Users/saadkhan/Documents/MyRepos/modal/` (views, `viewsltl/`, `viewspp/`, `views_sales/`, `api/`, `apiltl/`, `apipp/`, `apisales/`, `externapi/`).
Exact `?page=` slugs and JSON filenames are named in the problem statement; do not invent REST resources.

## In scope
Port mirror_all_in_tariff* JSON/workers used by tariff_list.
Match legacy behaviour vs `../modal/` for this slice only.

## Out of scope
tariff_list UI (00029). Changing job runner product.
Do not migrate unrelated Core/LTL/P2P/Sales pages in this item. Do not change `?page=` strings.

## Dependencies
depends_on: 00029.
Suggested program order follows `depends_on` in `item.yaml` (folder ids).

## Match-legacy verification
Calling those `/api/mirror_all_in_tariff*.php` URLs matches modal side effects.
Exercise the same query strings and JSON URLs a user or cron would hit on modal. Confirm chrome/permissions only if this item includes a page that uses layout.
Unknown slugs still 404 like modal. Do not require a new SPA route.

## Notes for discovery
Planner should list modal files 1:1. If a view is missing in modal, stop for human clarification rather than inventing UI.
