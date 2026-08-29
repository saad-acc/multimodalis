# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Users can compare surcharges/prices as on BestModal.

## Stakeholder requirements
- [Tariff admin]: `?page=zuschlagsvergleich` + comparison JSON.

## Solution requirements

### Functional
- FR1: Port `views/zuschlagsvergleich.php`.
- FR2: Port `/api/get_price_comparison_data.php` (and related if used).

### Non-functional
- NFR1: Session-gated.

## Needs clarification
