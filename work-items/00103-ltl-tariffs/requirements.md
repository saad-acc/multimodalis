# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Admins can view the LTL tariff matrix as on BestModal.

## Stakeholder requirements
- [Admin]: `?page=ltl_tariffs` + matrix API.

## Solution requirements

### Functional
- FR1: Port `viewsltl/ltl_tariffs.php`.
- FR2: Port `apiltl/ltl_tariffs_matrix_api.php`.

### Non-functional
- NFR1: Keep `apiltl/` path. 503 if no `$pdo_ltl`.

## Needs clarification
