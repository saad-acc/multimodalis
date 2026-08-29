# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Authenticated v2 pages must share one header/nav/footer so feature views are content-only and chrome matches legacy grouping and module-aware highlight, without implementing those features here.

## Stakeholder requirements
- [Logged-in users]: Same nav groups as `../modal/` for a given permissions snapshot (links may 403/empty until pages exist).
- [Unauthenticated / public]: `login`, `set_password`, `verify_2fa`, `register`, `agb`, `privacy`, `impressum` skip app layout.
- [Feature implementers]: Views do not duplicate chrome; `$page_module` can drive body class / highlight.

## Solution requirements

### Functional
- FR1: Extract shared header, nav, footer from the front controller / tariff_query inline chrome so registered authenticated views are content-only.
- FR2: Nav data equivalent to `navigation_config.php` plus `config/nav_ltl.php`, `nav_localport2port.php`, `nav_sales.php`, `nav_task_system.php` (structure and labels; not every target page implemented).
- FR3: Module-aware current-item highlight and body class from `$page_module` (00002).
- FR4: Language helper **hooks** (`lang` / `navLabel`-style call sites) without requiring full `api/lang_*.php` parity in this item.
- FR5: Public page list matches legacy `$public_pages` — no app chrome.
- FR6: 403 HTML gate is owned by 00004; this item must not invent a second authorization model. Nav may hide items using the same `can_view` snapshot when present.

### Non-functional
- NFR1: `?page=` URLs unchanged.
- NFR2: Layout include must not emit Tarifabfrage chrome for public pages (no flash of authenticated shell).
- NFR3: Chrome must remain usable without every linked feature existing (dead links / 403 / empty as product decides — see Needs clarification).

## Needs clarification
- If 00004 is not deployed yet, should nav show all groups (visual-only) or hide everything without `$_SESSION['permissions']`?
- Must chrome match BestModal logo/copy from `../modal/` or keep Multimodalis branding from 00001 while matching **structure** of nav groups?
- Is `index.php?format=json` (legacy: view without HTML layout) in scope for this layout extract?
