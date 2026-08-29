# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Users can track capacity requests (archive/award) as on BestModal.

## Stakeholder requirements
- [User]: `?page=capacity_requests` + action JSON (not mail/cron 00072).

## Solution requirements

### Functional
- FR1: Port `views/capacity_requests.php`.
- FR2: Port archive/award/send/save/positions `/api/` the view uses (same names as modal).

### Non-functional
- NFR1: Token respond + auto-close are 00072.

## Needs clarification
