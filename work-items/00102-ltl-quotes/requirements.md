# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Users can review saved LTL quotes as on BestModal.

## Stakeholder requirements
- [User]: `?page=ltl_quotes` + apiltl fetch/stats.

## Solution requirements

### Functional
- FR1: Port `viewsltl/ltl_quotes.php`.
- FR2: Port `apiltl/fetch_ltl_quotes.php` and `apiltl/fetch_ltl_quotes_stats.php`.

### Non-functional
- NFR1: 503 if `$pdo_ltl` null.

## Needs clarification
