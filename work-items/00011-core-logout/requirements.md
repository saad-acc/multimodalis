# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Authenticated users can end the session and return to login the same way as BestModal.

## Stakeholder requirements
- [User]: Hitting logout clears session and lands on login.
- [Security]: Cookie clear matches modal (HttpOnly/SameSite as already used).

## Solution requirements

### Functional
- FR1: `index.php?page=logout` destroys the session and redirects to login like modal.
- FR2: Do not require a new SPA route; unknown slugs still 404.

### Non-functional
- NFR1: After logout, protected pages redirect to login (unauthenticated), not 403.

## Needs clarification
