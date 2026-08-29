# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
The registered `profile` slug must not silently become a new product; behaviour must be an explicit human choice.

## Stakeholder requirements
- [Product]: Decide 404 vs hide-nav vs future view.
- [Users]: `profile_company` remains the company UI (00016).

## Solution requirements

### Functional
- FR1: Document and implement only the chosen behaviour for `?page=profile` (no invented personal-profile feature).
- FR2: Do not change `?page=` string `profile` if the slug stays registered.

### Non-functional
- NFR1: Whatever is chosen must be comparable to current modal when hitting `?page=profile`.

## Needs clarification
- What should `?page=profile` do: keep modal’s missing-file failure, hide from nav and 404, redirect to `profile_company`, or schedule a new view (out of this item’s build)?
