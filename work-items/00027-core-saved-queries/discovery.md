# Discovery

## Existing systems / prior art

- **Legacy:** `saved_queries_view` → `views/saved_queries_view.php` → `fetch_saved_queries*`, `save_query_outcome`, `fetch_index_view_stats`, plus stats APIs in feature map (`fetch_saved_queries_stats`, `fetch_outcome_stats`, `fetch_customers_select`).
- **v2:** None.

## Constraints found

- Port view + APIs the view uses (include stats if called). depends_on: kernel + typically after query save.

## Open questions

(none)
