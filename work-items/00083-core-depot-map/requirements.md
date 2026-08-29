# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Users can view the depot map as on BestModal.

## Stakeholder requirements
- [User]: `?page=depot_map` + depot fetch APIs.

## Solution requirements

### Functional
- FR1: Port `views/depot_map.php`.
- FR2: Port `/api/fetch_depots.php` and `/api/fetch_depots_by_carrier.php`.

### Non-functional
- NFR1: Session-gated.

## Needs clarification
