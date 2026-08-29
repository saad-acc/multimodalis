---
type: Component
title: Legacy BestModal PHP (modal repo)
description: Sibling source at /Users/saadkhan/Documents/MyRepos/modal — piecemeal migration origin for ?page= routing, nav, permissions, PDO bootstrap, and public JSON under /api/.
resource: /Users/saadkhan/Documents/MyRepos/modal
tags: [legacy, php, bestmodal]
timestamp: 2026-08-29
---

# Responsibility
Owns the current BestModal PHP application code (not this repo). Front controller `index.php` dispatches `?page=` via `$allowed_pages` (optional `module` / `view_path`), `$public_pages` without chrome, `can_view` 403, host `connectdb.inc.php` for `$pdo` / `$pdo_ltl`, `includes/connectdb_sales.php` for `$pdo_sales`. Public JSON remains `/api/<file>.php`, plus `apiltl/`, `apipp/`, `api_sales/` / `apisales/`, `externapi/`. Playground lives in `playground/`. Language files `api/lang_*.php`. Host secrets (`connectdb.inc.php`, `connectdb_p2p.inc.php`, `~/connectdb_sales.cfg.php`) are **outside** that repo.

# Depends on / depended on by
- Visual/auth reference also [Sandbox BestModal](sandbox-bestmodal.md) (deployed instance of this lineage).
- [Multimodalis PHP app (v2)](multimodalis-php-app.md) ports slices into `public/` without changing `?page=` slugs or public JSON URLs.
