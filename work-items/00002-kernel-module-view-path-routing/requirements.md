# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
v2 must dispatch `index.php?page=` with the same whitelist metadata as legacy so later feature slices can register one slug without changing URLs.

## Stakeholder requirements
- [Operators / piecemeal migration]: One Cloud Run deployable; existing bookmarks and `?page=` slugs keep working.
- [Implementers of later Core/LTL/P2P/Sales items]: A registered slug loads the mapped file from the declared `view_path`; `$page_module` is available for chrome.
- [End users]: Default landing after auth remains Tarifabfrage (`tariff_query`); unknown pages do not silently reuse the tariff chrome as v2 does today.

## Solution requirements

### Functional
- FR1: Front controller reads `page` like legacy (`basename` of `$_GET['page']`, default `tariff_query` when absent after auth rules consistent with 00001 public login).
- FR2: A page registry equivalent to `$allowed_pages` supports `file`, `title`, optional `module` (default `bestmodal`), optional `view_path` (default `views`).
- FR3: A **registered stub** (including `tariff_query`) includes the mapped PHP file from the declared view_path relative to the app layout used in v2 (today `public/pages/` vs legacy `views/` — Architecture maps paths; behaviour is include-from-metadata).
- FR4: Unregistered `page` uses core 404 belonging to module `bestmodal` (legacy: `views/404.php`), not tariff_query chrome.
- FR5: `$page_module` is set from metadata (or `bestmodal` on 404) before any layout include.
- FR6: Do not implement feature page logic in this item; stubs/empty views are allowed.
- FR7: Do not move LTL/P2P/Sales view trees in this item; metadata keys for those modules may exist only if product copies the full map (see Needs clarification).

### Non-functional
- NFR1: Same query string as legacy (`index.php?page=<slug>`); no new SPA routes.
- NFR2: Unauthenticated access to non-public pages remains login redirect (00001 `require_auth` / session), not a 404.
- NFR3: Dispatch of a registered stub must not require a second HTTP round-trip beyond the existing front-controller include.

## Needs clarification
- Legacy `views/404.php` is missing from the modal repo. What HTML/status should v2 use for unregistered pages (copy from live sandbox, add a new 404, or another existing file)?
- Should this item register the **entire** legacy `$allowed_pages` table (including LTL/P2P/Sales `module`/`view_path`) with stub or missing views, or only a **minimal** set (`login`, `tariff_query`, plus 404) until feature items add slugs?
- Legacy checks `can_view` **before** the whitelist, so unknown slugs typically 403, not 404. This item excludes permissions. Until 00004, should unknown slugs 404 (request verification) or still show tariff chrome / login-only behaviour?
