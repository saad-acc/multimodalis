# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
The `plattform_index` hole is handled by an explicit human choice, not a new marketplace product.

## Stakeholder requirements
- [Product]: Choose wrapper vs 404 vs static HTML.

## Solution requirements

### Functional
- FR1: Implement only the chosen behaviour for `?page=plattform_index`.
- FR2: Do not invent marketplace features.

### Non-functional
- NFR1: Match chosen behaviour vs current modal.

## Needs clarification
- For `?page=plattform_index`, choose: keep 404/missing PHP, add a thin wrapper over `views/Plattform/*.html`, or leave static files only outside `?page=`?
