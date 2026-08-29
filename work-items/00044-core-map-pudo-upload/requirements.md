# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Users can map and import PUDO CSV as on BestModal.

## Stakeholder requirements
- [Tariff admin]: `?page=map_pudo_upload` + save/import APIs.

## Solution requirements

### Functional
- FR1: Port `views/map_pudo_upload.php`.
- FR2: Port `/api/save_pudo_mappings.php` and `/api/import_pudo_charges.php`.

### Non-functional
- NFR1: Same public PHP paths; no new job queue.

## Needs clarification
