# Request

**Submitted by:** Human (piecemeal legacy migration)
**Date:** 2026-08-29

## Problem statement
Legacy denies pages when `$_SESSION['permissions'][$requested]['can_view']` is empty: HTTP 403 HTML, no redirect. v2 only has session-authenticated vs not. This slice adds the same permission gate for registered pages (excluding public_pages list).

## Why now
Feature migrations must not leak pages to users who cannot see them in legacy.

## Known constraints
Public pages skip the gate. Unauthenticated → login redirect (already in 00001). Do not invent a new RBAC model.

## In scope
Mirror `$public_pages` and 403 body behaviour from `../modal/index.php`.

## Out of scope
Role admin UI (00017); seeding permissions tables.

## Dependencies
00002. Parallel with 00003. Needed before shipping any extra page slug.

## Match-legacy verification
User with session but without can_view on `dashboard` gets 403 like sandbox/legacy; user with can_view gets the page (stub ok). Tenant: same session shape as legacy `permissions` array.
