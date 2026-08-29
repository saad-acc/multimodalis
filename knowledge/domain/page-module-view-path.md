---
type: Domain Concept
title: Page module and view_path
description: Legacy whitelist metadata — each ?page= slug maps to a view file under a directory (view_path) owned by a module name; defaults bestmodal / views.
tags: [routing, kernel]
timestamp: 2026-08-29
---

# Definition
In legacy `index.php`, `$allowed_pages[$slug]` may include `'module'` (default `bestmodal`) and `'view_path'` (default `views`). The view file is `{view_path}/{file}.php`. LTL uses `viewsltl` / module `ltl`; P2P uses `viewspp` / `localport2port`; Sales uses `views_sales` / `sales`. Unregistered slugs that pass the permission gate load core `views/404.php` with `$page_module = 'bestmodal'`. `$page_module` is for layout (body class, nav highlight), not a URL prefix. v2 must keep the same `?page=` query string.

# Related terms
- [BestModal](bestmodal.md)
- [Tarifabfrage](tarifabfrage.md)
