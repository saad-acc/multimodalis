# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
People can complete the BestModal register/invite-accept flow on Multimodalis at `?page=register`.

## Stakeholder requirements
- [Invitee]: Valid NAC invitation token registers/activates like modal.
- [Admin]: Do not invent a different signup policy than humans confirm.

## Solution requirements

### Functional
- FR1: `index.php?page=register` ports `views/register.php` (public, form POST to same page).
- FR2: Invite token path uses the same tables/queries as modal (`nac_round_recipients` + `users`).
- FR3: Validation (password length, duplicate email) matches modal.

### Non-functional
- NFR1: Passwords hashed as in modal. No new REST resource.

## Needs clarification
- Should v2 keep open self-signup (no token) as modal `register.php` does, or invite-token only?
