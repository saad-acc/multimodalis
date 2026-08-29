# Discovery

## Existing systems / prior art

- **v2:** No role UI.
- **Legacy:** `role_management` → `views/role_management.php` → `get_role_permissions`, `save_all_permissions`, `add_role`; tables `pages` / `role_page_permissions`. Menu visibility is permission-driven.

## Constraints found

- Keep slug and APIs. Out of scope: redesigning RBAC. depends_on: 00003, 00004. Nav (00003) hides items using the same flags.

## Open questions

(none)
