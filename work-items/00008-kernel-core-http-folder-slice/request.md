# Request

**Submitted by:** Human (piecemeal legacy migration)
**Date:** 2026-08-29

## Problem statement
Legacy JSON lives as `/Users/saadkhan/Documents/MyRepos/modal/api/*.php` with public URLs `/api/<file>.php`. v2 should group toward `Modules/Core/Http/{Feature}` without changing those URLs.

## Why now
Stops a later giant dump of api/ into REST while still allowing module folders.
This is one deployable slice of the piecemeal port from `../modal/` into v2, not a module-wide rewrite.

## Known constraints
One deployable. Keep `?page=` URLs. Do not dump `api/` to REST on day one. Match behaviour vs `/Users/saadkhan/Documents/MyRepos/modal/`. Do not ship a giant “migrate all Core” in this slice.
MAY need business_clarification: physical folder move vs rewrite-rule/include map. Do not change public JSON URLs.
Public JSON stays under the same `/api/`, `apiltl/`, `apipp/`, `apisales/`, or `externapi/` paths as modal.

## Legacy paths
Compare implementation to `/Users/saadkhan/Documents/MyRepos/modal/` (views, `viewsltl/`, `viewspp/`, `views_sales/`, `api/`, `apiltl/`, `apipp/`, `apisales/`, `externapi/`).
Exact `?page=` slugs and JSON filenames are named in the problem statement; do not invent REST resources.

## In scope
One folder-slice pattern for Core HTTP: files can live under `Modules/Core/Http/{Feature}` while public URLs remain `/api/<legacy_file>.php`. No feature behaviour change.
Match legacy behaviour vs `../modal/` for this slice only.

## Out of scope
REST resource redesign. Moving LTL/P2P/Sales APIs in this item. Changing query strings.
Do not migrate unrelated Core/LTL/P2P/Sales pages in this item. Do not change `?page=` strings.

## Dependencies
depends_on: 00002. Suggested order: after routing; before large feature ports prefer this map.
Suggested program order follows `depends_on` in `item.yaml` (folder ids).

## Match-legacy verification
A sample legacy URL e.g. `/api/load_tariffs.php` still 200s with the same contract as modal. No new REST paths required.
Exercise the same query strings and JSON URLs a user or cron would hit on modal. Confirm chrome/permissions only if this item includes a page that uses layout.
Unknown slugs still 404 like modal. Do not require a new SPA route.

## Notes for discovery
Planner should list modal files 1:1. If a view is missing in modal, stop for human clarification rather than inventing UI.
