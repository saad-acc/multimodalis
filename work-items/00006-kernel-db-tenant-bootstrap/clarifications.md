# Clarifications

Log every human touchpoint here, in order: business sign-off, and any
`blocked` question/answer regardless of which state raised it.

## 2026-08-29 — requirement_draft — asked by: delivery-planner
**Question:** Map ops-owned databases/users/secrets to `$pdo`, `$pdo_ltl`, and `$pdo_sales` for Multimodalis sandbox/prod. How should legacy per-host `$_sites` tenant switching work on one Cloud Run service? Do not invent schema or credentials. (`connectdb.inc.php` is not in the modal git repo.)

**Answer:**

**Decided by:**

## 2026-08-29 — requirement_draft — asked by: delivery-planner
**Question:** Is P2P `connectdb_p2p.inc.php` / `$pdo` equivalent for P2P in or out of 00006? Request names only `$pdo`, `$pdo_ltl`, `$pdo_sales`.

**Answer:**

**Decided by:**

## 2026-08-29 — requirement_draft — asked by: delivery-planner
**Question:** When `AUTH_MODE=stub`, must the three PDO handles still be created, or may bootstrap skip MySQL like current v2 login?

**Answer:**

**Decided by:**
