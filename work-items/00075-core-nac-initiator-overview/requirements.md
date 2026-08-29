# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Initiators can overview NAC auctions as on BestModal.

## Stakeholder requirements
- [Initiator]: `?page=nac_initiator_overview` + summary APIs.

## Solution requirements

### Functional
- FR1: Port `views/nac_initiator_overview.php`.
- FR2: Port `/api/fetch_nac_auction_summary.php` and related `/api/` the view uses.

### Non-functional
- NFR1: Session-gated.

## Needs clarification
