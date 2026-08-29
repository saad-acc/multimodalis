# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
v2 must use the same language GET/session and `/api/lang_*.php` contract as modal so chrome and later pages share locale without a new i18n system.

## Stakeholder requirements
- [Users]: Switching language on a stub page matches modal cookie/session behaviour for the chosen mechanism.
- [Chrome / 00003]: `lang()` / `$lang` available after kernel load.
- [Clients]: Public URLs remain `/api/lang_*.php` (not a new REST locale resource).

## Solution requirements

### Functional
- FR1: Honor legacy GET `lang` (as used on `index.php`) and persist like modal (`$_SESSION['lang']`).
- FR2: Load the matching `api/lang_{code}.php` with fallback to German (`lang_de.php`) when the file is missing.
- FR3: Public URLs for those files stay `/api/lang_*.php`. Include/port the five `lang_*.php` data files from modal (full string parity of every feature key is not required to *display* every feature, but files should be the same contract; translating unused keys in UI is out of scope).
- FR4: Do not register a language `?page=` unless modal has one (it does not).
- FR5: Do not invent a new locale system (no gettext-only replacement, no new REST).

### Non-functional
- NFR1: Same GET param names and `/api/lang_*.php` paths as `/Users/saadkhan/Documents/MyRepos/modal/`.
- NFR2: Language switch on an authenticated stub must not require a new SPA route.

## Needs clarification
- `index.php` allows `de,en,es,fr,it` with no redirect; `api/language_switch.php` allows only `de,en` and redirects. Which contract must v2 implement, and is `language_switch.php` in this item?
- Is work item `00005-kernel-i18n-lang` the same slice as 00137 (duplicate) or a later “full string parity” item?
