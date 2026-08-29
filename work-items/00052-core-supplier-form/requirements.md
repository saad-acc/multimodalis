# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Users can create/edit suppliers and contacts as on BestModal.

## Stakeholder requirements
- [Tariff admin]: `?page=supplier_form` + listed JSON.

## Solution requirements

### Functional
- FR1: Port `views/supplier_form.php`.
- FR2: Port `/api/save_supplier.php`, `/api/supplier_contacts_api.php`, `/api/fetch_addresses_by_postal.php`.

### Non-functional
- NFR1: Postal lookup only; not bulk geocoding 00086.

## Needs clarification
