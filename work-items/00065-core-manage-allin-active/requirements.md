# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Users can activate/switch KV all-in surcharges as on BestModal.

## Stakeholder requirements
- [Tariff admin]: `?page=manage_allin_surcharge_active` + APIs the page calls.

## Solution requirements

### Functional
- FR1: Port `views/manage_allin_surcharge_active.php`.
- FR2: Port `/api/` used by that view.

### Non-functional
- NFR1: Do not merge with 00054.

## Needs clarification
