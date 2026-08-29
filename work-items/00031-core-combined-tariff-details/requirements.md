# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Users can view combined tariff details as on BestModal.

## Stakeholder requirements
- [User]: `?page=combined_tariff_details` plus any `/api/` the view uses.

## Solution requirements

### Functional
- FR1: Port `views/combined_tariff_details.php` at `?page=combined_tariff_details`.
- FR2: Port related `/api/` 1:1 if the view calls them.

### Non-functional
- NFR1: Session/can_view as modal.

## Needs clarification
