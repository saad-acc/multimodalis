# Discovery

## Existing systems / prior art

- **v2:** Session identity is `$_SESSION['user_email']` only (`public/includes/auth.php`). No `user_id`, no `permissions` array. `api/check_login.php` does not load roles. Stub login accepts any non-empty pair when stub env is open.
- **Legacy gate:** After public pages, if `empty($_SESSION['user_id'])` → login redirect. Then if not public and `empty($perms[$requested]['can_view'])` → **HTTP 403** HTML (German “Keine Berechtigung”, link to `page=login`), **no redirect**. Domain: [can_view](/knowledge/domain/can-view.md).
- **Session fill:** `api/check_login.php` (and 2FA path) SELECT `p.page, rpp.can_view, rpp.can_edit, rpp.can_delete` into `$_SESSION['permissions'][$page]`. Tenant = same array shape, not a new RBAC.
- **Public skip:** same `$public_pages` as 00003.
- **Nav:** 00003 may filter on the same array; this item owns the **page 403**, not role admin UI (00017) or table seeding.

## Constraints found

- Do not invent a new RBAC model. Unauthenticated → login already 00001. Seed/migrate `role_page_permissions` out of scope.
- Verification: session with no `can_view` on `dashboard` → 403; with `can_view` → page (stub ok).
- 00002 registers pages; this item is parallel with 00003.

## Open questions

- Stub `AUTH_MODE=stub` has no DB permissions — how to obtain a `permissions` snapshot for local/Cloud Run stub.
- Whether login must start writing `user_id` + `permissions` in this item (legacy shape) or only the gate assuming something else populated session.
- 403 vs 404 order for unknown slugs (legacy: 403 first).
