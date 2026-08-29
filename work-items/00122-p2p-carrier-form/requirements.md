# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Users can maintain P2P carriers via the Core API paths as on BestModal.

## Stakeholder requirements
- [Admin]: `?page=p2p_carrier_form` + those two `/api/` URLs.

## Solution requirements

### Functional
- FR1: Port `viewspp/carrier_form_p2p.php`.
- FR2: Port `/api/save_carrier_p2p.php` and `/api/delete_carrier_p2p.php` (not under apipp).

### Non-functional
- NFR1: Do not relocate those endpoints to apipp.

## Needs clarification
