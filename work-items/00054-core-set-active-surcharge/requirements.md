# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Users can use the legacy set-active-surcharge helper page as on BestModal.

## Stakeholder requirements
- [Tariff admin]: `?page=set_active_surcharge` + APIs that page calls.

## Solution requirements

### Functional
- FR1: Port `views/set_active_surcharge.php`.
- FR2: Port `/api/` invoked by that view, same filenames.

### Non-functional
- NFR1: Do not replace 00065 KV all-in active manager.

## Needs clarification
