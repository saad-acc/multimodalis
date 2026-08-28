# Implementation Log

Work item: `00001-v2-php-cloudrun-login`

## Task 1 — Secrets hygiene
Expanded `.gitignore` for `.env`, credential JSON/PEM files, IDE junk. Added `.env.example` documenting `APP_ENV`, `AUTH_MODE`, optional `STUB_*`, `INSTANCE_CONNECTION_NAME` placeholder (`PROJECT:REGION:INSTANCE`), DB socket/TCP fields, `DB_DSN_MODE`, and optional `DB_USERS_*` for existing-table lookup. No real passwords.

## Task 2 — Confirm assets
Kept `public/images/bestmodal-logo.svg` and `public/images/favicon.svg`. Wired from login (`login.php`) and Tarifabfrage shell (sidebar brand + favicon).

## Task 3 — Dockerfile
Aligned existing `Dockerfile` with plan (`php:8.3-apache`, `pdo`/`pdo_mysql`, `rewrite`+`headers`, docroot `/var/www/html/public`, copy `public/`, expose 80, no `.env` bake). No structural change required beyond verification.

## Task 4 — Config include
Added `public/includes/config.php` with `app_config()`: `AUTH_MODE`, DSN mode, DB fields, stub credentials, users-table env hooks.

## Task 5 — PDO factory
Added `public/includes/db.php`: socket DSN via `/cloudsql/${INSTANCE_CONNECTION_NAME}` (or `DB_SOCKET`); TCP via `DB_HOST`/`DB_PORT`. `db_find_user_password_hash()` uses env table/columns only — no invented schema, no migrations.

## Task 6 — Auth helpers
Extended `public/includes/auth.php`: session cookie `HttpOnly` + `SameSite=Lax` + `Secure` on HTTPS; `session_regenerate_id(true)` on success; `user_email` in session; `require_auth()`; stub and db `attempt_login()` with `password_verify()` for db mode.

## Task 7 — Front controller
Added `public/index.php`: login default; `set_password` → login redirect; auth gate before Tarifabfrage chrome; authenticated `page=login` → `tariff_query`; unknown authenticated pages → Tarifabfrage chrome.

## Task 8 — Login view
Added `public/pages/login.php`: `lang=de`, title Login BestModal, navy gradient, white card, logo, real `HTTP_HOST` label, labeled email/password, Anmelden greens, Passwort vergessen? → set_password (inert via routing), footer © 2026 Acceltra GmbH, Bootstrap 5.3.0 + icons 1.10.5 CDN, double-submit disable, `role="alert"` error slot.

## Task 9 — Login check API
Added `public/api/check_login.php`: POST → `attempt_login()`; success 302 `tariff_query`; failure 302 login with `error=1` + email kept; copy **„Anmeldung fehlgeschlagen.“**

## Task 10 — Tarifabfrage chrome
Added `public/pages/tariff_query.php`: sidebar/top bar/main layout per UX; empty results; Tarife suchen prevents default (no DB); nav destinations re-show Tarifabfrage via front controller; landmarks + `aria-current` on Tarifabfrage.

## Task 11 — Gate + chrome-only nav
Verified in code paths: `require_auth()` before including tariff_query; failed login never sets session; dashboard/news/profil are chrome-only (no CRUD). Live smoke deferred to Docker verification below.

## Task 12 — Local Compose
Updated `docker-compose.yml`: port `${APP_PORT:-8080}:80`, default `AUTH_MODE=stub`, env passthrough for `STUB_EMAIL`/`STUB_PASSWORD` and DB fields, optional `mysql` profile.

## Task 13 — README
Added root `README.md` with stub compose path, optional Auth Proxy, optional MySQL profile, host-label note, and GHA tag deploy summary.

## Task 14 — GitHub Actions → Cloud Run
Added `.github/workflows/deploy.yml` triggered on tag `v0.0.1`: WIF auth placeholders, docker build/push, `gcloud run deploy multimodalis` in `bestmodal-492819` / `europe-west1`, port 80, `AUTH_MODE=db`, conditional Cloud SQL attach, no secrets in repo.

## Docker verification
- `docker build -t multimodalis:local .` — **pass**
- `docker compose up -d --build` — **pass**
- Smoke (curl): login 200 with title Login BestModal + host `localhost:8080`; unauth `tariff_query` → 302 login; stub POST → 302 `tariff_query`; auth Tarifabfrage 200 with empty results + `aria-current`; empty POST → login `error=1`; wrong stub password → **„Anmeldung fehlgeschlagen.“**; `set_password` → 302 login.
- `docker compose down` after smoke.
- No blockers for local stub path. Cloud SQL instance name + user table columns still deferred (env placeholders only).

## Verification follow-up — Classic UI restyle (2026-08-28)
Applied **Classic** tokens from `bestmodal2UI` (`http://localhost:5174/app`) as fonts + element colors only (`Manrope`, brand teal `#14b8a6`/`#0d9488`/`#0f766e`, slate sidebar `#0f172a`, muted surfaces/borders/text). Restored sandbox-matching login + Tarifabfrage **layout** (no Vite accordion shell / nav search / Multimodalis chrome). Shared CSS: `public/assets/classic.css`.

## Branding — Multimodalis (2026-08-29)
Replaced user-facing BestModal labels with Multimodalis; logo `public/images/multimodalis-logo.png` (attached mark); removed `bestmodal-logo.svg` / old favicon. Left GCP project id `bestmodal-492819`, sandbox URLs, and historical work-item capture notes unchanged.
