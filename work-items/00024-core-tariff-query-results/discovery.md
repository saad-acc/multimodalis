# Discovery

## Existing systems / prior art

- **Legacy:** `api/tariff_query_results.php`, `tariff_query_results_distance.php`, `combine_tariff_query.php`; helpers `includes/tariff_helpers.php`, `FreightCalculator.php`. Same engine as extern API / inbound RFQ later.
- **v2:** No results grid.

## Constraints found

- Keep `/api/` names. Bind on `tariff_query` UI. depends_on: 00023. Unblocks 00025, 00079, 00135.

## Open questions

(none for 1:1 port; calculation must match modal given same DB)
