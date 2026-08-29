# Discovery

## Existing systems / prior art

- **Legacy:** module `ltl`, `view_path` `viewsltl`, `$pdo_ltl` from host connectdb. Slug `ltl_query` → `viewsltl/ltl_query.php` → `apiltl/ltl_carrier_configs_api.php`, `ltl_query_api.php`, optional `save_ltl_quote.php`. If `$pdo_ltl` null → 503. Nav slugs not in allowed_pages are out of scope.

## Open questions

- Is LTL a second database on the same Cloud SQL instance (schema name) as modal tenant, or a separate instance? (00006 should make `$pdo_ltl` nullable.)
