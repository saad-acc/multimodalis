# UX Spec

Work item: `00005-cloudsql-sandbox-connection`  
Source of truth: approved `requirements.md` (sign-off in `clarifications.md`, 2026-08-29).  
Slice type: **thin / infra** — Cloud SQL sandbox connectivity, secrets hygiene, and docs; **no product UI work**.  
Knowledge: `knowledge/patterns/` has **no** entries tagged `ux`. Architecture-tagged session-auth pattern is out of scope for this slice (login stays stub/unchanged).

**UX impact summary:** None for end users. No new screens, no login chrome changes, no Better Auth / `AUTH_MODE=db` UI. Developer-facing docs only; accessibility N/A for new interactive UI.

---

## Flow: Product end-user experience (FR4, FR7, NFR7) — no change

1. **Entry:** User opens Multimodalis (local or Cloud Run `multimodalis`) as today.
2. **Outcome:** Login remains stub (or unchanged). No DB-backed credential check, no users-table mapping UI, no Better Auth surfaces.
3. **Error/empty:** N/A for this slice — do not redesign login failure, empty states, or auth recovery. Existing login chrome from prior work items is **out of scope** to modify.

**Interaction notes:** No change to login chrome, validation, loading, or feedback. Do not invent connection-failure messaging on the login card for this slice.

**Accessibility:** No new interactive UI. Existing WCAG 2.1 AA expectations for the current login/shell (from prior UX specs) remain as-is; this item adds nothing to check.

**Reuses existing pattern:** None needed — no UX pattern applies. **Do not** invent a new UX pattern for infra wiring.

---

## Flow: Developer local connectivity proof (FR2, FR3, FR9, NFR3, NFR6) — docs / ops only

1. **Entry:** Developer follows README / `.env.example` (or equivalent) to run Cloud SQL Auth Proxy against `bestmodal-492819:europe-west1:bestmodal2-sandbox-mysql` on `127.0.0.1:3306`, with `DB_DSN_MODE=tcp` and operator-filled local `.env` placeholders.
2. **Steps (non-UI):** Start proxy → configure env → run simple DB connection proof (app helper or one-off script) — **connectivity only**, not login against sandbox user rows.
3. **Success outcome:** Documented proof that a MySQL connection opens; login path still stub.
4. **Error / blocked states:**
   - Proxy not running / wrong port → connection fails at the connector; surface is **ops/docs**, not a new product error screen.
   - Placeholders not yet filled by operators → verification may be **blocked-on-secrets** (documented); do not invent credentials in UI or copy.
   - No requirement to show a user-facing “DB down” page for this slice.

**Interaction notes:** N/A for product UI. Docs should state clearly that DB login / Cloud Run SQL attach / `AUTH_MODE=db` are deferred.

**Accessibility:** N/A — no new interactive UI. Docs are plain text/markdown for developers.

**Reuses existing pattern:** None (no `ux`-tagged patterns). Docs-only guidance; not a reusable product UX pattern.

---

## Flow: Operator / deployer sandbox env (FR1, FR5, FR6, FR8, NFR1, NFR5, NFR6) — no product UI

1. **Entry:** Operators configure GitHub Environment **`sandbox`** (secret/var *names* only in docs/workflow references) and create runtime SA **`multimodalis-run`** for later attach.
2. **Outcome:** Scaffolding and secrets hygiene without Cloud Run SQL attach or login flip this slice.
3. **Error/empty:** Misconfigured env is an ops concern; **no** new in-app operator console or secret-entry UI.

**Interaction notes:** N/A — GitHub / GCP consoles, not Multimodalis product chrome.

**Accessibility:** N/A — no new interactive product UI.

**Reuses existing pattern:** None needed.

---

## Functional requirements coverage (UX)

| FR | UX coverage |
| --- | --- |
| FR1 Sandbox target only | No product UI; instance name may appear in docs only. |
| FR2 Local Auth Proxy TCP path | Docs / developer flow above; no app chrome change. |
| FR3 Local feasibility test | Docs + connectivity proof; not a user-facing flow. |
| FR4 No DB login auth | Explicit: **no login UX change**; stub/unchanged. |
| FR5 GitHub Environment `sandbox` | Ops only; no in-app UI. |
| FR6 Secrets hygiene | No UI for entering/displaying real secrets. |
| FR7 Cloud Run deferral | No attach/login flip UI; no change to login chrome. |
| FR8 Runtime SA `multimodalis-run` | Ops only; no product UI. |
| FR9 Docs | Developer-facing documentation only. |
| FR10 No external BestModal v1 / invented schema | No UX inventing credentials or user-admin screens. |

---

## Risks for Solution Architect

- None for design-system gaps: **no new interactive components** are required.
- If Architecture later chooses to surface a raw PDO/connect failure on a page that already hits the DB for non-login reasons, prefer existing calm error patterns from prior slices — **do not** invent a new connection-error design in this item; keep login chrome untouched.
- Do not treat developer docs as a product UX pattern to promote under `knowledge/patterns/` (tag `ux`).
