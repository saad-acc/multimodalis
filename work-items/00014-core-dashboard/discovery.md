# Discovery

## Existing systems / prior art

- **v2:** Post-login landing is Tarifabfrage stub, not dashboard.
- **Legacy:** Feature map shell-auth: `dashboard` → `views/dashboard.php` → `api/load_tariffs.php`, `load_routes.php`, `load_surcharges.php`, `load_pickup_dropoff.php`, `fetch_capacity_kpi.php`.
- **Domain:** can_view for authenticated chrome.

## Constraints found

- Keep slug `dashboard` and those `/api/` names. Out of scope: tariff query engine; capacity CRUD (00071).
- depends_on: 00003, 00004; data via 00006. KPI related to RFQ/capacity later.

## Open questions

(none)
