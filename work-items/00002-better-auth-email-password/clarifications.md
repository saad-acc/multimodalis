# Clarifications

Log every human touchpoint here, in order: business sign-off, and any
`blocked` question/answer regardless of which state raised it.

## 2026-08-28 — requirement_draft — asked by: delivery-planner
**Question:** Is this work item **assessment + signed-off direction only**, or should a chosen Better Auth integration shape be **implemented in this same item** after architecture?

**Answer:**

**Decided by:**

## 2026-08-28 — requirement_draft — asked by: delivery-planner
**Question:** If you already have a preference, which integration family should Architecture use: (a) Node auth sidecar / second Cloud Run service, PHP validates session; (b) reverse-proxy `/api/auth/*` to Node, rest to PHP; (c) replace the PHP app with Node; (d) keep PHP login form POST and call Better Auth over HTTP from the server? Or should **Architecture decide after you approve** these requirements?

**Answer:**

**Decided by:**

## 2026-08-28 — requirement_draft — asked by: delivery-planner
**Question:** For the user store, which should be the system of record: Better Auth’s generated schema (`user` / `account` / …); the existing Cloud SQL users table (`DB_USERS_*`, still unnamed); or a migration that uses a custom hasher so Better Auth can verify current PHP `password_verify` hashes?

**Answer:**

**Decided by:**

## 2026-08-28 — requirement_draft — asked by: delivery-planner
**Question:** Self-registration: Better Auth email/password typically includes `signUp.email`. Must sign-up stay **off** (current Multimodalis: login only, no user CRUD), or is self-registration allowed?

**Answer:**

**Decided by:**

## 2026-08-28 — requirement_draft — asked by: delivery-planner
**Question:** Local/offline: keep `AUTH_MODE=stub` so the UI works without a database, or require a DB (e.g. Compose MySQL) wherever Better Auth is used locally?

**Answer:**

**Decided by:**

## 2026-08-28 — requirement_draft — asked by: delivery-planner
**Question:** After a swap, what is the session source of truth: **Better Auth session only**, or **dual-write** PHP `$_SESSION` as well as Better Auth cookies/tables?

**Answer:**

**Decided by:**

## 2026-08-28 — requirement_draft — asked by: delivery-planner
**Question:** Public sign-up, email verification, and password reset (`page=set_password`): remain **out of product scope** as in work item 00001, or should a Better Auth swap include any of them?

**Answer:**

**Decided by:**

## 2026-08-28 — requirement_draft — asked by: delivery-planner
**Question:** Work item `00001-v2-php-cloudrun-login` is still in verification (human acceptance pending). May this Better Auth assessment proceed independently, or must 00001 be accepted first?

**Answer:**

**Decided by:**

## 2026-08-28 — requirement_draft — asked by: delivery-planner
**Question:** If the signed direction is a Node rewrite or new Better Auth tables on Cloud Run, do you explicitly **supersede** 00001’s rejected alternatives (no framework for that slice; no new users schema as the Cloud Run path)?

**Answer:**

**Decided by:**
