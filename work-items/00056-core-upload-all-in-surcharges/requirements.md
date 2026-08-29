# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Users can upload KV all-in/zone surcharge CSVs as on BestModal.

## Stakeholder requirements
- [Tariff admin]: `?page=upload_all_in_surcharges` + import `/api/` used by the view.

## Solution requirements

### Functional
- FR1: Port `views/upload_all_in_surcharges.php`.
- FR2: Port import `/api/` the view calls, same filenames as modal.

### Non-functional
- NFR1: Keep PHP workers; follow 00055 hosting decision.

## Needs clarification
- Confirm this slice uses the same worker hosting decision as 00055 (do not invent a second pattern).
