# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Admins can see LTL import history as on BestModal.

## Stakeholder requirements
- [Admin]: `?page=ltl_imports` using `$pdo_ltl` in the view.

## Solution requirements

### Functional
- FR1: Port `viewsltl/ltl_imports.php` with the same direct PDO queries.
- FR2: Do not add a new fetch API.

### Non-functional
- NFR1: 503/hint if `$pdo_ltl` null.

## Needs clarification
