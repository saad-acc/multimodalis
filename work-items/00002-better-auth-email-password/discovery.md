# Discovery

## Existing systems / prior art

**Product request:** Human ask is to **assess** swapping current login for [Better Auth](https://www.better-auth.com) (email/password now; OAuth later). Item `00001-v2-php-cloudrun-login` is still in **verification** (human acceptance pending). That slice shipped native PHP sessions, not Better Auth. This item should not assume 00001’s architecture is frozen as the long-term auth design, nor implement a swap unless later requirements say so.

**PHP app today** ([Multimodalis PHP app](../../knowledge/components/multimodalis-php-app.md), [Login feature](../../knowledge/features/login.md), [pattern](../../knowledge/patterns/php-public-docroot-session-auth.md)):

| Piece | What it does |
| --- | --- |
| `public/pages/login.php` | German login card (`lang=de`); form POST `email` + `password` to `/api/check_login.php`; failure copy `„Anmeldung fehlgeschlagen.“`; “Passwort vergessen?” → `page=set_password` (redirects to login; no recovery UI). |
| `public/api/check_login.php` | POST-only; `attempt_login()`; success `302` → `page=tariff_query`; failure `302` → login `error=1` + email query. |
| `public/includes/auth.php` | PHP session cookie (`HttpOnly`, `SameSite=Lax`, `Secure` on HTTPS); `is_authenticated()` / `require_auth()` on `$_SESSION['user_email']`; `attempt_login` stub vs db; `session_regenerate_id` on success; `logout_user()`. |
| `public/includes/config.php` | `AUTH_MODE` `stub` \| `db` (default stub); `STUB_*`; Cloud SQL/TCP env; `DB_USERS_TABLE` / email / hash columns — **no invented users schema**. |
| `public/includes/db.php` | PDO MySQL socket or TCP; `db_find_user_password_hash` + `password_verify` when `AUTH_MODE=db`. |
| `docker-compose.yml` | Single PHP service; default `AUTH_MODE=stub`; optional `mysql` profile. No Node service. |
| `Dockerfile` | `php:8.3-apache` only. |

**00001 architecture (Session / auth)** — still the implemented contract until this assessment chooses otherwise:

- Native PHP sessions; identity = `user_email` in `$_SESSION`.
- `AUTH_MODE=stub` for offline local (optional closed gate via `STUB_EMAIL`/`STUB_PASSWORD`, else any non-empty pair).
- `AUTH_MODE=db`: existing Cloud SQL rows; **no user CRUD**; **do not invent a users schema**.
- Rejected for that slice: Laravel/Symfony; **new users schema / seed-only auth as the Cloud Run path**.

**Better Auth (library facts; not in this repo):** TypeScript/Node `betterAuth()`, ESM. Official adapters: Next, Express, SvelteKit, etc. **No PHP SDK.** Email/password: `emailAndPassword: { enabled: true }`; client `signIn.email` / `signUp.email`; default password length 8–128; hash **scrypt** (Node native), custom hash/verify possible. HTTP catch-all `/api/auth/*` (e.g. Express `toNodeHandler`). Session: Better Auth cookies + `auth.api.getSession({ headers })`. MySQL: `mysql2/promise` pool as `database`; schema via `npx @better-auth/cli migrate|generate` (`user`, `session`, `account`, `verification` typical). Passwords in `account` with `providerId` credential — **not** PHP `password_verify` on the env-named table. OAuth/`socialProviders` exist; **out of scope** for this item.

**Not in repo:** Better Auth package, Node runtime, `/api/auth/*` handler, Better Auth tables. Do not add a Component inventory entry until it exists in source.

## Constraints found

- **Runtime:** Cloud Run image is PHP 8.3 Apache (`Dockerfile`). Pattern and 00001 ADRs assume PHP as the request server for UI + `check_login`.
- **ADRs:** [Cloud SQL Unix socket](../../knowledge/decisions/cloud-sql-unix-socket-on-cloudrun.md) and [Env-based DB targets](../../knowledge/decisions/env-based-db-targets.md) are **proposed**, not accepted. Env contract (`DB_DSN_MODE`, `INSTANCE_CONNECTION_NAME`, stub auth for offline) still boxes any Node sidecar that needs MySQL: same Cloud SQL, Unix socket on Cloud Run vs TCP locally.
- **AUTH_MODE=stub:** Documented local path without a DB. Better Auth’s default path **needs a database** for its schema/sessions. Any swap must say what happens to stub/offline login.
- **Users table unknown:** `DB_USERS_TABLE` still a placeholder; 00001 verification never proved live `AUTH_MODE=db`. Legacy hashes (if any) are whatever PHP `password_verify` expects, not Better Auth scrypt in `account`.
- **No self-registration:** Product login is existing users only. Better Auth email/password typically exposes **sign-up** (`signUp.email`) unless disabled.
- **Session model mismatch:** `require_auth()` reads PHP `$_SESSION`. Better Auth sessions live in its tables/cookies. PHP gates would have to call `getSession` (or a BFF) or stop using PHP sessions as source of truth.
- **00001 rejected “framework for this slice” and “new users schema as Cloud Run path.”** Replacing the PHP app with Node, or adopting Better Auth’s generated schema, **tensions** with those rejections. Discovery names the tension; Architecture must decide if this item supersedes them. Do not pick here.
- **OAuth:** Explicitly future work; assessment must not treat social login as delivery.

**Stack mismatch (core finding):** Better Auth cannot drop into `auth.php`. A “swap” implies at least a Node process for `betterAuth()` plus a way PHP (or a proxy) trusts that session.

**Candidate integration shapes (options for Architecture — not chosen here):**

1. **Node auth sidecar / second Cloud Run service** — PHP `require_auth` / `check_login` call `getSession` or validate the Better Auth cookie over HTTP.
2. **Reverse proxy** — route `/api/auth/*` to Node; everything else to PHP Apache.
3. **Replace PHP app with Node** — full runtime change; conflicts with 00001 “framework-rejected-for-this-slice” and the current Cloud Run PHP image. Note tension; do not decide.
4. **Keep PHP UI form POST** — server-side call to Better Auth HTTP API from `check_login.php` so login chrome stays classic POST (no JS `signIn.email` required for the card). Still needs a Node handler somewhere.

**User store options (also not chosen):** (a) keep unknown existing Cloud SQL users and try to verify them; (b) Better Auth CLI schema as system of record; (c) custom Better Auth hasher/verifier so Node can check **legacy PHP hashes** during a migration. Combining (a) and (b) without a migration story is a product/ops question.

**Assess vs implement:** The request is an **assessment** of a swap. Drafting requirements can still be an assessment deliverable (constraints, options, out-of-scope OAuth). Implementing Node + schema is a separate scope question for Requirement Draft / clarification, not a Discovery blocker.

## Open questions

None that prevent drafting a coherent **assessment** requirement. Product/scope questions (assess-only vs implement a shape; stub vs Better Auth local; sign-up off; user store/legacy hashes; session source of truth) belong in requirements `## Needs clarification`, not a Discovery `blocked` guess.
