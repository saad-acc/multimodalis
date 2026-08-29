# Discovery

## Existing systems / prior art

- **Legacy:** `sales_offer_editor` (no nav) → `views_sales/sales_offer_editor.php` → many `sales_offer_*` APIs + `sales_offer_pdf_api.php`. PDF: `SalesPdfService`, Dompdf in `vendor/`. Rollout 00129.

## Open questions

- Confirm v2 Cloud Run image may include Dompdf/vendor as modal vs another generator while keeping the same PDF URL.
