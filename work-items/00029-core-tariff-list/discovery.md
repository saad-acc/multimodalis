# Discovery

## Existing systems / prior art

- **Legacy:** `tariff_list` → `views/tariff_list.php` → `get_tariffs`, `get_routes`, `add_lane`, `delete_route`, `delete_tariff_and_related`, `change_tariff_status`, `update_tariff_validity`, `export_tariffs_excel`, `mirror_all_in_tariff` (split 00067), `mirror_truck_roundtrip_tariff`, `sync_external_tariffs`.
- **v2:** None.

## Constraints found

- Request: list can ship without background mirrors (00067). Keep `/api/` names used by the view except defer worker family to 00067 if requested split.
- depends_on: 00028.

## Open questions

- Confirm list UI may show mirror buttons that 404 until 00067, vs hide buttons until then (request says split so list ships without mirrors).
