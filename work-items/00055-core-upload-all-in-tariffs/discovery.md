# Discovery

## Existing systems / prior art

- **Legacy (kv-all-in):** `upload_all_in_tariffs` → `views/upload_all_in_tariffs.php` → `create_all_in_tariff.php`, `import_csv_background.php`, `import_csv_worker.php`.
- **v2:** None. Cloud Run request timeout vs long workers.

## Constraints found

- Keep public PHP worker URLs; no new job platform. Out of scope: surcharge CSV 00056; mirrors 00067. depends_on: 00006.

## Open questions

- How should background import run on Cloud Run (self-HTTP worker like modal vs Cloud Tasks) while still exposing the same `/api/import_csv_worker.php` URL?
