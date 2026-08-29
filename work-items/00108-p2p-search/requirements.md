# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Users can search P2P FCL/LCL rates as on BestModal.

## Stakeholder requirements
- [User]: `?page=port2port_search` + listed `apipp/` URLs.

## Solution requirements

### Functional
- FR1: Port `viewspp/p2p_search.php` with module/view_path.
- FR2: Port `apipp/p2p_ports_search.php`, `p2p_search_results.php`, `p2p_search_results_lcl.php`, `calculate_lcl_rate.php`, `calculate_lcl_local_charge.php`.

### Non-functional
- NFR1: Keep `apipp/` paths. Do not add unregistered nav slugs.

## Needs clarification
