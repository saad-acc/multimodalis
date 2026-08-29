# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Inbound RFQ email can trigger the same quote-and-reply pipeline as BestModal.

## Stakeholder requirements
- [Ops]: Same POST URL and secret query as modal.
- [Customer]: HTML reply via `templates/email_rfq_result_html.php`.

## Solution requirements

### Functional
- FR1: Port `POST /api/inbound_rfq_email.php` plus `services/RfqEmailService.php` and `TariffQueryRunner.php` behaviour.
- FR2: Keep public whitelist like modal `auth_check.php`.

### Non-functional
- NFR1: No new queue; calculation matches 00024 engine.

## Needs clarification
- Which inbound mail provider and `secret` value will production Multimodalis use, and is it the same as sandbox modal?
