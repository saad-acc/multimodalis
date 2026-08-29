# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Users can open the support/help page and submit contact the same way as BestModal.

## Stakeholder requirements
- [User]: `?page=support` matches modal content and any mail post.

## Solution requirements

### Functional
- FR1: Port `views/support.php` at `?page=support` with chrome and can_view.
- FR2: Port any `/api/send_mail.php` (or other APIs) the view actually calls, at modal paths.

### Non-functional
- NFR1: Do not add a ticket system modal does not have.

## Needs clarification
- Must support-form mail send in this slice, or is UI-only acceptable until SMTP is confirmed?
