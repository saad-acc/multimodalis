# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Users can see tariff–surcharge relations as on BestModal.

## Stakeholder requirements
- [Tariff admin]: `?page=tariff_surcharge_overview` + relation APIs.

## Solution requirements

### Functional
- FR1: Port `views/tariff_surcharge_overview.php`.
- FR2: Port `/api/tariff_surcharge_relations.php` (and related if the view calls them).

### Non-functional
- NFR1: Do not create new surcharge types here.

## Needs clarification
