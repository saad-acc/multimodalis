# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Capacity mail tokens and auto-close cron work on Multimodalis with the same PHP URLs as BestModal.

## Stakeholder requirements
- [Supplier]: Token respond URL in mail works without session.
- [Ops]: Auto-close remains a public PHP file; schedule is ops-owned.

## Solution requirements

### Functional
- FR1: Port `/api/capacity_request_respond.php` token behaviour.
- FR2: Port `/api/capacity_request_auto_close.php` as production-callable cron like modal.

### Non-functional
- NFR1: No new job platform. Keep whitelist behaviour in auth_check equivalent.

## Needs clarification
- Who schedules `capacity_request_auto_close.php` on Cloud Run (Cloud Scheduler vs other), and must the secret/query match sandbox modal?
