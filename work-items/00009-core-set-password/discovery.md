# Discovery

## Existing systems / prior art

- **v2:** [Multimodalis PHP app](../../knowledge/components/multimodalis-php-app.md) — `public/` login + Tarifabfrage chrome; no `set_password` slice.
- **Legacy:** [Legacy BestModal PHP](../../knowledge/components/legacy-bestmodal-php.md). Feature map [shell-auth.md](file:///Users/saadkhan/Documents/MyRepos/modal/docs/feature-map/shell-auth.md): slug `set_password`, public (no layout).
- **1:1 modal files:** `views/set_password.php`; `api/check_token.php`; `api/save_password.php`.
- **Domain:** [page-module-view-path](../../knowledge/domain/page-module-view-path.md), [can-view](../../knowledge/domain/can-view.md) (public page; gate still needed for non-public siblings).

## Constraints found

- Keep `index.php?page=set_password` and `/api/check_token.php`, `/api/save_password.php`. No REST password API.
- depends_on: 00002, 00004. Invitation token lives on the user record (`$pdo` / Cloud SQL — 00006).
- Piecemeal: do not port user_management in this item.

## Open questions

(none that block a 1:1 port of the named files)
