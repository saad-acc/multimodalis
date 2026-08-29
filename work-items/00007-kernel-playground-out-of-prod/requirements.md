# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Production Multimodalis must not expose modal playground/debug toys as public HTTP once more APIs are online.

## Stakeholder requirements
- [Ops / security]: Production image/routes cannot execute playground/debug URLs.
- [Developers]: Local debug may remain; do not delete all debug forever.
- [Users]: No new `?page=` slugs; whitelist behaviour unchanged.

## Solution requirements

### Functional
- FR1: Production deploy must not serve the legacy playground tree (`playground/compare_address_content_platform.php`, `playground/JL.html`, `playground/db_config.local.php`) over HTTP.
- FR2: Document in deploy notes how developers keep debug local (gitignore / image omit / deny).
- FR3: Do not add public routes for playground. Do not change `?page=` whitelist.
- FR4: Do not rewrite feature APIs in this item.

### Non-functional
- NFR1: `db_config.local.php` (and any playground credentials) must never appear in the Cloud Run image or git.
- NFR2: Verification: requesting a listed production-forbidden URL on the production-shaped image returns non-success (404/403) and does not run the script.

## Needs clarification
- Which paths are in the production deny-list besides `modal/playground/` — all `api/test_*.php`, `api/view_debug_log.php`, `create_rotterdam_routes_test.php`, others?
- Preferred control: not copying into `public/` / Docker, Apache/front-controller deny if files exist, `.gcloudignore`, or a combination?
