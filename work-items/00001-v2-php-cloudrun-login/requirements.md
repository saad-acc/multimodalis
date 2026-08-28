# Requirements

**Status:** approved  
**Approved by:** human  
**Approved on:** 2026-08-28  

Work item: `00001-v2-php-cloudrun-login`  
Based on: `discovery.md`, `request.md`, `clarifications.md` (human answers 2026-08-28), captured sandbox login + Tarifabfrage.

## Business requirement
Stand up a **second version** of the BestModal PHP application **in this repository**, starting with the **login flow and a basic Tarifabfrage landing page** as captured on the live sandbox, running on **php:8.3-apache**, connecting to **Cloud SQL MySQL in GCP project `bestmodal-492819`**, so the team can **prove the app locally and on Cloud Run service `multimodalis`**, with **GitHub Actions deploying to Cloud Run in `europe-west1` when git tag `v0.0.1` is pushed**.

## Stakeholder requirements
- **Product owner / requester:** A v2 of the existing PHP BestModal app lives in this repo; unauthenticated login matches the captured sandbox screen; after Anmelden the user lands on **Tarifabfrage** (`page=tariff_query`) as **basic chrome + layout** (search/filter/results stubbed); they can test locally, then on Cloud Run after a `v0.0.1` tag deploy.
- **Operators / deployers:** Cloud Run service **`multimodalis`** in project **`bestmodal-492819`**, region **`europe-west1`**, using Cloud SQL MySQL in that project, is deployable via GitHub Actions on tag `v0.0.1`. Cloud SQL **instance name is deferred / do later** — not blocking this approval.
- **Developers:** The app is runnable and testable on a developer machine (preference: app on localhost talking to remote sandbox DB — Architecture; not a locked design).
- **End users of v2 (once deployed):** German-language login consistent with capture; after successful authentication, basic Tarifabfrage chrome as captured — not an invented dashboard and not a live tariff-search app in this slice.
- **Acceltra GmbH (brand on captured footers):** Login and Tarifabfrage footers retain © 2026 Acceltra GmbH unless stakeholders later change them.

## Solution requirements

### Functional
- FR1: The repository contains a PHP application that implements the **unauthenticated login screen** matching the captured sandbox facts: `lang=de`; title Login BestModal; logo `images/bestmodal-logo.svg` with BestModal / TARIFF ADMINISTRATION; **domain label is the real host of that environment** (localhost, Cloud Run hostname, or sandbox host — not hardcoded `sandbox.BestModal.de` on other environments); navy gradient background `#1a1a2e` → `#16213e`; accent `#10B981` / `#059669`; Bootstrap 5.3.0 and bootstrap-icons 1.10.5 (jsDelivr or equivalent bundled assets as Architecture decides); font stack Segoe UI, system-ui, -apple-system, sans-serif; email field (`type=email`, placeholder E-Mail-Adresse), password field (placeholder Passwort); submit **Anmelden**; footer © 2026 Acceltra GmbH; favicon `images/favicon.svg`. The **Passwort vergessen?** link may remain on chrome for visual match; **the set-password flow is out of scope** (FR-out-1).
- FR2: Submitting the login form POSTs fields `email` and `password` to a login-check endpoint analogous to sandbox `POST /modal/api/check_login.php`. **Success path observed:** user lands on **`index.php?page=tariff_query`**. Remaining request/response/cookie details are taken from that capture, not specified up front (human skipped a contract spec).
- FR3: After successful login, the user is shown **Tarifabfrage** at `index.php?page=tariff_query` (document title Tarifabfrage). This slice is **keep it basic: chrome + layout only**. Search, filters, and results are **stubbed**; live tariff-search behavior is a later work item. Match the 2026-08-28 sandbox capture visually:
  - Left sidebar: BestModal logo targeting `dashboard`; pin control; nav items Dashboard and News-Board; section **Tarife verwalten** expanded with **Tarifabfrage** as the current item. The v1 full nav tree may be present as chrome; **this slice does not implement every submenu destination as a working feature.**
  - Top bar: sidebar toggle, page title Tarifabfrage, language **DE**, **Profil** menu.
  - Main: “Letzte Suchen” chips; form **Allgemeine Auswahl** (Leistungsdatum, Transport Mode, Hafen Auswahl chips Rotterdam / Antwerpen / Hamburg / Bremerhaven / Wilhelmshaven, Gestellung and Abholung required, Bruttogewicht, submit **Tarife suchen**); **Dispo-Filter** (Reederei, Depots, Terminals, Verkaufszuschlag Kundengruppe A–E, Vendor); **Filter** controls BestPrice / Alle Preise / Kapazitätsanfrage / Index; results table area; side panels Preisdetails, Angebotsvorschau, Einkaufspreise; footer © 2026 Acceltra GmbH and placeholder legal links. Controls need not run real queries.
  - **Do not add dashboard widgets or features not in this capture.**
- FR4: Unsuccessful login does not grant access to Tarifabfrage. Exact failure copy/status is **not specified up front**; implement from capture if observed, otherwise minimal deny-without-session (Architecture).
- FR5: A developer can start the application **locally** and exercise login and the basic Tarifabfrage landing without relying solely on opening the live sandbox UI as the only v2 under test.
- FR6: The same application can be deployed to **GCP Cloud Run** service **`multimodalis`** in project **`bestmodal-492819`**, region **`europe-west1`**, and login plus the basic Tarifabfrage landing can be exercised there.
- FR7: Pushing git tag **`v0.0.1`** triggers **GitHub Actions** that deploy this application to that Cloud Run service.
- FR8: Login (session/user lookup as needed) uses **Cloud SQL MySQL in project `bestmodal-492819`**. Schema and connector are Architecture. **No user management UI or CRUD** in this slice (FR-out-2). Cloud SQL **instance name is deferred / do later** — not blocking (FR-out-7).

### Non-functional
- NFR1: Runtime is **PHP 8.3** served by **Apache**, based on the **php:8.3-apache** image family.
- NFR2: Hosting target is **GCP Cloud Run** (`multimodalis`, `europe-west1`, project `bestmodal-492819`); database is **Cloud SQL for MySQL** in that project. Connector choice (Auth Proxy, Unix socket, etc.) is **not** specified here. Naming the Cloud SQL instance is **later**, not a gate for UX/Architecture to start.
- NFR3: Local run must be documentable and repeatable. **Preference (not a locked design):** localhost app → remote **sandbox** DB; Cloud Run → remote **prod** DB (human: DBs initially the same). Compose MySQL remains an alternative if sandbox connectivity is painful. Final wiring is Architecture / a later todo.
- NFR4: Tag-triggered deploy: GitHub Actions runs on push of tag `v0.0.1` and completes a Cloud Run deploy of this app (workflow failure visible in GitHub Actions).
- NFR5: Login and Tarifabfrage copy and `lang=de` / language control **DE** match the captured German UI for this slice.
- NFR6: Secrets (DB credentials, Cloud Run service account) must not be committed to the repository; injection via environment/Secret Manager is Architecture.
- NFR7: Login **host label** always reflects the **actual host** serving the page.

## Out of scope / future TODO (this slice)
- **FR-out-1 Forgot password:** `index.php?page=set_password` flow is **not** implemented here. Link on login chrome may remain for visual match.
- **FR-out-2 User management:** user CRUD / admin is a **future work item**. This slice uses existing DB auth only as needed for login.
- **FR-out-3 Extra v1 parity:** account lockout, CSRF hardening, password policy, remember-me, multilingual beyond captured DE, rate limiting — **skip now**; future work item.
- **FR-out-4 Submenu features:** Dashboard, News-Board, and other Tarife-verwalten destinations beyond showing Tarifabfrage as the landing — **not** required as working features in v0.0.1.
- **FR-out-5 Local/prod DB split:** preference recorded; **final** local vs Cloud SQL topology is deferred to Architecture / a later todo.
- **FR-out-6 Login API contract spec:** skipped up front; remaining details follow the live capture, not a written protocol in this item.
- **FR-out-7 Cloud SQL instance name:** **deferred / do later** — not blocking this slice.
- **FR-out-8 Live Tarifabfrage search:** filters, queries, and results against the DB — **later work items**. This slice keeps Tarifabfrage **basic** (chrome + layout, stubbed interactions).

## Needs clarification
None. Human signed off 2026-08-28. Remaining items above are deferred, not blockers for UX Input or Architecture Input.
