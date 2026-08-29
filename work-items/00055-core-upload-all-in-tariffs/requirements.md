# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Users can upload KV all-in tariff CSVs using the same pages and worker URLs as BestModal.

## Stakeholder requirements
- [Tariff admin]: `?page=upload_all_in_tariffs` + create + background/worker paths.
- [Ops]: No new queue product unless humans later say so; request says keep PHP workers.

## Solution requirements

### Functional
- FR1: Port `views/upload_all_in_tariffs.php`.
- FR2: Port `/api/create_all_in_tariff.php`, `/api/import_csv_background.php`, `/api/import_csv_worker.php` at those paths.

### Non-functional
- NFR1: Worker must remain a public PHP file like modal. Cloud Run max timeout must still complete a typical import or match modal’s chunking.

## Needs clarification
- How should background import run on Cloud Run while keeping `/api/import_csv_worker.php` — modal-style self-call, Cloud Tasks hitting that URL, or another ops-approved pattern?
