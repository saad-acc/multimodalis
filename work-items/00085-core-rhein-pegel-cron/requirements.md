# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Rhine gauge data can be ingested on a schedule via the same PHP URL as BestModal.

## Stakeholder requirements
- [Ops]: Production-callable `/api/save_rhein_pegel.php` like modal.

## Solution requirements

### Functional
- FR1: Port `/api/save_rhein_pegel.php` as a public cron entrypoint.
- FR2: Persist so 00081 map can load levels.

### Non-functional
- NFR1: No new job platform.

## Needs clarification
- Who schedules `save_rhein_pegel.php` on Cloud Run, and must auth/query match sandbox modal?
