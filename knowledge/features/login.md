---
type: Feature
title: Login (stub / session)
description: German Multimodalis login card; POST credentials to check_login; session gate for authenticated pages.
resource: public/pages/login.php
tags: [auth, ui]
timestamp: 2026-08-28
---

# Sub-features
- FR1 login chrome (`lang=de`, logo, real HTTP_HOST label, Anmelden, Passwort vergessen? visual-only)
- FR2 success → session + redirect `page=tariff_query`
- FR4 failure → no session; „Anmeldung fehlgeschlagen.“; email kept
- Unauthenticated deep link to protected pages → login before chrome
- `page=set_password` → redirect login (no recovery UI)

# How to get to it (user POV)
- Open app root / `index.php` / `index.php?page=login` while logged out
- Submit **Anmelden** on the login card
- Follow redirect after failed login (`error=1`)

# Driving it with compose+curl harness
Preconditions: `docker compose up --build`; optional `STUB_EMAIL`/`STUB_PASSWORD` for a closed stub gate.

1. **Doctor** — `curl` login page → HTTP 200; body title `Login Multimodalis`; host label matches request host (e.g. `localhost:8080`); no hardcoded sandbox host as the only label.
2. **Unauth deep link** — `GET /index.php?page=tariff_query` without cookie → 302 to `page=login`.
3. **Failure** — with stub gate set, `POST /api/check_login.php` wrong password → 302 `page=login&error=1`; follow → body contains `„Anmeldung fehlgeschlagen.“` (`role="alert"`); no Tarifabfrage chrome.
4. **Success** — `POST` correct (or any non-empty if stub open) → 302 `page=tariff_query` + session cookie.
5. **Forgot password** — `GET page=set_password` → 302 login (no set-password product UI).

Evidence for item `00001-v2-php-cloudrun-login`: `knowledge/features/evidence/00001-v2-php-cloudrun-login/01-login.*`, `02-unauth-tariff.headers`, `03-fail-login.*`, `04-success-login.headers`.

# Gotchas
- Without `STUB_*`, any non-empty pair succeeds — use stub gate when proving failure copy.
- zsh requires quoting URLs that contain `?`.
- Compose must pass `STUB_EMAIL`/`STUB_PASSWORD` into the container (see `docker-compose.yml`).
