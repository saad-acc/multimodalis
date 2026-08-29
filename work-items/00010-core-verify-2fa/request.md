# Request

**Submitted by:** Human (piecemeal legacy migration)
**Date:** 2026-08-29

## Problem statement
`?page=verify_2fa`. Views: `/Users/saadkhan/Documents/MyRepos/modal/views/verify_2fa.php`. APIs: `/api/verify_2fa.php`, `/api/send_2fa_code.php`.

## Why now
Login path in modal can require 2FA before tariff chrome.
This is one deployable slice of the piecemeal port from `../modal/` into v2, not a module-wide rewrite.

## Known constraints
One deployable. Keep `?page=` URLs. Do not dump `api/` to REST on day one. Match behaviour vs `/Users/saadkhan/Documents/MyRepos/modal/`. Do not ship a giant “migrate all Core” in this slice.
Public JSON stays under the same `/api/`, `apiltl/`, `apipp/`, `apisales/`, or `externapi/` paths as modal.

## Legacy paths
Compare implementation to `/Users/saadkhan/Documents/MyRepos/modal/` (views, `viewsltl/`, `viewspp/`, `views_sales/`, `api/`, `apiltl/`, `apipp/`, `apisales/`, `externapi/`).
Exact `?page=` slugs and JSON filenames are named in the problem statement; do not invent REST resources.

## In scope
Port 2FA view and those two JSON URLs.
Match legacy behaviour vs `../modal/` for this slice only.

## Out of scope
Changing 2FA provider. SMS vendor swap. REST.
Do not migrate unrelated Core/LTL/P2P/Sales pages in this item. Do not change `?page=` strings.

## Dependencies
depends_on: 00002, 00004. After set_password if invite+2FA overlap, else parallel.
Suggested program order follows `depends_on` in `item.yaml` (folder ids).

## Match-legacy verification
Same `?page=verify_2fa` and `/api/verify_2fa.php` + `/api/send_2fa_code.php` as modal.
Exercise the same query strings and JSON URLs a user or cron would hit on modal. Confirm chrome/permissions only if this item includes a page that uses layout.
Unknown slugs still 404 like modal. Do not require a new SPA route.

## Notes for discovery
Planner should list modal files 1:1. If a view is missing in modal, stop for human clarification rather than inventing UI.
Keep worker/cron PHP entrypoints as public files if modal already does; do not introduce a new job queue in this slice.
