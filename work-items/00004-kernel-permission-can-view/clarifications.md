# Clarifications

Log every human touchpoint here, in order: business sign-off, and any
`blocked` question/answer regardless of which state raised it.

## 2026-08-29 — requirement_draft — asked by: delivery-planner
**Question:** For `AUTH_MODE=stub` (no DB), how should `$_SESSION['permissions']` be filled so 403 vs allow can be verified without a new RBAC model (full access, empty map, fixture)?

**Answer:**

**Decided by:**

## 2026-08-29 — requirement_draft — asked by: delivery-planner
**Question:** Must this item extend `api/check_login.php` to load `user_id` and `permissions` from existing Cloud SQL tables like modal, or only add the 403 gate assuming session is populated elsewhere?

**Answer:**

**Decided by:**

## 2026-08-29 — requirement_draft — asked by: delivery-planner
**Question:** Confirm 403-before-whitelist (legacy) vs 404-for-unknown-first (00002 verification) for unregistered `page` values.

**Answer:**

**Decided by:**
