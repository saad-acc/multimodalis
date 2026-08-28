# Feature map

The maintained, live-verifiable inventory of the product's user-facing
behavior — one file per feature (`templates/knowledge/feature.md`), plus the
harness conventions below. This is what `verification` drives against
instead of self-reporting, and what `implementer`'s feature-map maintenance
pass keeps honest as the app changes.

## Harness

**Launch (local stub auth)**

```bash
docker compose up --build
# App: http://localhost:8080
# Default AUTH_MODE=stub — any non-empty email+password, or set STUB_EMAIL/STUB_PASSWORD
```

**Doctor check (read-only)**

```bash
curl -sS -o /dev/null -w '%{http_code}\n' 'http://localhost:8080/index.php?page=login'
# Expect: 200
```

**How to drive**

- Primary: HTTP/`curl` (session cookies via `-c`/`-b`) against localhost:8080.
- Optional: browser at the same URLs.
- Login POST: `POST /api/check_login.php` with form fields `email`, `password`.
- Pages: `/index.php?page=login`, `/index.php?page=tariff_query`.

**Evidence location**

`knowledge/features/evidence/<work-item-id>/` — HTML bodies, response headers,
and short command logs from the verification drive (not secrets).

**Cleanup**

```bash
docker compose down
```

## Features

- [Login (stub / session)](login.md) — unauthenticated login screen + check_login
- [Tarifabfrage landing (chrome)](tarifabfrage-landing.md) — post-login shell, stubbed search
