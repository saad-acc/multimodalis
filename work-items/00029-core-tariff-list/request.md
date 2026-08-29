# Request

**Submitted by:** Human (piecemeal legacy migration)
**Date:** 2026-08-29

## Problem statement
`?page=tariff_list`. View: `views/tariff_list.php`. APIs: `/api/get_tariffs.php`, `/api/get_routes.php`, `/api/add_lane.php`, `/api/delete_route.php`, `/api/delete_tariff.php`, `/api/change_tariff_status.php`, `/api/update_tariff_validity.php`, `/api/export_tariffs_excel.php`, `/api/sync_external_tariffs.php`.

## Why now
Central tariff admin.
This is one deployable slice of the piecemeal port from `../modal/` into v2, not a module-wide rewrite.

## Known constraints
One deployable. Keep `?page=` URLs. Do not dump `api/` to REST on day one. Match behaviour vs `/Users/saadkhan/Documents/MyRepos/modal/`. Do not ship a giant “migrate all Core” in this slice.
Out: mirror jobs 00067 (mirror_all_in_tariff*).
Public JSON stays under the same `/api/`, `apiltl/`, `apipp/`, `apisales/`, or `externapi/` paths as modal.

## Legacy paths
Compare implementation to `/Users/saadkhan/Documents/MyRepos/modal/` (views, `viewsltl/`, `viewspp/`, `views_sales/`, `api/`, `apiltl/`, `apipp/`, `apisales/`, `externapi/`).
Exact `?page=` slugs and JSON filenames are named in the problem statement; do not invent REST resources.

## In scope
List UI + listed APIs except all-in mirror workers.
Match legacy behaviour vs `../modal/` for this slice only.

## Out of scope
00067 mirror_all_in jobs. Purchase/combined detail pages.
Do not migrate unrelated Core/LTL/P2P/Sales pages in this item. Do not change `?page=` strings.

## Dependencies
depends_on: 00028. Unblocks 00030–00034 and 00067.
Suggested program order follows `depends_on` in `item.yaml` (folder ids).

## Match-legacy verification
`?page=tariff_list` and listed JSON/Excel URLs match modal; mirror endpoints deferred.
Exercise the same query strings and JSON URLs a user or cron would hit on modal. Confirm chrome/permissions only if this item includes a page that uses layout.
Unknown slugs still 404 like modal. Do not require a new SPA route.

## Notes for discovery
Planner should list modal files 1:1. If a view is missing in modal, stop for human clarification rather than inventing UI.
