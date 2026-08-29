# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Users can persist a tariff query result/offer from Tarifabfrage as on BestModal.

## Stakeholder requirements
- [User]: Save actions call the two `/api/` URLs with modal payloads.
- [Sales-ops]: Saved rows appear later on offer_list (00069).

## Solution requirements

### Functional
- FR1: Port `/api/save_tariff_query_result.php` and `/api/save_offer.php`.
- FR2: Wire save controls on `?page=tariff_query` as in modal.

### Non-functional
- NFR1: Session-gated; no REST offers API.

## Needs clarification
