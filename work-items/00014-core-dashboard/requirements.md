# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Role-permitted users see the same dashboard widgets and fetches as BestModal.

## Stakeholder requirements
- [User]: `?page=dashboard` with layout/nav; widgets load via listed JSON URLs.
- [Ops]: Capacity KPI numbers may be empty until 00071; still call the same endpoint.

## Solution requirements

### Functional
- FR1: Serve `views/dashboard.php` at `index.php?page=dashboard` with chrome and can_view.
- FR2: Port `/api/load_tariffs.php`, `/api/load_routes.php`, `/api/load_surcharges.php`, `/api/load_pickup_dropoff.php`, `/api/fetch_capacity_kpi.php` at those paths.

### Non-functional
- NFR1: Session-gated APIs use the same auth_check rules as modal.

## Needs clarification
