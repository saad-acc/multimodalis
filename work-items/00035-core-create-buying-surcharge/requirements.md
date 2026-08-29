# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Users can create buying surcharges as on BestModal.

## Stakeholder requirements
- [Tariff admin]: `?page=create_buying_surcharge` + save JSON.

## Solution requirements

### Functional
- FR1: Port `views/create_buying_surcharge.php`.
- FR2: Port `/api/save_buying_surcharge.php` and lookup `/api/` the view calls.

### Non-functional
- NFR1: Not selling-surcharge (00039) or all-in KV (00059).

## Needs clarification
