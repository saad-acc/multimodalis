# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Tarifabfrage can obtain km/duration for a query the same way as BestModal.

## Stakeholder requirements
- [User]: Distance calls from tariff_query match modal payloads.
- [Ops]: No new job queue; same PHP endpoints.

## Solution requirements

### Functional
- FR1: Port `/api/distancemultiple_indb.php` and related distance helpers tariff_query actually calls, same paths.
- FR2: Cache behaviour matches modal (DB cache vs live PTV/EWS).

### Non-functional
- NFR1: Provider secrets only via env. p95 may exceed typical API SLAs when PTV is slow — match modal, do not invent a new timeout product.

## Needs clarification
- Must PTV/EWS be live in this slice, or is DB-cached distance (`distancemultiple_indb`) sufficient until routing keys are on Cloud Run?
