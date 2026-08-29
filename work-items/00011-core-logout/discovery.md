# Discovery

## Existing systems / prior art

- **v2:** Session login; no dedicated logout slug handling documented as complete.
- **Legacy:** Feature map shell-auth: slug `logout` handled in `index.php` (session destroy, cookie clear, redirect login). `views/logout.php` exists but controller often exits before render.
- **1:1:** `index.php` logout branch; optional `views/logout.php`.

## Constraints found

- Keep `?page=logout`. Cookie names/flags must match modal unless already aligned in 00001.
- depends_on: 00002; after login (00001). Out of scope: SSO logout.

## Open questions

(none)
