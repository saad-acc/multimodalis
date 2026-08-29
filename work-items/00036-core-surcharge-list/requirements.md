# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Users can list and maintain buying surcharges (including km tiers) as on BestModal.

## Stakeholder requirements
- [Tariff admin]: `?page=surcharge_list` + those `/api/` filenames.

## Solution requirements

### Functional
- FR1: Port `views/surcharge_list.php`.
- FR2: Port get/save/copy/delete and km-tier `/api/` used by the view, same names as modal.

### Non-functional
- NFR1: Session-gated.

## Needs clarification
