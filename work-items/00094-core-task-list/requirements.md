# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Users can list/delete tariff tasks as on BestModal.

## Stakeholder requirements
- [User]: `?page=task_list` + get/delete APIs.

## Solution requirements

### Functional
- FR1: Port `views/task_list.php`.
- FR2: Port `/api/get_task_list.php` and `/api/delete_task.php`.

### Non-functional
- NFR1: Create/edit are later items. Badge uses status 20 as modal.

## Needs clarification
