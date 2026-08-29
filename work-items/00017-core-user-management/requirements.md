# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Admins can list, create/update, disable, invite, and export users as on BestModal.

## Stakeholder requirements
- [Admin]: Full modal user_management actions at the listed JSON URLs.
- [Invitee]: Invite email content matches `templates/email_user_invite.php` when mail is enabled.

## Solution requirements

### Functional
- FR1: Port `views/user_management.php` at `?page=user_management` with chrome and can_view.
- FR2: Port the six listed `/api/*.php` endpoints with modal JSON/Excel behaviour.

### Non-functional
- NFR1: Excel export matches modal content-type and columns.
- NFR2: Destructive delete matches modal confirmation/authorization.

## Needs clarification
- Must `resend_invite` send real mail in this slice, or is a logged/stub send acceptable until SMTP is confirmed?
