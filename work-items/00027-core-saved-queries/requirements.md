# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Users can review saved tariff-query history and outcomes as on BestModal.

## Stakeholder requirements
- [User]: `?page=saved_queries_view` plus listed `/api/` fetches.

## Solution requirements

### Functional
- FR1: Port `views/saved_queries_view.php` at `?page=saved_queries_view`.
- FR2: Port `/api/fetch_saved_queries.php` (and `fetch_saved_queries_stats` if used), `/api/save_query_outcome.php`, `/api/fetch_index_view_stats.php`, and other `/api/` the view calls 1:1.

### Non-functional
- NFR1: Session-gated; no new SPA.

## Needs clarification
