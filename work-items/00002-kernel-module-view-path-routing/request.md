# Request

**Submitted by:** Human (piecemeal legacy migration)
**Date:** 2026-08-29

## Problem statement
v2 `public/index.php` only serves login and a Tarifabfrage chrome stub. Legacy `../modal/index.php` dispatches `?page=` via `$allowed_pages` with optional `module` and `view_path` (defaults `bestmodal` / `views`). This slice must add that whitelist routing so later feature items can register one slug without changing URLs.

## Why now
Unblocks every module move. Keep one deployable and `?page=` slugs.

## Known constraints
Match legacy: unknown slug → 404 view; `$page_module` available for layout. Do not relocate LTL/P2P/Sales views in this item. Do not implement feature pages. Verification vs `../modal/index.php` `$allowed_pages` structure.

## In scope
Register/load pages from module+view_path metadata; default landing `tariff_query`.

## Out of scope
Nav chrome extract, permissions, real tariff engine, API URL changes.

## Dependencies
After 00001 login/session pattern. Before layout/nav and feature pages.

## Match-legacy verification
Hitting `index.php?page=<registered_stub>` loads the mapped file from the declared view_path; unregistered page matches legacy 404 belonging to core. Same query string as legacy.
