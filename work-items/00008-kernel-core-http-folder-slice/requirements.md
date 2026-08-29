# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Core JSON must keep legacy `/api/<file>.php` URLs while the codebase can group toward `Modules/Core/Http/{Feature}` so the team does not dump `api/` into a new REST design on day one.

## Stakeholder requirements
- [Clients / cron / UI]: Same public JSON paths and contracts (sample: `/api/load_tariffs.php` still 200 with the same contract as modal for that file).
- [Maintainers]: A documented folder-slice pattern for Core HTTP only; LTL/P2P/Sales APIs not moved here.
- [Migration program]: No new REST resources; no `?page=` changes.

## Solution requirements

### Functional
- FR1: Public URL `/api/<legacy_file>.php` remains the client-facing path for Core JSON covered by this slice.
- FR2: Code **may** live under `Modules/Core/Http/{Feature}` **if** product chooses a layout that still satisfies FR1 (mechanism not assumed — see Needs clarification).
- FR3: No change to feature behaviour or query strings for files in scope.
- FR4: Do not move LTL/P2P/Sales API trees in this item. Do not redesign REST.

### Non-functional
- NFR1: A sample legacy URL (e.g. `/api/load_tariffs.php`) must keep the same HTTP contract as modal for that endpoint (status + payload shape for a comparable request).
- NFR2: Unknown `?page=` still 404 like modal once 00002 exists; this item does not add SPA routes.

## Needs clarification
- **Physical folder move vs rewrite-rule / include map:** Should files be relocated on disk into `Modules/Core/Http/{Feature}` with Apache/PHP aliases, or stay as `public/api/*.php` with an include/map only, or a hybrid? Do not assume either.
- Which Core files are in **this** slice — one exemplary feature (`load_tariffs.php` only), a named subset, or all 255 `modal/api/*.php` files (including `lang_*` and `test_*`)?
