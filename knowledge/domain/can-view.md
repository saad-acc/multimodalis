---
type: Domain Concept
title: can_view
description: Per-page boolean on the session permissions array; empty means HTTP 403 HTML with no redirect (legacy index.php).
tags: [authz, kernel]
timestamp: 2026-08-29
---

# Definition
Legacy stores `$_SESSION['permissions'][$pageSlug]['can_view'|'can_edit'|'can_delete']` after login (`api/check_login.php` / `api/verify_2fa.php` from `role_page_permissions` joined to `pages`). Front controller: if the requested slug is not in `$public_pages` and `can_view` is empty, respond **403** HTML (German copy, link to login) — **do not redirect**. Nav hides items the same way. This is not a new RBAC model; v2 must reuse that session shape. Unauthenticated users are redirected to login (separate from 403).

# Related terms
- [Page module and view_path](page-module-view-path.md)
