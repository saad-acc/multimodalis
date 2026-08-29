# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Users can list and maintain tariffs (status, lanes, export) as on BestModal without waiting for mirror workers.

## Stakeholder requirements
- [Tariff admin]: `?page=tariff_list` plus list/edit/delete/export APIs.
- [Ops]: Mirror job URLs belong to 00067.

## Solution requirements

### Functional
- FR1: Port `views/tariff_list.php` at `?page=tariff_list`.
- FR2: Port list/maintenance `/api/` the view needs except `mirror_all_in_tariff*` (00067).
- FR3: Export Excel matches modal.

### Non-functional
- NFR1: Session-gated. Do not introduce a new job platform.

## Needs clarification
- Until 00067 lands, should mirror controls be omitted/disabled, or left calling URLs that are not yet ported?
