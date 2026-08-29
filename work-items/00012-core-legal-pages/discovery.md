# Discovery

## Existing systems / prior art

- **v2:** No AGB/privacy/impressum pages.
- **Legacy:** `index.php` `$public_pages` includes `agb`, `privacy`, `impressum`. Views: `views/agb.php`, `views/privacy.php`, `views/impressum.php`. Footer uses `.legal-link` `data-page` (JS) plus `?page=` public slugs.
- **Feature map:** Not listed in shell-auth; still first-class public pages.

## Constraints found

- Serve without app nav chrome. Do not rewrite legal copy. depends_on: 00002; independent of 00004 if public.
- Out of scope: cookie-banner product.

## Open questions

- Must v2 implement the footer JS overlay (`legal-link`) in this slice, or only `?page=agb|privacy|impressum` full pages? (Modal has both.)
