# Discovery

Work item: `00001-v2-php-cloudrun-login`  
Sources: `request.md`, `knowledge/components/`, `knowledge/domain/`, live sandbox inspection (login unauthenticated + first page after human auth, 2026-08-28), `clarifications.md`, repo glob (no PHP/Docker/CI).

## Existing systems / prior art

**This repository**
- Contains the multi-agent delivery workflow only (`WORKFLOW.md`, `knowledge/`, `templates/`, `.claude/agents/`). See [Multimodalis delivery workflow](../../knowledge/components/multimodalis-workflow.md).
- **No PHP application source**, no `Dockerfile`, no `composer.json`, no GitHub Actions workflows, no Cloud Run/Cloud SQL config in-tree.
- `knowledge/decisions/`, `patterns/`, `anti-patterns/`, and `features/` indexes are empty (no accepted ADRs or reusable app patterns).

**Live product (not in this repo)**
- [Sandbox BestModal](../../knowledge/components/sandbox-bestmodal.md): `https://sandbox.bestmodal.de` redirects to `/modal/index.php?page=login`. After Anmelden, redirect to `/modal/index.php?page=tariff_query`.
- Product vocabulary: [BestModal](../../knowledge/domain/bestmodal.md), [Tariff administration](../../knowledge/domain/tariff-administration.md), [Tarifabfrage](../../knowledge/domain/tarifabfrage.md).

**Captured login page**
- Title: Login BestModal; `lang=de`.
- Logo: `images/bestmodal-logo.svg` (BestModal / TARIFF ADMINISTRATION).
- Domain label on sandbox: sandbox.BestModal.de (v2 must show the **real host** of the environment, not a hardcoded sandbox label).
- Layout: white card on dark navy gradient (`#1a1a2e` → `#16213e`); accent green `#10B981` / `#059669`.
- CSS/JS: Bootstrap 5.3.0 and bootstrap-icons 1.10.5 from jsDelivr.
- Font stack: Segoe UI, system-ui, -apple-system, sans-serif.
- Form: POST to `/modal/api/check_login.php`; fields `email` (type=email, placeholder E-Mail-Adresse), `password` (placeholder Passwort); submit **Anmelden**. Success observed as landing on Tarifabfrage. Failure UX not separately specified (human: skip contract up front).
- Forgot password link: `index.php?page=set_password` (“Passwort vergessen?”) — **flow out of this slice**.
- Footer: © 2026 Acceltra GmbH.
- Favicon: `images/favicon.svg`.

**Captured first page (authenticated) — do not invent beyond this**
- URL: `index.php?page=tariff_query`; title **Tarifabfrage**.
- Left sidebar: BestModal logo → `dashboard`; pin control; nav Dashboard, News-Board; section **Tarife verwalten** (expanded) with Tarifabfrage (current) plus further tariff/RFQ/admin links. Full nav tree is present on v1; this slice implements **shell enough to show Tarifabfrage as landing**, not every submenu feature.
- Top bar: sidebar toggle, page title Tarifabfrage, language **DE**, **Profil** menu.
- Main: “Letzte Suchen” chips; form **Allgemeine Auswahl** (Leistungsdatum, Transport Mode, Hafen Auswahl chips Rotterdam/Antwerpen/Hamburg/Bremerhaven/Wilhelmshaven, Gestellung/Abholung required, Bruttogewicht, **Tarife suchen**); **Dispo-Filter** (Reederei, Depots, Terminals, Verkaufszuschlag Kundengruppe A–E, Vendor); **Filter** (BestPrice / Alle Preise / Kapazitätsanfrage / Index); empty results table area; side panels Preisdetails, Angebotsvorschau, Einkaufspreise; footer © 2026 Acceltra GmbH + placeholder legal links.
- Screenshots exist from Playwright (`sandbox-first-page-tariff-query.png` and login). Credentials were not recorded.

## Constraints found

Product / runtime (from human request — do not drop):
- This work is a **second version** of the existing PHP app, implemented **in this codebase**.
- Runtime image family: **php:8.3-apache**.
- Hosting target: **GCP Cloud Run**.
- Database: **Cloud SQL MySQL in the same GCP project**.
- Scope of this slice: **login + Tarifabfrage landing** as captured on sandbox.
- Must be **testable locally**, then **testable on Cloud Run**.
- **GitHub Actions** must deploy to Cloud Run when git tag **`v0.0.1`** is pushed.

GCP identifiers (human, non-secret):
- `PROJECT_ID=bestmodal-492819`
- `REGION=europe-west1`
- Cloud Run service name: `multimodalis`
- Cloud SQL **instance name not yet named**.
- Operator env context noted as `ENVIRONMENT=sandbox`.

Constraints for Architecture (named, not designed here):
- App must run on Cloud Run with Cloud SQL MySQL in the same project.
- **Do not treat Cloud SQL Auth Proxy vs Unix sockets (or any other connector) as “the” design.**
- Local DB wiring is **deferred** with a recorded preference: localhost app → remote sandbox DB; Cloud Run → remote prod DB (DBs initially the same). Compose MySQL is an alternative if sandbox connectivity is painful. Not chosen as “the” design here.
- Login HTTP contract: human skipped up-front spec; observed success path is POST `check_login.php` → `page=tariff_query`. Remaining cookie/error detail is Architecture from capture, not a planner invention.
- User CRUD is **out of this slice**; login may use existing DB auth only.

Constraints for UX:
- Login screen facts and Tarifabfrage shell above are the visual source of truth.
- Do not invent Dashboard, News-Board, or other submenu destinations as product features in this slice.
- Forgot-password **flow** is out of scope (link may remain on login chrome).

Repo conventions:
- No application coding standards or PHP dependencies exist yet in this repo.

## Open questions

Resolved in `clarifications.md` (see Requirements for how they land): first page captured; forgot-password skipped; login contract skipped (observe capture); user management future; extra v1 parity future; GCP project/region/service named; local DB deferred with preference; host label = real host.

Still blocking for business sign-off (not guessed here):
1. **Cloud SQL instance name** — still unnamed; needed for deploy wiring if FR6–FR8 require a named instance.
2. **Tarifabfrage depth for v0.0.1** — full interactive tariff search vs chrome + layout parity (orchestrator default: chrome/layout; search logic may be stubbed). Human should confirm or override at sign-off.
