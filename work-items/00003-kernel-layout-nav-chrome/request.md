# Request

**Submitted by:** Human (piecemeal legacy migration)
**Date:** 2026-08-29

## Problem statement
Legacy wraps authenticated pages in layout from `index.php` plus `includes/navigation_neu.php` and `config/nav_*.php`. v2 still inlines chrome in the tariff_query page. Pull layout out of the front controller so feature views are content-only, matching legacy chrome (module-aware highlight).

## Why now
Suggested move order: public/ already exists; next is pull layout out of index.php.

## Known constraints
Keep `?page=` URLs. Nav configs: `includes/navigation_config.php`, `config/nav_ltl.php`, `nav_localport2port.php`, `nav_sales.php`, `nav_task_system.php`. Do not implement every feature page—show links; 403/empty as permissions dictate.

## In scope
Shared header/nav/footer; language helper hooks; body class from `$page_module`.

## Out of scope
Full i18n file parity (00005); can_view enforcement (00004) if split—this item may include visual nav only if 00004 owns the 403 gate.

## Dependencies
00002 routing. Unblocks authenticated feature pages.

## Match-legacy verification
Logged-in user with can_view on `tariff_query` sees equivalent nav groups vs `../modal/` for the same permissions snapshot; public pages still skip layout (login, set_password, verify_2fa, register, agb, privacy, impressum).
