# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Partners can request intermodal quotes via the existing bearer JSON API as on BestModal.

## Stakeholder requirements
- [Partner]: Same POST contract + handler after query results exist (00024).
- [Ops]: Token auth via `api_token_auth.php`.

## Solution requirements

### Functional
- FR1: Port `externapi/index.php` registry and `handlers/intermodaltariffs.php` + formatter.
- FR2: Keep `?api=intermodaltariffs` and bearer/query/body token as modal.

### Non-functional
- NFR1: Do not add portrates/depotlookup handlers. Calculation matches 00024.

## Needs clarification
- What public path must partners hit on Cloud Run (`/externapi/?api=intermodaltariffs` vs a `/modal/` prefix)?
