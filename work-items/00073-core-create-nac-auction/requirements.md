# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Users can create NAC auctions and send invitations as on BestModal.

## Stakeholder requirements
- [Initiator]: `?page=create_nac_auction` + save_nac_* + invitations + summary.

## Solution requirements

### Functional
- FR1: Port `views/create_nac_auction.php`.
- FR2: Port `/api/save_nac_*.php`, `/api/send_nac_invitations.php`, `/api/fetch_nac_summary.php`.

### Non-functional
- NFR1: Keep `/api/` filenames; Mailer as modal.

## Needs clarification
- Must `send_nac_invitations` send real mail in this slice, or is stub acceptable until SMTP is confirmed?
