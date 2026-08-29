# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Currency rates can sync via the same PHP cron URL as BestModal.

## Stakeholder requirements
- [Ops]: `/api/sync_currencies.php` production-callable like modal.

## Solution requirements

### Functional
- FR1: Port `/api/sync_currencies.php` with modal FX source behaviour.
- FR2: Keep whitelist/public cron contract.

### Non-functional
- NFR1: No new job platform.

## Needs clarification
- Who schedules `sync_currencies.php` on Cloud Run, and must auth match sandbox modal?
