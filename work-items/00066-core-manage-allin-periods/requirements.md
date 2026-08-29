# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Users can manage KV surcharge validity periods as on BestModal.

## Stakeholder requirements
- [Tariff admin]: `?page=manage_allin_surcharge_periods` + period APIs + snapshot worker URL.

## Solution requirements

### Functional
- FR1: Port `views/manage_allin_surcharge_periods.php`.
- FR2: Port `/api/create_allin_surcharge_period_api.php`, `preview_allin_surcharge_period_api.php`, `allin_surcharge_period_progress.php`, `allin_surcharge_period_delete_api.php` (exact modal filenames).
- FR3: Keep snapshot worker public PHP path as modal.

### Non-functional
- NFR1: No new job product; reuse 00055 hosting decision for workers.

## Needs clarification
- Confirm period snapshot worker uses the same Cloud Run hosting pattern as 00055.
