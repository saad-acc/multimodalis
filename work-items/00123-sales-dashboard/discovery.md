# Discovery

## Existing systems / prior art

- **Legacy:** module `sales`, `views_sales/sales_dashboard.php`, `$pdo_sales` via `includes/connectdb_sales.php` (host `~/connectdb_sales.cfg.php`). No fetch API in the view. Request JSON folder: `apisales/` (modal also has `api_sales/`).

## Open questions

- Confirm v2 maps `apisales/` public URLs the same as modal (alias vs `api_sales/` folder name).
- Confirm Cloud SQL has the sales schema / `$pdo_sales` env (00006).
