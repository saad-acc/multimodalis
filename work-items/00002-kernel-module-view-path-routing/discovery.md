# Discovery

## Existing systems / prior art

- **v2 (this repo):** [Multimodalis PHP app](/knowledge/components/multimodalis-php-app.md). `public/index.php` maps empty/`login` to `pages/login.php`; everything else (including unknown `page`) runs `require_auth()` then always includes `pages/tariff_query.php`. Pattern: [PHP public docroot with session auth](/knowledge/patterns/php-public-docroot-session-auth.md). No `$allowed_pages`, no `module`/`view_path`, no 404 view. `page=set_password` still redirects to login (00001).
- **Legacy:** [Legacy BestModal PHP](/knowledge/components/legacy-bestmodal-php.md) `index.php` §9–10. `$requested = basename($_GET['page'] ?? 'tariff_query')`. `$allowed_pages` entries: `'file'`, `'title'`, optional `'module'` (default `bestmodal`), `'view_path'` (default `views`). Resolved path: `__DIR__ / {view_path} / {file}.php`. LTL: `viewsltl` / `ltl`; P2P: `viewspp` / `localport2port`; Sales: `views_sales` / `sales`. Unknown slug: `$page_module = 'bestmodal'`, `$page_file = views/404.php`. Domain: [Page module and view_path](/knowledge/domain/page-module-view-path.md).
- **404 view:** `index.php` references `views/404.php`. That file is **not present** under `/Users/saadkhan/Documents/MyRepos/modal/views/` (glob found no `404.php`). Request says: if a view is missing, stop for human clarification.
- **Order vs permissions:** Legacy runs `$public_pages` include+exit, then unauthenticated → login, then **can_view 403**, then DB, then whitelist/404. So a slug with empty `can_view` never reaches 404. This item’s request puts permissions **out of scope**; verification still asks for unregistered → 404 like core.

## Constraints found

- Keep `?page=` query strings; one deployable; do not relocate LTL/P2P/Sales views; do not implement feature page bodies.
- Default authenticated landing remains `tariff_query` (00001 + domain [Tarifabfrage](/knowledge/domain/tarifabfrage.md)).
- Apache docroot stays `public/` (Dockerfile). v2 currently uses `pages/` not `views/`.
- `$page_module` must be set for later layout (00003).

## Open questions

- Missing `views/404.php` in modal — invent vs copy from sandbox vs other file.
- Whether this slice copies the **full** `$allowed_pages` map (all slugs, including LTL/P2P/Sales metadata) or a **minimal** registry (login + tariff_query + stub) that later items extend.
- 404 vs 403 order before 00004 ships (see 00004).
