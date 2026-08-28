# Clarifications

Log every human touchpoint here, in order: business sign-off, and any
`blocked` question/answer regardless of which state raised it.

## 2026-08-28 — requirement_draft — asked by: delivery-planner
**Question:** What is the post-login first page on https://sandbox.bestmodal.de (layout, URL/route, copy, data shown, navigation)? Please authenticate in the browser so it can be captured. Do not ask agents to invent a dashboard.

**Answer:** Captured 2026-08-28 via browser: after Anmelden, redirect to **`https://sandbox.bestmodal.de/modal/index.php?page=tariff_query`**, title **Tarifabfrage**.

Observed shell:
- Left sidebar: BestModal logo → `dashboard`; pin control; nav: Dashboard, News-Board; section **Tarife verwalten** (expanded) with Tarifabfrage (current) plus many tariff/RFQ/admin links (full nav tree present; this slice implements shell enough to show Tarifabfrage as landing, not every submenu feature).
- Top bar: sidebar toggle, page title Tarifabfrage, language **DE**, **Profil** menu.
- Main: “Letzte Suchen” chips; form **Allgemeine Auswahl** (Leistungsdatum, Transport Mode, Hafen Auswahl chips Rotterdam/Antwerpen/Hamburg/Bremerhaven/Wilhelmshaven, Gestellung/Abholung required, Bruttogewicht, **Tarife suchen**); **Dispo-Filter** (Reederei, Depots, Terminals, Verkaufszuschlag Kundengruppe A–E, Vendor); **Filter** (BestPrice / Alle Preise / Kapazitätsanfrage / Index); empty results table area; side panels Preisdetails, Angebotsvorschau, Einkaufspreise; footer © 2026 Acceltra GmbH + placeholder legal links.
- Screenshots: login + `sandbox-first-page-tariff-query.png` (Playwright output). Credentials not recorded here.

**Decided by:** human (capture)

## 2026-08-28 — requirement_draft — asked by: delivery-planner
**Question:** (follow-up) Confirm scope of first page for v0.0.1 — full Tarifabfrage interactive app or authenticated landing chrome + layout parity?

**Answer:** **Keep it basic** — chrome + layout for Tarifabfrage; more interactivity in later work items. Search/filter/results may be stubbed.

**Decided by:** human

## 2026-08-28 — requirement_draft — asked by: delivery-planner
**Question:** Is “Passwort vergessen?” / `index.php?page=set_password` in the v0.0.1 slice, or only login + first authenticated page (link visible but flow deferred)?

**Answer:** Skip for this work item. Out of scope for v0.0.1 slice (link may remain on login chrome if matching sandbox; flow not implemented here).

**Decided by:** human

## 2026-08-28 — requirement_draft — asked by: delivery-planner
**Question:** What should happen after POST to the login-check endpoint on success and on failure (redirect, JSON, cookies, error text)? This was not observed unauthenticated.

**Answer:** Skip for this work item — observe from the live login click capture instead of specifying up front. Any remaining contract detail deferred.

**Decided by:** human

## 2026-08-28 — requirement_draft — asked by: delivery-planner
**Question:** Where do login users live for v2 — new Cloud SQL schema, copy of sandbox data, or seeded test users only?

**Answer:** **TODO / future work item:** user management. Not implemented in this slice. This work item uses existing auth against the DB as needed for login only; no user CRUD.

**Decided by:** human

## 2026-08-28 — requirement_draft — asked by: delivery-planner
**Question:** Beyond the captured login chrome, what v1 behaviors must match (lockout, CSRF, password rules, German-only, etc.)?

**Answer:** **TODO / future work item:** skip for now. Do not expand parity beyond what is needed to match captured login + first page and get auth working.

**Decided by:** human

## 2026-08-28 — requirement_draft — asked by: delivery-planner
**Question:** What GCP project, region, Cloud Run service name, and Cloud SQL instance should tag `v0.0.1` deploy to?

**Answer:** From ratecardwiz operator env (non-secret): `PROJECT_ID=bestmodal-492819`, `REGION=europe-west1`, Cloud Run service name `multimodalis`. Environment context: `ENVIRONMENT=sandbox`. **Cloud SQL instance name: do later** (not blocking this slice’s app/UI; deploy wiring may use a placeholder / secret later).

**Decided by:** human

## 2026-08-28 — requirement_draft — asked by: delivery-planner
**Question:** For local testing, should developers use a local MySQL (e.g. Compose) or connect to Cloud SQL from the machine?

**Answer:** **TODO / future decision (suggestion recorded):** Prefer localhost app → remote **sandbox** DB; deployed Cloud Run app → remote **prod** DB (initially both DBs kept the same). Local Compose MySQL is an alternative if sandbox connectivity is painful; defer final choice to Architecture/a later todo, with that preference as the starting recommendation.

**Decided by:** human (deferred with preference)

## 2026-08-28 — requirement_draft — asked by: delivery-planner
**Question:** The sandbox login shows domain label `sandbox.BestModal.de`. What label should local and Cloud Run environments show?

**Answer:** Use the **real host** for the environment (e.g. `localhost`, Cloud Run hostname). Do not hardcode `sandbox.BestModal.de` on non-sandbox deploys.

**Decided by:** human

## 2026-08-28 — requirement_draft — asked by: delivery-planner
**Question:** What is the Cloud SQL instance name in GCP project `bestmodal-492819` (region `europe-west1`) for wiring Cloud Run service `multimodalis`? Still unnamed after the GCP naming answer.

**Answer:** **Do this later.** Not required to unblock v0.0.1 app shell / login / basic Tarifabfrage. Architecture may leave a placeholder for instance connection name.

**Decided by:** human

## 2026-08-28 — requirement_draft — asked by: delivery-planner
**Question:** For v0.0.1 sign-off: is Tarifabfrage **chrome + layout parity** (search/filter/results allowed to be stubbed) sufficient, or must tariff search be fully interactive against the DB? Recorded default is chrome/layout unless you override.

**Answer:** **Keep it basic.** Chrome + layout only; more later in future work items. Stub search/filter/results as needed.

**Decided by:** human

## 2026-08-28 — business_clarification — asked by: human
**Question:** Sign-off on `requirements.md` for work item `00001-v2-php-cloudrun-login`?

**Answer:** Approved with clarifications above (Cloud SQL instance later; Tarifabfrage basic chrome/layout).

**Decided by:** human
