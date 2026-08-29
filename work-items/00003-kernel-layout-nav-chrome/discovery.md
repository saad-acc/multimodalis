# Discovery

## Existing systems / prior art

- **v2:** Authenticated chrome is **inlined** in `public/pages/tariff_query.php` (sidebar, top bar, footer). Nav links mostly point at `page=tariff_query` (00001 chrome stub). Branding is Multimodalis, not BestModal logo files from modal.
- **Legacy layout:** After whitelist, `index.php` emits full HTML shell; sidebar from `includes/navigation_neu.php` which requires `includes/navigation_config.php`. Extra nav: `config/nav_ltl.php`, `nav_localport2port.php`, `nav_sales.php`, `nav_task_system.php`. Language helpers `lang()`, `navLabel()`, `navSlug()` live in `index.php` (00137). `$page_module` used for module-aware highlight / body class (request).
- **Public pages skip layout:** `$public_pages` = `login`, `set_password`, `verify_2fa`, `register`, `agb`, `privacy`, `impressum` — include view and `exit` before chrome. Request match-legacy verification lists the same set.
- **Permissions in nav:** `navigation_neu.php` hides links unless `$perms[$slug]['can_view']`. Request: this item may be **visual nav only** if 00004 owns the 403 gate; 403/empty as permissions dictate. Parallel with 00004.
- **00002** must exist so `$page_module` and `$current` slug are defined. Feature pages themselves out of scope — show links.

## Constraints found

- Keep `?page=` URLs. Pattern: session + `require_auth` before shell HTML for authenticated pages.
- Full i18n file parity is **not** this item (request cites 00005; program also has `00137-kernel-i18n-lang`). This item: language **helper hooks** only.
- Do not implement every feature page.

## Open questions

- Nav visibility when 00004 is not yet live (stub all links visible vs hide without `can_view`).
- Whether v2 chrome must use BestModal assets/labels from modal or keep Multimodalis branding from 00001.
- `format=json` on index skips layout in legacy — in or out of this slice.
