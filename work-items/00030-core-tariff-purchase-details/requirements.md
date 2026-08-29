# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Users can open purchase-side tariff details as on BestModal.

## Stakeholder requirements
- [User]: `?page=tariff_purchase_details` matches modal (view + any `/api/` it uses except `*_external`).

## Solution requirements

### Functional
- FR1: Port `views/tariff_purchase_details.php` at `?page=tariff_purchase_details`.
- FR2: Port non-external `/api/` the view calls, same filenames.

### Non-functional
- NFR1: can_view + session as modal.

## Needs clarification
