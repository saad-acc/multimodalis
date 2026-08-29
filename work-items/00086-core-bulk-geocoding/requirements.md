# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Admins can bulk-geocode addresses as on BestModal.

## Stakeholder requirements
- [Admin]: `?page=bulk_geocoding_view` + bulk APIs + template download.

## Solution requirements

### Functional
- FR1: Port `views/bulk_geocoding_view.php`.
- FR2: Port `/api/bulk_geocoding_simple.php` and `/api/download_bulk_geocoding_template.php`.

### Non-functional
- NFR1: Reuse 00022 provider keys; no REST.

## Needs clarification
- Confirm bulk geocoding uses the same Cloud Run geocode credentials decision as 00022.
