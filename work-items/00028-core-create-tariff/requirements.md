# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Users can create an intermodal tariff header as on BestModal.

## Stakeholder requirements
- [Tariff admin]: `?page=create_tariff_form` plus create/fetch_suppliers JSON.

## Solution requirements

### Functional
- FR1: Port `views/create_tariff_form.php` at `?page=create_tariff_form`.
- FR2: Port `/api/create_tariff.php` and `/api/fetch_suppliers.php`.

### Non-functional
- NFR1: Session and can_view as modal.

## Needs clarification
