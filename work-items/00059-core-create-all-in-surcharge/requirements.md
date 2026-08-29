# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Users can manually create KV all-in surcharges in batch as on BestModal.

## Stakeholder requirements
- [Tariff admin]: `?page=create_all_in_surcharge` + batch save + route fetches.

## Solution requirements

### Functional
- FR1: Port `views/create_all_in_surcharge.php`.
- FR2: Port `/api/save_routes_allin_surcharge_batch.php` and route-fetch `/api/` the view uses.

### Non-functional
- NFR1: Do not invent `select_all_in_tariff` UI (00068).

## Needs clarification
