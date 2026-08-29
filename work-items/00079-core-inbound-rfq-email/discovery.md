# Discovery

## Existing systems / prior art

- **Legacy:** POST `api/inbound_rfq_email.php?secret=` (auth whitelist) → `RfqEmailService` → `TariffQueryRunner` → mail. depends_on: 00024. Docs `api/RFQ_SYSTEM_README.md`.

## Open questions

- Which mail provider webhook and secret will Cloud Run use vs sandbox modal?
