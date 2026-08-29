# Discovery

## Existing systems / prior art

- **v2:** Only `public/api/check_login.php`. No `Modules/Core/Http/`. Apache rewrite enabled in Dockerfile; no existing map from `/api/*.php` to a Modules tree.
- **Legacy Core HTTP (1:1 inventory):** public URLs `/api/<file>.php` ↔ files in `/Users/saadkhan/Documents/MyRepos/modal/api/*.php` (**255 PHP files** in that folder). Request sample: `/api/load_tariffs.php`. Out of this item: `apiltl/`, `apipp/`, `api_sales/`/`apisales/`, `externapi/`, LTL/P2P/Sales API moves.
- **Lang JSON** (`api/lang_*.php`, `language_switch.php`) is 00137, not this slice’s feature work, but those files sit in the same `api/` directory.
- **Request constraint:** MAY need business_clarification: **physical folder move** vs **rewrite-rule / include map**. Do not change public JSON URLs. No REST redesign. No feature behaviour change. Depends on 00002.

## Constraints found

- Docroot is `public/`; a `Modules/` tree at repo root would not be web-reachable unless rewrite/include from `public/api/`.
- One deployable; keep `?page=` unchanged.

## Open questions

- Physical move vs rewrite/include map (must not assume).
- How many files this slice moves (pattern + one sample vs entire Core `api/`).
