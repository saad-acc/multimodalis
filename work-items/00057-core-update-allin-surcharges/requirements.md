# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Users can batch-update KV surcharges from file as on BestModal.

## Stakeholder requirements
- [Tariff admin]: `?page=update_allin_surcharges` + process/template APIs.

## Solution requirements

### Functional
- FR1: Port `views/update_allin_surcharges.php`.
- FR2: Port `/api/process_surcharge_update.php`, `/api/generate_surcharge_update_template.php`, and related APIs the view uses (`get_surcharges_for_tariff`, `update_surcharges_valid_until`, `check_surcharge_import_status`).

### Non-functional
- NFR1: History page is 00058.

## Needs clarification
