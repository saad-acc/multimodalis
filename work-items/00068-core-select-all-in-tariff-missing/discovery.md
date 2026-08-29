# Discovery

## Existing systems / prior art

- **Legacy:** `$allowed_pages` slug `select_all_in_tariff` → `views/select_all_in_tariff.php` **missing** (feature map kv-all-in). Hitting the slug is a broken include.

## Constraints found

- Do not invent a picker. depends_on: 00002. Human decision.

## Open questions

- What should `?page=select_all_in_tariff` do on v2: match modal failure, hide nav, or add a view later?
