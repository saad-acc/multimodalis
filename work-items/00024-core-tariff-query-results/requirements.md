# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Users see combined tariff query results on Tarifabfrage as on BestModal.

## Stakeholder requirements
- [User]: Result grid from the three result JSON URLs.
- [Partners]: Same calculation family as 00135 later.

## Solution requirements

### Functional
- FR1: Port `/api/tariff_query_results.php`, `/api/tariff_query_results_distance.php`, `/api/combine_tariff_query.php`.
- FR2: Wire them from `?page=tariff_query` as in `views/tariff_query.php`.

### Non-functional
- NFR1: Auth/session same as modal Core APIs. No REST rename.

## Needs clarification
