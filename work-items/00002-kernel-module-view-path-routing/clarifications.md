# Clarifications

Log every human touchpoint here, in order: business sign-off, and any
`blocked` question/answer regardless of which state raised it.

## 2026-08-29 — requirement_draft — asked by: delivery-planner
**Question:** Legacy `index.php` includes `views/404.php` for unregistered slugs, but that file is not in `/Users/saadkhan/Documents/MyRepos/modal/views/`. What should v2 serve (copy from sandbox, new 404, other file)? Do not invent UI without that decision.

**Answer:**

**Decided by:**

## 2026-08-29 — requirement_draft — asked by: delivery-planner
**Question:** Should 00002 copy the full legacy `$allowed_pages` map (all Core/LTL/P2P/Sales slugs + `module`/`view_path`) with stubs, or only a minimal registry (`login`, `tariff_query`, 404) that later work items extend?

**Answer:**

**Decided by:**

## 2026-08-29 — requirement_draft — asked by: delivery-planner
**Question:** Until 00004, unknown `page` values: 404 as this request’s verification says, or keep matching legacy order (403 once `can_view` exists) / current v2 tariff chrome? Permissions are out of scope here.

**Answer:**

**Decided by:**
