# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Users can edit a sales offer (sections, costs, PDF) as on BestModal.

## Stakeholder requirements
- [Sales user]: `?page=sales_offer_editor` + all `sales_offer_*` and PDF URLs.

## Solution requirements

### Functional
- FR1: Port `views_sales/sales_offer_editor.php`.
- FR2: Port all `sales_offer_*` APIs plus `sales_offer_pdf_api.php` at modal paths.
- FR3: PDF output matches modal (Dompdf stack) unless ops names another generator at the same URL.

### Non-functional
- NFR1: Not a top-level nav item. Group rollout is 00129.

## Needs clarification
- Confirm the Cloud Run image may ship modal’s Dompdf/`vendor/` for PDF, or ops requires a different generator while keeping the same PDF URL.
