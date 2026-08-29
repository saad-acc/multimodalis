# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Users can edit existing PUDO charges as on BestModal.

## Stakeholder requirements
- [Tariff admin]: `?page=edit_pudo_charge` + save APIs.

## Solution requirements

### Functional
- FR1: Port `views/edit_pudo_charge.php`.
- FR2: Port update `/api/` used by the view, same filenames.

### Non-functional
- NFR1: Session-gated.

## Needs clarification
