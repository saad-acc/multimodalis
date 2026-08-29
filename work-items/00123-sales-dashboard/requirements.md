# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Users can open the Sales dashboard as on BestModal.

## Stakeholder requirements
- [Sales user]: `?page=sales_dashboard` using `$pdo_sales` in the view.

## Solution requirements

### Functional
- FR1: Port `views_sales/sales_dashboard.php` with sales module/view_path.
- FR2: Do not invent a fetch API the view does not use.

### Non-functional
- NFR1: Null `$pdo_sales` should fail like modal (hint/error), not crash the whole app.

## Needs clarification
- Confirm sandbox Cloud SQL and public path (`apisales/` vs `api_sales/`) for Sales match modal before this first Sales page ships.
