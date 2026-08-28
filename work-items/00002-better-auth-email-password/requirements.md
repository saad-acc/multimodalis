# Requirements

**Status:** draft  
**Approved by:**  
**Approved on:**  

Work item: `00002-better-auth-email-password`  
Based on: `discovery.md`, `request.md`, `knowledge/domain/better-auth.md`.

## Business requirement
Assess replacing the Multimodalis v2 home-grown PHP session login (`AUTH_MODE` stub/db, `password_verify`) with **Better Auth** as the intended **email/password** system of record, so the team can **sign off a direction** before any runtime swap — OAuth to customers remains a later work item.

## Stakeholder requirements
- **Product owner / requester:** A written assessment of how current login could be swapped to Better Auth for email/password only; a **signed-off direction** (not an unreviewed Node drop-in). OAuth is explicitly later.
- **Operators / deployers:** Any future swap must stay compatible with the existing Cloud SQL **env contract** (socket on Cloud Run vs TCP locally; no secrets in git). They need to know whether a second process (Node) appears on Cloud Run and how DB schema changes.
- **Developers:** They need a recorded decision on local auth: keep `AUTH_MODE=stub` without a DB vs requiring Better Auth + a database locally. They must not be left guessing whether PHP `auth.php` can host Better Auth (it cannot).
- **End users (staff logging into Multimodalis):** German login chrome and behavior already shipped in 00001 (Anmelden, success → Tarifabfrage, failure without a session, gate on protected pages) must remain the product experience unless a later UX item changes it. This item does **not** redesign the login card.
- **Owner of a future OAuth work item:** This item must not implement `socialProviders` / customer OAuth, and must not paint the assessment as delivering OAuth.
- **Delivery workflow / knowledge:** After human approval, the chosen direction (assess-only vs implement; user store; session SoR) must be recordable in `knowledge/` so later items do not re-derive Better Auth vs PHP session facts.

## Solution requirements

### Functional
- FR1: This work item produces a **written assessment** (architecture + UX later in the workflow, grounded in these requirements) that states: Better Auth is a **Node/TypeScript** library with **no PHP SDK**; it cannot be implemented only inside `public/includes/auth.php`; a swap implies a Node runtime plus a trust path for the PHP UI (or a larger rewrite). The assessment lists the integration **families** from discovery (sidecar / second service, reverse-proxy `/api/auth/*`, replace PHP with Node, PHP form POST calling Better Auth HTTP) as options. **This item does not select a family** unless the human already names one in clarification (Q2).
- FR2: The primary **outcome of this work item** is that assessment plus **human-signed-off direction**. Shipping Node, Better Auth CLI schema, or a Cloud Run second service is **not** in scope unless clarification Q1 says implement in this item after architecture.
- FR3: Scope of method for this item and for any later swap described here is **email/password only**. OAuth, `socialProviders`, and “OAuth to customers” are **out of scope** (FR-out-1). The assessment must not treat social login as a deliverable.
- FR4: **Preserve (any later swap, and the assessment must name them as must-keep product behaviors):** unauthenticated users see the existing **German** login (`lang=de`, Multimodalis branding, Anmelden). Successful email/password login grants access to **`page=tariff_query`**. Failed login does **not** set an authenticated session and surfaces the existing failure treatment (`„Anmeldung fehlgeschlagen.“` / `error=1` equivalent). Unauthenticated deep links to protected pages still hit a **session gate before** Tarifabfrage chrome. Login remains a **classic form POST** of `email` and `password` unless UX later changes it — Architecture must not require a JS-only `signIn.email` client as the only path **unless** UX and human approve that. Exact HTTP topology is Architecture.
- FR5: **No self-registration** in the current product. The assessment must state that Better Auth `signUp.email` is typically on, and must record the human answer to Q4. Until that answer, requirements treat **sign-up as must stay off** as the default product need to confirm, not as an implemented flag.
- FR6: **User store:** the assessment must describe three options without picking one: (a) Better Auth generated schema as system of record; (b) keep existing Cloud SQL users (`DB_USERS_*`, still unnamed in ops); (c) migrate / custom hasher so Better Auth can verify **legacy PHP** hashes. Combining (a) and (b) without a migration story is invalid unless the human defines one (Q3).
- FR7: **Sessions:** the assessment must state that today’s `require_auth()` uses PHP `$_SESSION['user_email']`, while Better Auth uses its cookies/tables/`getSession`. It must record Q6 (Better Auth as sole SoR vs dual-write PHP session). Architecture implements only after that answer.
- FR8: **Local/offline:** the assessment must contrast `AUTH_MODE=stub` (no DB) with Better Auth’s need for a database, and record Q5. It must not silently drop stub without a signed decision.
- FR9: **00001 tension:** the assessment must note that replacing PHP with Node or adopting a new users schema **conflicts** with 00001’s rejected alternatives (framework for that slice; new users schema as Cloud Run path). Resolution is Architecture **after** Q1–Q3, not this draft.
- FR10: After approval, knowledge is updated so “Better Auth = Node, email/password first, OAuth later” and the signed direction remain findable (domain concept already exists; decisions/components only when the human and Architecture land them).

### Non-functional
- NFR1: Secrets (DB passwords, Better Auth secrets, service credentials) must **not** be committed to git; env / Secret Manager injection is Architecture if/when implemented.
- NFR2: If/when a swap is implemented, session cookies used for auth must be **HttpOnly**; **Secure** on HTTPS; **SameSite** at least as strict as today’s Lax unless a documented exception is approved.
- NFR3: If/when Node or PHP talks to MySQL on Cloud Run, connectivity must follow the **same env-based DB contract** as 00001 (Unix socket vs TCP selected by env; `INSTANCE_CONNECTION_NAME` placeholder; no hardcoded instance id). Proposed ADRs are not yet accepted; do not invent a second secret topology.
- NFR4: No performance SLA is specified for this assessment item.
- NFR5: Login remaining **German** (`lang=de`) is a product floor for any swap that keeps the current chrome.

## Out of scope / future TODO (this slice)
- **FR-out-1 OAuth / socialProviders / OAuth to customers:** future work item.
- **FR-out-2 Implementing the swap:** not this item unless Q1 says otherwise.
- **FR-out-3 Password reset / `page=set_password` product UI:** still not a product flow (link may remain on chrome). Confirm in Q7.
- **FR-out-4 Email verification as a required user journey:** confirm in Q7; not specified as in-scope here.
- **FR-out-5 User CRUD / admin:** still a later item (00001 FR-out-2).
- **FR-out-6 Login UX redesign:** UX agent only if this item proceeds past clarification with a swap that needs new chrome.
- **FR-out-7 Picking sidecar vs proxy vs rewrite vs PHP-POST-to-HTTP:** Architecture after Q2 (or Architecture decides if human defers).

## Needs clarification
1. **Assess vs implement:** Is this item **assessment + signed-off direction only**, or should a chosen shape be **implemented in this same item** after architecture?
2. **Integration family:** If already known, which family: Node sidecar / second Cloud Run service; reverse-proxy `/api/auth/*` to Node; replace PHP app with Node; PHP UI POST with server-side Better Auth HTTP? Or **Architecture decides after approval**?
3. **User store:** Better Auth schema as system of record; keep existing Cloud SQL users; or migrate with custom hasher for PHP hashes?
4. **Self-registration:** Must `signUp.email` stay **off** (current product) or is sign-up allowed?
5. **Local stub:** Keep `AUTH_MODE=stub` for offline UI without a DB, or require a DB (e.g. Compose MySQL) for Better Auth locally?
6. **Session SoR after a swap:** Better Auth session only, or dual-write PHP `$_SESSION` as well?
7. **Public sign-up / email verification / password reset:** Still out of product scope as in 00001, or in scope for a Better Auth swap?
8. **00001 verification:** Item 00001 is still pending human verification. May this assessment proceed independently, or must 00001 be accepted first?
9. **Supersede 00001 rejections:** If the direction is Node rewrite or new Better Auth tables on Cloud Run, is that an explicit supersession of 00001’s “no framework / no new users schema” rejections?
