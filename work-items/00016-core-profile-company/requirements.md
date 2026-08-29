# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Company users can view/save company profile and branches as on BestModal.

## Stakeholder requirements
- [Company admin]: `?page=profile_company` plus get_branches/save_profile_company.

## Solution requirements

### Functional
- FR1: Port `views/profile_company.php` at `?page=profile_company` with chrome and can_view.
- FR2: Port `/api/get_branches.php` and `/api/save_profile_company.php`.

### Non-functional
- NFR1: Session-gated; tenant data via `$pdo` (00006).

## Needs clarification
