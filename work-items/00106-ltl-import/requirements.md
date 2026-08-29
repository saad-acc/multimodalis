# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Admins can import LTL rates via the CSV wizard as on BestModal.

## Stakeholder requirements
- [Admin]: `?page=ltl_import` + parse/import actions.

## Solution requirements

### Functional
- FR1: Port `viewsltl/ltl_import.php`.
- FR2: Port `apiltl/ltl_import_api.php` actions parse and import.

### Non-functional
- NFR1: Keep query `action=` contract. No new queue.

## Needs clarification
