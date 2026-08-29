# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Users can list and delete LWS surcharges as on BestModal.

## Stakeholder requirements
- [Tariff admin]: `?page=low_water_surcharge_list` + delete API.

## Solution requirements

### Functional
- FR1: Port `views/low_water_surcharge_list.php`.
- FR2: Port `/api/delete_low_water_surcharge.php`.

### Non-functional
- NFR1: Session-gated.

## Needs clarification
