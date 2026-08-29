# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Users who must complete 2FA after login can verify on Multimodalis the same way as on BestModal.

## Stakeholder requirements
- [User]: `?page=verify_2fa` plus send/verify JSON work like modal, including trusted-device behaviour modal already has.
- [Security]: Do not weaken rate-limiting or code expiry vs modal.

## Solution requirements

### Functional
- FR1: Serve `index.php?page=verify_2fa` from a port of `views/verify_2fa.php` (public, no chrome).
- FR2: `/api/send_2fa_code.php` and `/api/verify_2fa.php` match modal HTTP/JSON and session outcomes.
- FR3: Trusted-device table usage matches modal (`trusted_devices`).

### Non-functional
- NFR1: Codes travel only over the same channel modal uses (email via Mailer), not a new SMS product.
- NFR2: Endpoints remain on `/api/` filenames; session cookie flags match modal after success.

## Needs clarification
- Is production Multimodalis required to send 2FA mail in this slice (Mailer + SMTP env), or is stub/dev skip acceptable until mail ops is confirmed?
