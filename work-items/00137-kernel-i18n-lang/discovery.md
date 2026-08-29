# Discovery

## Existing systems / prior art

- **v2:** Login and tariff chrome are hard-coded German (`lang=de` on login). No `$_GET['lang']`, no `$_SESSION['lang']`, no `api/lang_*.php`. 00003 expects language **hooks** only; this item is the kernel i18n contract.
- **Legacy 1:1 files:**
  - Front controller (`index.php` §1–3.7): if `$_GET['lang']` in `de|en|es|fr|it`, set `$_SESSION['lang']` (**no redirect**). `$langCode = $_SESSION['lang'] ?? 'de'`. Load `__DIR__/api/lang_{code}.php` (fallback `lang_de.php`). Helpers `lang()`, `navLabel()`, `navSlug()`.
  - `api/lang_de.php`, `lang_en.php`, `lang_es.php`, `lang_fr.php`, `lang_it.php` — PHP arrays `return [...]`.
  - `api/language_switch.php` — **different** allow-list (`de`, `en` only), sets session, **redirects** to Referer (or `../index.php`). Public URL `/api/language_switch.php`.
- **No dedicated `?page=` for language** (usually none). Out of scope: translating every feature string; REST rewrite.
- **Overlap:** `work-items/00005-kernel-i18n-lang/` exists in the program as well; 00003 request cites “00005” for full i18n. This item id is **00137**.
- Depends on 00002 for routing; chrome consume in 00003.

## Constraints found

- Copy legacy GET + API contract; public URLs stay `/api/lang_*.php` (and `language_switch.php` if in scope).
- `lang_*.php` are data files, not typical JSON; they `return` arrays. Serving them as `/api/lang_de.php` still executes PHP.

## Open questions

- `index.php` five locales vs `language_switch.php` two locales.
- Whether `language_switch.php` is in this slice.
- Duplicate work item 00005-kernel-i18n-lang vs 00137.
