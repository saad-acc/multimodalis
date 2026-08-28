# UX Spec

Work item: `00001-v2-php-cloudrun-login`  
Source of truth: approved `requirements.md`, sandbox capture 2026-08-28 (`clarifications.md` / `discovery.md`).  
Language: German UI (`lang=de`) for this slice.  
Knowledge: no existing `knowledge/patterns/` (tag `ux`) entries to reuse.

---

## Flow: Unauthenticated login (FR1, FR2, NFR5, NFR7)

1. **Entry:** User opens the app unauthenticated (or is sent to the login page). Document title **Login BestModal**; `lang=de`; favicon `images/favicon.svg`.
2. **Screen:** Centered white login card on navy gradient background (`#1a1a2e` → `#16213e`). Card shows:
   - Logo `images/bestmodal-logo.svg` with BestModal / TARIFF ADMINISTRATION branding.
   - **Host label** equal to the **actual host** serving the page (e.g. `localhost`, Cloud Run hostname, or sandbox host) — never a hardcoded `sandbox.BestModal.de` on other environments.
   - Email field (`type=email`, placeholder **E-Mail-Adresse**).
   - Password field (placeholder **Passwort**).
   - Primary submit **Anmelden** (accent `#10B981` / `#059669`).
   - Link **Passwort vergessen?** visible for visual match with sandbox.
   - Footer **© 2026 Acceltra GmbH**.
3. **Submit:** User fills email + password and activates **Anmelden**. Form POSTs fields `email` and `password` to the login-check endpoint (sandbox analogue: `POST …/check_login.php`).
4. **Success outcome:** Authenticated session is established (mechanism is Architecture). User lands on Tarifabfrage — see Flow: Post-login Tarifabfrage landing.
5. **Failure / empty / edge states:**
   - **Wrong credentials / auth reject:** No session; user does **not** reach Tarifabfrage. Remain on (or return to) the login screen with a **minimal** inline error. Exact German copy is **not** fixed in requirements — use capture wording if later observed; otherwise a short, non-specific deny message (Architecture may supply final string). Do not invent lockout, rate-limit, or password-policy messaging in this slice.
   - **Empty required fields:** Browser/native or lightweight client validation may block submit for empty email/password and invalid email shape (`type=email`); do not invent extra policy beyond that.
   - **Passwort vergessen?:** Link may be present. **Set-password flow is out of scope** — clicking must not deliver a working forgot-password product experience in this slice (see Risks).
   - **Already authenticated:** If the user hits login while already signed in, prefer sending them to Tarifabfrage rather than showing a second login (behavior detail is Architecture; UX expectation is one authenticated landing).

**Interaction notes:**
- Primary action is **Anmelden**; while the login check is in flight, disable double-submit (button disabled and/or busy indication) until success redirect or failure feedback returns.
- On failure, keep the email value; clear or leave password per common practice (prefer clearing password); announce the error near the form so it is obvious without a toast-only pattern.
- No remember-me, no multilingual toggle on the login card beyond the captured DE chrome.
- Visual stack: Bootstrap 5.3.0 + bootstrap-icons 1.10.5; font Segoe UI, system-ui, -apple-system, sans-serif — match capture, not a new design system.

**Accessibility (WCAG 2.1 AA):**
- Email and password have visible labels or accessible names equivalent to their placeholders (prefer explicit `<label>` association, not placeholder-only).
- Submit is a real button with accessible name **Anmelden**.
- Host label is text (not color-only information).
- Error text is programmatically associated with the form (e.g. `role="alert"` / `aria-live` polite) and meets contrast ≥ 4.5:1 against the card background.
- Focus order: logo/branding → email → password → Anmelden → Passwort vergessen? → footer; visible focus rings on all interactive controls.
- Password field is `type=password`; do not rely on color alone for error state (icon or text + border).
- Accent greens on navy/white must keep AA contrast for text and focus indicators; if green-on-navy fails for small text, use dark text on green filled buttons as in typical Bootstrap primary buttons.

**Reuses existing pattern:** none in-repo. **Matches captured sandbox login** — not a new inventable pattern.

---

## Flow: Login failure without session (FR4)

1. **Entry:** User submits invalid credentials (or auth otherwise fails).
2. **Outcome:** No authenticated access to Tarifabfrage or other app shell. Login card remains (or is shown again) with minimal error feedback.
3. **Empty/session edge:** Direct navigation to `index.php?page=tariff_query` (or any authenticated shell URL) without a valid session returns the user to login — no Tarifabfrage chrome flash of protected content.

**Interaction notes:** Failure is calm and minimal; no multi-step recovery UI in this slice. Do not invent account-lockout or “contact admin” flows unless capture later shows them.

**Accessibility:** Error is readable by screen readers when it appears; focus moves to or stays logically near the error/form so keyboard users are not stranded. Contrast AA for error text and controls.

**Reuses existing pattern:** none.

---

## Flow: Post-login Tarifabfrage landing — chrome + layout only (FR3, NFR5)

1. **Entry:** Successful Anmelden → user arrives at `index.php?page=tariff_query` (document title **Tarifabfrage**). This is the **only** authenticated product landing for this slice — **do not invent a dashboard**.
2. **Shell (match capture):**
   - **Left sidebar:** BestModal logo (target may point at `dashboard` for visual parity); pin control; nav items Dashboard and News-Board; section **Tarife verwalten** expanded with **Tarifabfrage** marked as the current item. Full v1 nav tree **may** appear as chrome; submenu destinations are **not** working features in this slice.
   - **Top bar:** Sidebar toggle; page title **Tarifabfrage**; language control showing **DE**; **Profil** menu (chrome only — no user-management destination required).
   - **Main (layout parity, stubbed behavior):**
     - “Letzte Suchen” chips area (empty or placeholder chips OK if capture shows empty).
     - Form **Allgemeine Auswahl:** Leistungsdatum, Transport Mode, Hafen Auswahl chips (Rotterdam / Antwerpen / Hamburg / Bremerhaven / Wilhelmshaven), Gestellung and Abholung (required markers as captured), Bruttogewicht, submit **Tarife suchen**.
     - **Dispo-Filter:** Reederei, Depots, Terminals, Verkaufszuschlag Kundengruppe A–E, Vendor.
     - **Filter** controls: BestPrice / Alle Preise / Kapazitätsanfrage / Index.
     - Results table area (empty stub).
     - Side panels: Preisdetails, Angebotsvorschau, Einkaufspreise (present as layout; no live data required).
   - **Footer:** © 2026 Acceltra GmbH and placeholder legal links as captured.
3. **Stub / empty states (this slice):**
   - **Results:** Empty table / empty results region — no fabricated tariff rows, no fake “sample” data presented as live results.
   - **Letzte Suchen:** Empty or non-functional chips; activating them does not run a real search.
   - **Tarife suchen / filters / Dispo-Filter / Filter toggles:** May accept local UI interaction (focus, open, select) for layout fidelity, but **must not** imply a completed live tariff query against the DB. Prefer no-op, disabled submit, or a calm empty-results outcome — not a fake success dataset.
   - **Nav / Profil / language DE / pin / sidebar toggle:** Chrome may expand/collapse sidebar for layout; other destinations need not navigate to real feature pages. Do not build Dashboard, News-Board, or other Tarife-verwalten tools as product features here.
4. **Outcome:** User can visually confirm they are authenticated on Tarifabfrage matching the sandbox capture’s structure. Live tariff search is a **later** work item (FR-out-8).

**Interaction notes:**
- First paint after login should feel like the captured shell, not a temporary “home” or widget dashboard.
- Loading: if the landing needs a brief load after redirect, a single page load is enough; no skeleton invented beyond what Bootstrap layout naturally provides.
- Stubbed controls should not show error toasts that suggest backend failure for every click; silent no-op or staying on empty results is preferable for this slice.
- Language control shows **DE** only for visual match; switching languages is out of scope.

**Accessibility (WCAG 2.1 AA):**
- Landmark structure: banner (top bar), navigation (sidebar), main (Tarifabfrage content), contentinfo (footer).
- Current nav item **Tarifabfrage** indicated with more than color (e.g. `aria-current="page"` or equivalent).
- Sidebar toggle and pin are keyboard-operable with accessible names (German or bilingual names consistent with visible UI).
- Form fields in Allgemeine Auswahl / Dispo-Filter have associated labels; required Gestellung/Abholung are conveyed to AT (not color-only asterisks).
- Hafen Auswahl chips and Filter controls are keyboard reachable (roving tabindex or native buttons/checkboxes) with clear selected state.
- Results empty state is announced as empty (e.g. accessible table caption or status text), not a blank region with no name.
- Profil and DE controls are focusable; if menus are present but non-functional, they still must not trap focus.
- Text/icon contrast ≥ 4.5:1 (3:1 for large text/UI components) against sidebar and main backgrounds.

**Reuses existing pattern:** none. **Matches captured Tarifabfrage shell** — stubbed interactivity by explicit product decision, not a new reusable pattern library entry for this slice.

---

## Flow: Out-of-scope surfaces (documented non-flows)

These appear in chrome or adjacent links but are **not** UX deliverables for this work item:

| Surface | UX expectation this slice |
| --- | --- |
| Passwort vergessen / `set_password` | Link may show on login; **no** working set-password journey |
| User management / CRUD | Not present |
| Dashboard, News-Board, other Tarife-verwalten destinations | Chrome only; not working features |
| Live Tarifabfrage search / DB-backed results | Stubbed / empty |
| Extra auth parity (lockout, CSRF UX, remember-me, i18n beyond DE) | Skip |

---

## Risks for Solution Architect

1. **Login failure copy & transport:** Requirements leave exact failure wording/status unspecified. UX needs *some* visible, accessible error on the login card; Architecture should pick capture-aligned copy if observed, else a minimal German deny string — UX does not invent a multi-message taxonomy.
2. **Passwort vergessen? click target:** Keeping the link for visual match without implementing `set_password` may 404, dead-end, or need a inert/disabled treatment — decide without expanding scope into a real recovery flow.
3. **Stubbed Tarifabfrage controls vs. disabled controls:** Full interactive-looking forms that no-op may confuse users/testers; SA/implementer should choose stub strategy (disabled primary search vs. empty results on submit) while preserving layout parity.
4. **Non-functional nav targets:** Logo → `dashboard` and other sidebar links exist in capture; decide redirect-to-self, placeholder, or login-gated 404 behavior so UX chrome does not accidentally invent feature pages.
5. **No in-repo design system yet:** First PHP UI; asset delivery (jsDelivr vs bundled) and exact Bootstrap markup are Architecture — UX only requires visual/behavioral parity with the capture and WCAG 2.1 AA.
6. **Unauthenticated deep link:** Behavior when opening `page=tariff_query` without session must deny chrome of protected content (redirect to login) — session/cookie details are Architecture.
