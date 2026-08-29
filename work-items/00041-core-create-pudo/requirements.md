# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Users can create PUDO charges (including CSV/template) as on BestModal.

## Stakeholder requirements
- [Tariff admin]: `?page=create_pudo_charges` + save/upload/template URLs.

## Solution requirements

### Functional
- FR1: Port `views/create_pudo_charges.php`.
- FR2: Port `/api/save_pudo_charges.php`, `/api/upload_pudo_csv.php`, `/api/download_pudo_template.php`.

### Non-functional
- NFR1: Keep PHP file upload; no new queue.

## Needs clarification
