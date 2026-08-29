# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
External read models for query results, purchase details, and headers stay on the same `/api/*_external.php` URLs as BestModal.

## Stakeholder requirements
- [Partner]: Those three JSON URLs match modal auth and payload.
- [Internal]: Browser purchase page remains 00030.

## Solution requirements

### Functional
- FR1: Port `/api/tariff_query_results_external.php`, `/api/tariff_purchase_details_external.php`, `/api/get_tariff_headers_external.php`.
- FR2: Keep token auth as in `auth_check.php` whitelist.

### Non-functional
- NFR1: Not `externapi/?api=intermodaltariffs` (00135).

## Needs clarification
