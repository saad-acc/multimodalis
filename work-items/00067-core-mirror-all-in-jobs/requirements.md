# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Tariff list can start KV all-in mirror jobs using the same JSON/worker URLs as BestModal.

## Stakeholder requirements
- [Tariff admin]: Mirror from 00029 UI once this item lands.
- [Ops]: Keep PHP workers, not a new queue.

## Solution requirements

### Functional
- FR1: Port `mirror_all_in_tariff*` JSON/worker/finalize/progress at modal `/api/` names.
- FR2: Do not rebuild tariff_list UI (00029).

### Non-functional
- NFR1: Same hosting pattern as 00055.

## Needs clarification
- Confirm mirror workers use the same Cloud Run hosting pattern as 00055.
