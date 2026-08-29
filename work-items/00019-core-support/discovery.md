# Discovery

## Existing systems / prior art

- **v2:** No support page.
- **Legacy:** `support` → `views/support.php`; may call `api/send_mail.php`.

## Constraints found

- Keep slug. depends_on: 00003, 00004. Mailer if the view sends mail.

## Open questions

- If the view posts `send_mail.php`, is live SMTP required in this slice?
