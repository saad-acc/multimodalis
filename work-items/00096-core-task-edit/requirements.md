# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Users can edit tariff tasks (items, notes, files, status) as on BestModal.

## Stakeholder requirements
- [User]: `?page=task_edit` + listed `/api/`.

## Solution requirements

### Functional
- FR1: Port `views/task_edit.php`.
- FR2: Port `/api/update_tariff_task.php`, `link_tariff_to_task`, `delete_tariff_task_item`, `add_task_note`, `get_task_notes`, `upload_task_file`, `change_task_status` at modal filenames.

### Non-functional
- NFR1: Detail page is 00097.

## Needs clarification
