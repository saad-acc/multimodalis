# Discovery

## Existing systems / prior art

- **Legacy:** `POST /modal/externapi/?api=intermodaltariffs` (also `externapi/index.php?api=intermodaltariffs`). Bearer via `includes/api_token_auth.php`. Handler `externapi/handlers/intermodaltariffs.php` + formatter. Same calc family as 00024. Only one handler registered.

## Open questions

- Confirm Cloud Run public URL prefix (`/externapi/` vs `/modal/externapi/`) for partners.
