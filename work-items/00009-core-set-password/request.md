# Request

**Submitted by:** Human (piecemeal legacy migration)
**Date:** 2026-08-29

## Problem statement
Invite/reset flow uses `?page=set_password`. Legacy views: `/Users/saadkhan/Documents/MyRepos/modal/views/set_password.php`. APIs: `/api/check_token.php`, `/api/save_password.php`.

## Why now
Auth shell after login; users cannot complete invites without it.
This is one deployable slice of the piecemeal port from `../modal/` into v2, not a module-wide rewrite.

## Known constraints
One deployable. Keep `?page=` URLs. Do not dump `api/` to REST on day one. Match behaviour vs `/Users/saadkhan/Documents/MyRepos/modal/`. Do not ship a giant “migrate all Core” in this slice.
Public JSON stays under the same `/api/`, `apiltl/`, `apipp/`, `apisales/`, or `externapi/` paths as modal.

## Legacy paths
Compare implementation to `/Users/saadkhan/Documents/MyRepos/modal/` (views, `viewsltl/`, `viewspp/`, `views_sales/`, `api/`, `apiltl/`, `apipp/`, `apisales/`, `externapi/`).
Exact `?page=` slugs and JSON filenames are named in the problem statement; do not invent REST resources.

## In scope
Port view + check_token/save_password. Keep `index.php?page=set_password`.
Match legacy behaviour vs `../modal/` for this slice only.

## Out of scope
Full user_management. OAuth. REST password API.
Do not migrate unrelated Core/LTL/P2P/Sales pages in this item. Do not change `?page=` strings.

## Dependencies
depends_on: 00002, 00004. Suggested order: after routing and can-view.
Suggested program order follows `depends_on` in `item.yaml` (folder ids).

## Match-legacy verification
Token token query string and JSON posts match modal. Invalid token UX matches `views/set_password.php`.
Exercise the same query strings and JSON URLs a user or cron would hit on modal. Confirm chrome/permissions only if this item includes a page that uses layout.
Unknown slugs still 404 like modal. Do not require a new SPA route.

## Notes for discovery
Planner should list modal files 1:1. If a view is missing in modal, stop for human clarification rather than inventing UI.
Keep worker/cron PHP entrypoints as public files if modal already does; do not introduce a new job queue in this slice.
