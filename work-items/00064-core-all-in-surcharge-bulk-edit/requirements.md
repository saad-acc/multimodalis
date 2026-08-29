# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Users can mass-edit KV surcharges as on BestModal.

## Stakeholder requirements
- [Tariff admin]: `?page=all_in_surcharge_bulk_edit` + bulk_update JSON.

## Solution requirements

### Functional
- FR1: Port `views/all_in_surcharge_bulk_edit.php`.
- FR2: Port `/api/all_in_surcharge_bulk_update.php`.

### Non-functional
- NFR1: Behaviour matches modal doc + UI, not a new grid product.

## Needs clarification
