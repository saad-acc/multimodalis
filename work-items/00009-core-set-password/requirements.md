# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Invited users can complete the password-set flow on Multimodalis using the same URLs as BestModal.

## Stakeholder requirements
- [Invitee]: Valid token URL shows set-password UI; invalid token matches modal UX.
- [Ops]: Same public JSON filenames; no OAuth in this slice.
- [Implementer]: Kernel routing and can_view exist first (00002, 00004).

## Solution requirements

### Functional
- FR1: `index.php?page=set_password` loads the port of `views/set_password.php` without app chrome (public).
- FR2: GET/POST to `/api/check_token.php` and `/api/save_password.php` match modal contracts (query/body, JSON).
- FR3: Invalid/expired token behaviour matches `views/set_password.php`.

### Non-functional
- NFR1: Passwords stored with the same hashing approach as modal (`password_hash`).
- NFR2: Token check does not leak whether an email exists beyond what modal already returns.

## Needs clarification
