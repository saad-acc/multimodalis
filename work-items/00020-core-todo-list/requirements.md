# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Users can manage personal todos as on BestModal.

## Stakeholder requirements
- [User]: `?page=todo_list` CRUD matches modal (view + any JSON it uses).

## Solution requirements

### Functional
- FR1: Port `views/todo_list.php` at `?page=todo_list`.
- FR2: Port any `/api/` todo endpoints the view calls, same filenames.

### Non-functional
- NFR1: Todos are scoped as in modal (per user via `$pdo`).

## Needs clarification
