# Discovery

## Existing systems / prior art

- **Legacy:** `manage_allin_surcharge_periods` → `views/manage_allin_surcharge_periods.php` → create/preview/progress/delete period APIs + snapshot worker URL as modal. depends_on: 00060. Out of scope: new cron platform.

## Open questions

- Same Cloud Run worker hosting question as 00055 if period snapshot is a long PHP worker.
