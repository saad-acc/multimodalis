# Discovery

## Existing systems / prior art

- **Legacy:** `/api/capacity_request_respond.php` (token in mail, public), `/api/capacity_request_auto_close.php` (auth_check whitelist). No page slug. depends_on: 00071.

## Open questions

- Who invokes auto-close on GCP (Cloud Scheduler hitting the PHP URL vs former crontab), and is the query secret identical to modal?
