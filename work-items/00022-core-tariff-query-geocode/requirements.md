# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Users can type and resolve addresses on Tarifabfrage the same way as BestModal before distance/results land.

## Stakeholder requirements
- [User]: Address widgets on `?page=tariff_query` call the listed `/api/` geocode/filter endpoints.
- [Ops]: Provider keys stay env-based, not hardcoded.

## Solution requirements

### Functional
- FR1: Bind tariff_query UI to `/api/check_and_geocode_address.php`, `/api/filter_addressnew.php`, `/api/fetch_addresses.php`, `/api/check_postal_code.php`.
- FR2: JSON request/response match modal for the same payloads.

### Non-functional
- NFR1: Do not add REST address resources. Session rules match modal APIs.

## Needs clarification
- Are geocoding API credentials for Cloud Run confirmed (same providers as modal), or is a sandbox-key gap expected in this slice?
