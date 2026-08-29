# Discovery

## Existing systems / prior art

- **v2:** Login exists; no `verify_2fa` page or send/verify JSON.
- **Legacy:** Feature map shell-auth: slug `verify_2fa`; `api/verify_2fa.php`; `api/send_2fa_code.php` (public); `trusted_devices`; `services/Mailer.php`.
- **1:1:** `views/verify_2fa.php`; those two APIs; Mailer used when a code is sent.

## Constraints found

- Public page (no layout). Keep filenames. Out of scope: SMS vendor swap, REST.
- depends_on: 00002, 00004. Needs `$pdo` (00006) and mail credentials as in modal/env.
- Login (00001) already branches toward 2FA when enabled on the user.

## Open questions

- Confirm v2 mail transport for 2FA codes is the same Mailer/env as sandbox (not a new provider in this slice).
