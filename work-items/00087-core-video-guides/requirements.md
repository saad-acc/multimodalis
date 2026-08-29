# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Users can watch granted training videos as on BestModal.

## Stakeholder requirements
- [User]: `?page=video_guides` + grants/guides JSON + watch URL.

## Solution requirements

### Functional
- FR1: Port `views/video_guides.php`.
- FR2: Port `/api/video_guides_api.php` and `/api/video_guide_grants_api.php` (modal filenames).
- FR3: Port `/videos/watch.php` as in modal.

### Non-functional
- NFR1: Do not invent `video_guide_grants.php` if modal uses `_api`.

## Needs clarification
- Confirm Cloud Run must serve `/videos/watch.php` at that path (copy under `public/videos/`) like modal.
