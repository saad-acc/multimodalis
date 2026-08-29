# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Users can generate generic CSV upload templates as on BestModal.

## Stakeholder requirements
- [Tariff admin]: `?page=create_upload_template` + generate/upload_handler URLs.

## Solution requirements

### Functional
- FR1: Port `views/create_upload_template.php`.
- FR2: Port `/api/generate_csv_template.php` and `/api/upload_handler.php`.

### Non-functional
- NFR1: Keep PHP entrypoints; no new queue.

## Needs clarification
