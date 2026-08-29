# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Admins can manage roles and page permissions the same way as BestModal so can_view stays data-driven.

## Stakeholder requirements
- [Admin]: Matrix save/add-role matches modal.
- [All users]: Nav/403 continue to use `role_page_permissions` after save.

## Solution requirements

### Functional
- FR1: Port `views/role_management.php` at `?page=role_management`.
- FR2: Port `/api/get_role_permissions.php`, `/api/save_all_permissions.php`, `/api/add_role.php`.

### Non-functional
- NFR1: Permission writes are session-authorized like modal (admin roles only as in modal).

## Needs clarification
