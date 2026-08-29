# Request

**Submitted by:** Human (piecemeal legacy migration)
**Date:** 2026-08-29

## Problem statement
Tarifabfrage address layer: APIs `/api/check_and_geocode_address.php`, `/api/filter_addressnew.php`, `/api/fetch_addresses.php`, `/api/check_postal_code.php` used from `views/tariff_query.php` (`/Users/saadkhan/Documents/MyRepos/modal/`). Slug already stubbed in v2: `tariff_query`.

## Why now
Split query so geocode can land before distance/results.
This is one deployable slice of the piecemeal port from `../modal/` into v2, not a module-wide rewrite.

## Known constraints
One deployable. Keep `?page=` URLs. Do not dump `api/` to REST on day one. Match behaviour vs `/Users/saadkhan/Documents/MyRepos/modal/`. Do not ship a giant “migrate all Core” in this slice.
Out of this item: results calculation.
Public JSON stays under the same `/api/`, `apiltl/`, `apipp/`, `apisales/`, or `externapi/` paths as modal.

## Legacy paths
Compare implementation to `/Users/saadkhan/Documents/MyRepos/modal/` (views, `viewsltl/`, `viewspp/`, `views_sales/`, `api/`, `apiltl/`, `apipp/`, `apisales/`, `externapi/`).
Exact `?page=` slugs and JSON filenames are named in the problem statement; do not invent REST resources.

## In scope
Geocode/address JSON + any UI needed to type addresses on `?page=tariff_query`.
Match legacy behaviour vs `../modal/` for this slice only.

## Out of scope
Results calc (00024). Distance (00023). Save offer (00025).
Do not migrate unrelated Core/LTL/P2P/Sales pages in this item. Do not change `?page=` strings.

## Dependencies
depends_on: 00003, 00006. Suggested first of tariff_query split.
Suggested program order follows `depends_on` in `item.yaml` (folder ids).

## Match-legacy verification
Those four JSON URLs match modal; no result grid required yet.
Exercise the same query strings and JSON URLs a user or cron would hit on modal. Confirm chrome/permissions only if this item includes a page that uses layout.
Unknown slugs still 404 like modal. Do not require a new SPA route.

## Notes for discovery
Planner should list modal files 1:1. If a view is missing in modal, stop for human clarification rather than inventing UI.
