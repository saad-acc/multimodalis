# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Permitted users can read the news board as on BestModal.

## Stakeholder requirements
- [User]: `?page=news_board` lists news via `load_news`.

## Solution requirements

### Functional
- FR1: Port `views/news_board.php` at `?page=news_board` with chrome and can_view.
- FR2: Port `/api/load_news.php` with the same JSON shape as modal.

### Non-functional
- NFR1: Session-gated like other Core APIs.

## Needs clarification
