# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Users can manage sales customer groups as on BestModal.

## Stakeholder requirements
- [Sales admin]: `?page=sales_customer_groups` + groups API.

## Solution requirements

### Functional
- FR1: Port `views_sales/sales_customer_groups.php`.
- FR2: Port `sales_customer_groups_api` at modal public path.

### Non-functional
- NFR1: `$pdo_sales`. Follow 00123 path decision.

## Needs clarification
