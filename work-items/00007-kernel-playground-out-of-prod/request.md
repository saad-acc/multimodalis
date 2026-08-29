# Request

**Submitted by:** Human (piecemeal legacy migration)
**Date:** 2026-08-29

## Problem statement
Legacy `/Users/saadkhan/Documents/MyRepos/modal/` contains playground/debug scripts that must not be reachable on production Cloud Run.

## Why now
Deployable v2 must not expose debug toys when more APIs come online.
This is one deployable slice of the piecemeal port from `../modal/` into v2, not a module-wide rewrite.

## Known constraints
One deployable. Keep `?page=` URLs. Do not dump `api/` to REST on day one. Match behaviour vs `/Users/saadkhan/Documents/MyRepos/modal/`. Do not ship a giant “migrate all Core” in this slice.
Deploy/notes only for how to keep them local; no new public routes.
Public JSON stays under the same `/api/`, `apiltl/`, `apipp/`, `apisales/`, or `externapi/` paths as modal.

## Legacy paths
Compare implementation to `/Users/saadkhan/Documents/MyRepos/modal/` (views, `viewsltl/`, `viewspp/`, `views_sales/`, `api/`, `apiltl/`, `apipp/`, `apisales/`, `externapi/`).
Exact `?page=` slugs and JSON filenames are named in the problem statement; do not invent REST resources.

## In scope
Exclude playground/debug from production paths (gitignore, Cloud Run ignore, or front-controller deny). Document in deploy notes only. No new `?page=` slugs.
Match legacy behaviour vs `../modal/` for this slice only.

## Out of scope
Deleting all local debug forever. Rewriting feature APIs.
Do not migrate unrelated Core/LTL/P2P/Sales pages in this item. Do not change `?page=` strings.

## Dependencies
depends_on: 00001. Suggested order: with other kernel hygiene, independent of features.
Suggested program order follows `depends_on` in `item.yaml` (folder ids).

## Match-legacy verification
Production image/routes cannot hit playground/debug URLs that modal might still have locally. No change to `?page=` whitelist behaviour.
Exercise the same query strings and JSON URLs a user or cron would hit on modal. Confirm chrome/permissions only if this item includes a page that uses layout.
Unknown slugs still 404 like modal. Do not require a new SPA route.

## Notes for discovery
Planner should list modal files 1:1. If a view is missing in modal, stop for human clarification rather than inventing UI.
