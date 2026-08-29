# Request

**Submitted by:** Human (piecemeal legacy migration)
**Date:** 2026-08-29

## Problem statement
Public legal pages without app chrome: `views/agb.php`, `views/privacy.php`, `views/impressum.php` under `/Users/saadkhan/Documents/MyRepos/modal/`. Slugs typically `agb`, `privacy`, `impressum` (may be linked outside `$allowed_pages`; match how modal actually serves them).

## Why now
Footer/login links in modal; needed before public marketing polish.
This is one deployable slice of the piecemeal port from `../modal/` into v2, not a module-wide rewrite.

## Known constraints
One deployable. Keep `?page=` URLs. Do not dump `api/` to REST on day one. Match behaviour vs `/Users/saadkhan/Documents/MyRepos/modal/`. Do not ship a giant “migrate all Core” in this slice.
No kernel layout chrome.
Public JSON stays under the same `/api/`, `apiltl/`, `apipp/`, `apisales/`, or `externapi/` paths as modal.

## Legacy paths
Compare implementation to `/Users/saadkhan/Documents/MyRepos/modal/` (views, `viewsltl/`, `viewspp/`, `views_sales/`, `api/`, `apiltl/`, `apipp/`, `apisales/`, `externapi/`).
Exact `?page=` slugs and JSON filenames are named in the problem statement; do not invent REST resources.

## In scope
Serve those three pages publicly with same URLs as modal (query `page=` if that is how they are linked).
Match legacy behaviour vs `../modal/` for this slice only.

## Out of scope
Legal copy rewrite. Cookie banner product. Layout nav.
Do not migrate unrelated Core/LTL/P2P/Sales pages in this item. Do not change `?page=` strings.

## Dependencies
depends_on: 00002. Independent of 00004 if truly public.
Suggested program order follows `depends_on` in `item.yaml` (folder ids).

## Match-legacy verification
URLs and HTML shell match modal (no app nav). Compare vs `../modal/views/{agb,privacy,impressum}.php`.
Exercise the same query strings and JSON URLs a user or cron would hit on modal. Confirm chrome/permissions only if this item includes a page that uses layout.
Unknown slugs still 404 like modal. Do not require a new SPA route.

## Notes for discovery
Planner should list modal files 1:1. If a view is missing in modal, stop for human clarification rather than inventing UI.
