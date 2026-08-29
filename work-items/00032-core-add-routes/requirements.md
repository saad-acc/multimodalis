# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Users can add tariff routes/terminal groups as on BestModal.

## Stakeholder requirements
- [Tariff admin]: `?page=add_routes` plus listed `/api/`.

## Solution requirements

### Functional
- FR1: Port `views/add_routes.php`.
- FR2: Port `/api/save_route.php`, `/api/save_terminal_group.php`, `/api/fetch_terminals_by_port.php`, `/api/get_terminal_routes_for_tariff.php`.

### Non-functional
- NFR1: Session-gated; keep filenames.

## Needs clarification
