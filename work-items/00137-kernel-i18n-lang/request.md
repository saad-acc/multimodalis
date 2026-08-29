# Request

**Submitted by:** Human (piecemeal legacy migration)
**Date:** 2026-08-29

## Problem statement
Legacy serves language switching via GET `lang` and JSON endpoints under `/Users/saadkhan/Documents/MyRepos/modal/api/lang_*.php` (and related lang helpers). v2 has no equivalent i18n kernel yet.

## Why now
Unblocks translated chrome and later feature pages that read the same lang cookie/session as modal.
This is one deployable slice of the piecemeal port from `../modal/` into v2, not a module-wide rewrite.

## Known constraints
One deployable. Keep `?page=` URLs. Do not dump `api/` to REST on day one. Match behaviour vs `/Users/saadkhan/Documents/MyRepos/modal/`. Do not ship a giant “migrate all Core” in this slice.
Do not invent a new locale system; copy legacy GET + API contract.
Public JSON stays under the same `/api/`, `apiltl/`, `apipp/`, `apisales/`, or `externapi/` paths as modal.

## Legacy paths
Compare implementation to `/Users/saadkhan/Documents/MyRepos/modal/` (views, `viewsltl/`, `viewspp/`, `views_sales/`, `api/`, `apiltl/`, `apipp/`, `apisales/`, `externapi/`).
Exact `?page=` slugs and JSON filenames are named in the problem statement; do not invent REST resources.

## In scope
Wire `?lang=` (or legacy GET `lang`) and include/port `api/lang_*.php` so public URLs stay `/api/lang_*.php`. Register any `?page=` only if legacy already has a lang page (usually none).
Match legacy behaviour vs `../modal/` for this slice only.

## Out of scope
Translating every feature string. REST rewrite of lang APIs. Feature pages.
Do not migrate unrelated Core/LTL/P2P/Sales pages in this item. Do not change `?page=` strings.

## Dependencies
depends_on: 00002 (routing). Suggested order: after routing, before layout-heavy pages.
Suggested program order follows `depends_on` in `item.yaml` (folder ids).

## Match-legacy verification
Same GET param and JSON URLs as `/Users/saadkhan/Documents/MyRepos/modal/`. Switching language on a stub page matches modal cookie/session behaviour.
Exercise the same query strings and JSON URLs a user or cron would hit on modal. Confirm chrome/permissions only if this item includes a page that uses layout.
Unknown slugs still 404 like modal. Do not require a new SPA route.

## Notes for discovery
Planner should list modal files 1:1. If a view is missing in modal, stop for human clarification rather than inventing UI.
