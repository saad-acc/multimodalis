# Clarifications

Log every human touchpoint here, in order: business sign-off, and any
`blocked` question/answer regardless of which state raised it.

## 2026-08-29 — requirement_draft — asked by: delivery-planner
**Question:** Besides `playground/` (`compare_address_content_platform.php`, `JL.html`, `db_config.local.php`), which debug scripts must be unreachable in production (`api/test_*.php`, `view_debug_log.php`, `create_rotterdam_routes_test.php`, others)?

**Answer:**

**Decided by:**

## 2026-08-29 — requirement_draft — asked by: delivery-planner
**Question:** How should production exclusion be implemented — omit from Docker/`public/`, HTTP deny if present, `.gcloudignore`, gitignore (local only), or a combination? Gitignore alone does not strip files already copied in CI.

**Answer:**

**Decided by:**
