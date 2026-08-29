# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Public legal documents are reachable on Multimodalis with the same slugs and copy as BestModal.

## Stakeholder requirements
- [Visitor]: Can open AGB, privacy, and impressum without logging in and without app chrome.
- [Legal]: Copy is a port of modal views, not a rewrite.

## Solution requirements

### Functional
- FR1: `index.php?page=agb|privacy|impressum` include the corresponding `views/*.php` as public pages.
- FR2: Pages are on the public list (no can_view 403; no layout nav).

### Non-functional
- NFR1: HTML content matches modal views aside from branding strings already decided for v2 (Multimodalis vs BestModal only if already a global rule — do not invent new legal text).

## Needs clarification
- Does this slice also port the login/footer `legal-link` JavaScript overlay, or only the three `?page=` documents?
