# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Feature pages must not leak to users who cannot view them in legacy: same `can_view` gate and 403 HTML, not a new permission system.

## Stakeholder requirements
- [Security / operators]: Users with a session but without `can_view` on a non-public slug get 403 HTML, not the page body.
- [Users with permission]: Registered stub (e.g. `dashboard` or `tariff_query`) renders when `can_view` is set.
- [Role admins]: No role-management UI in this slice (00017).

## Solution requirements

### Functional
- FR1: Mirror `$public_pages` from `../modal/index.php`; those slugs skip the `can_view` gate (and skip 403).
- FR2: Unauthenticated non-public → login redirect (existing 00001), not 403.
- FR3: Authenticated, non-public, empty `$_SESSION['permissions'][$requested]['can_view']` → HTTP 403, HTML body matching legacy (no redirect).
- FR4: Session shape for the gate is the legacy `permissions` array (page key → `can_view` boolean at minimum). Do not invent a parallel ACL.
- FR5: User **with** `can_view` on a registered slug gets that page (stub acceptable).
- FR6: Out of scope: seeding `pages` / `role_page_permissions`, role admin UI.

### Non-functional
- NFR1: 403 response must not include authenticated app chrome of the denied page (legacy is a standalone HTML document).
- NFR2: Gate runs for every registered non-public `?page=` slug once 00002 exists; no extra REST resources.

## Needs clarification
- How should `AUTH_MODE=stub` (no DB) populate `$_SESSION['permissions']` so 403 vs allow is testable without inventing RBAC (hardcoded full access, empty map, copied fixture)?
- Must `api/check_login.php` in this item load `user_id` + `permissions` from Cloud SQL like modal, or only enforce the gate assuming a later login item fills session?
- For unknown slugs: keep legacy order (403 if `can_view` empty, 404 only if `can_view` is set but slug not in `$allowed_pages`) or 404 first as 00002 verification describes?
