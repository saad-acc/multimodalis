# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Users can run the Core multimodal/port-to-door query screen as on BestModal.

## Stakeholder requirements
- [User]: `?page=port_to_door_view` plus listed fetch APIs.

## Solution requirements

### Functional
- FR1: Port `views/port_to_door_view.php` at `?page=port_to_door_view`.
- FR2: Port `/api/fetch_port_to_door_results.php` and `/api/fetch_p2p_ports.php`.

### Non-functional
- NFR1: Do not move this page into `viewspp/` or change the slug.

## Needs clarification
