# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Users can run KV surcharge validation as on BestModal.

## Stakeholder requirements
- [Tariff admin]: `?page=validate_all_in_surcharges` + validate JSON.

## Solution requirements

### Functional
- FR1: Port `views/validate_all_in_surcharges.php`.
- FR2: Port validate `/api/` the view uses.

### Non-functional
- NFR1: Session-gated.

## Needs clarification
