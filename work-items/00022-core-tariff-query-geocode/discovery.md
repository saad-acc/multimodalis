# Discovery

## Existing systems / prior art

- **v2:** `page=tariff_query` chrome stub exists ([tarifabfrage](../../knowledge/domain/tarifabfrage.md)); geocode APIs not ported.
- **Legacy:** Feature map intermodal-tariffs: `api/check_and_geocode_address.php`, `filter_addressnew.php`, `fetch_addresses.php`, `check_postal_code.php` from `views/tariff_query.php`. Also related: `geocode_addresses.php`, `geocode_ports.php` used elsewhere.

## Constraints found

- Same POST bodies/URLs. Split: this item is address layer only (not distance 00023 / results 00024).
- depends_on: 00003/00006 typically; request: after kernel. Needs geocoding provider keys as modal.

## Open questions

- Which geocode backend must Cloud Run use (same as sandbox modal env), and are keys already in v2 env?
