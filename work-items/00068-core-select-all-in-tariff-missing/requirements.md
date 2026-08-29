# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
The registered `select_all_in_tariff` slug must not become an invented selector without approval.

## Stakeholder requirements
- [Product]: Choose 404/hide vs later UI.
- [Users]: Create flow remains 00059.

## Solution requirements

### Functional
- FR1: Implement only the chosen behaviour for `?page=select_all_in_tariff`.
- FR2: Do not build a new picker in this item.

### Non-functional
- NFR1: Comparable to current modal when hitting the slug.

## Needs clarification
- What should `?page=select_all_in_tariff` do: keep modal’s missing-file failure, hide from nav and 404, or schedule a new view (out of this item’s build)?
