# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Users can view KV surcharge update history as on BestModal.

## Stakeholder requirements
- [Tariff admin]: `?page=view_all_in_surcharges` + update JSON if used.

## Solution requirements

### Functional
- FR1: Port `views/view_all_in_surcharges.php`.
- FR2: Port `/api/update_surcharge.php` and any other `/api/` the view calls.

### Non-functional
- NFR1: Create wizard is 00059.

## Needs clarification
