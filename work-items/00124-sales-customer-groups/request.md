# Request

**Submitted by:** Human (piecemeal legacy migration)
**Date:** 2026-08-29

## Problem statement
`?page=sales_customer_groups`. View: `views_sales/sales_customer_groups.php`. API: `sales_customer_groups_api` under `apisales/`.

## Why now
Groups before customers.
This is one deployable slice of the piecemeal port from `../modal/` into v2, not a module-wide rewrite.

## Known constraints
One deployable. Keep `?page=` URLs. Do not dump `api/` to REST on day one. Match behaviour vs `/Users/saadkhan/Documents/MyRepos/modal/`. Do not ship a giant “migrate all Core” in this slice.
Public JSON stays under the same `/api/`, `apiltl/`, `apipp/`, `apisales/`, or `externapi/` paths as modal.

## Legacy paths
Compare implementation to `/Users/saadkhan/Documents/MyRepos/modal/` (views, `viewsltl/`, `viewspp/`, `views_sales/`, `api/`, `apiltl/`, `apipp/`, `apisales/`, `externapi/`).
Exact `?page=` slugs and JSON filenames are named in the problem statement; do not invent REST resources.

## In scope
Groups UI + sales_customer_groups_api.
Match legacy behaviour vs `../modal/` for this slice only.

## Out of scope
customers (00125).
Do not migrate unrelated Core/LTL/P2P/Sales pages in this item. Do not change `?page=` strings.

## Dependencies
depends_on: 00006.
Suggested program order follows `depends_on` in `item.yaml` (folder ids).

## Match-legacy verification
`?page=sales_customer_groups` and `apisales/` URL match modal.
Exercise the same query strings and JSON URLs a user or cron would hit on modal. Confirm chrome/permissions only if this item includes a page that uses layout.
Unknown slugs still 404 like modal. Do not require a new SPA route.

## Notes for discovery
Planner should list modal files 1:1. If a view is missing in modal, stop for human clarification rather than inventing UI.
Keep worker/cron PHP entrypoints as public files if modal already does; do not introduce a new job queue in this slice.
