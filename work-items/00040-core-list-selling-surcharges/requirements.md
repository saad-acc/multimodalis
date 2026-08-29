# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Users can list and delete selling surcharges as on BestModal.

## Stakeholder requirements
- [Tariff admin]: `?page=list_selling_surcharges` + fetch/delete JSON.

## Solution requirements

### Functional
- FR1: Port `views/list_selling_surcharges.php`.
- FR2: Port `/api/fetch_selling_surcharges.php` and `/api/delete_selling_surcharges.php`.

### Non-functional
- NFR1: Session-gated.

## Needs clarification
