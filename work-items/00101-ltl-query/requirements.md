# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Users can run LTL/FTL rate queries as on BestModal.

## Stakeholder requirements
- [User]: `?page=ltl_query` + `apiltl/` query JSON; packing + `sp_get_rate`.
- [Ops]: 503 when `$pdo_ltl` is null, like modal.

## Solution requirements

### Functional
- FR1: Port `viewsltl/ltl_query.php` with module/view_path metadata.
- FR2: Port `apiltl/ltl_carrier_configs_api.php` and `apiltl/ltl_query_api.php` (and save_ltl_quote if the view posts it).
- FR3: Keep `apiltl/` public paths; no REST dump.

### Non-functional
- NFR1: Uses `$pdo_ltl` only. localStorage last-five like modal.

## Needs clarification
- Confirm sandbox Cloud SQL exposes the LTL database the same way as modal (`ltl_db_name` per tenant) so `$pdo_ltl` is not permanently null.
