# Discovery

## Existing systems / prior art

- **v2:** Dockerfile `COPY public/` only. `.gitignore` has no playground rules. No `.gcloudignore`. Nothing named playground in this repo.
- **Legacy 1:1 playground (modal `playground/`):**
  - `compare_address_content_platform.php`
  - `JL.html`
  - `db_config.local.php` (local secrets pattern — must not ship)
- **Legacy debug-style Core APIs (same public URL space `/api/`):** `view_debug_log.php`; `test_*.php` under `modal/api/` including `test_route_trace_nl_pl.php`, `test_tariff49_country_km.php`, `test_single_truck_query.php`, `test_routing_ptv.php`, `test_rotterdam_routes.php`, `test_pudo_charges.php`, `test_multiple_truck_queries.php`, `test_fetch_saved_queries.php`, `test_ews_vs_routing.php`, `test_distancemultiple.php`, `test_distance_mg.php`, `test_bulk_geocoding_minimal.php`, `test_bulk_geocoding.php`, `test_auto_geocoding.php`, `create_rotterdam_routes_test.php`. Request says exclude playground/debug from **production** paths; do not delete all local debug forever.
- **No new `?page=` slugs.** Deploy/notes only for keeping them local. Front-controller deny, gitignore, and/or image omit are all allowed by the request.

## Constraints found

- Production Cloud Run image currently cannot serve `modal/playground/` unless someone copies it under `public/`. Risk grows when more APIs are copied into `public/api/`.
- Match-legacy: production must not hit playground/debug URLs; `$allowed_pages` behaviour unchanged.

## Open questions

- Exact deny-list: `playground/` only vs also `/api/test_*.php` and `view_debug_log.php`.
- Mechanism: omit from Docker image vs Apache deny vs runtime env vs gitignore only (gitignore does not protect a copied file in CI).
