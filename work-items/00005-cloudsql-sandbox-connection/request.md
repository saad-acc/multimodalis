# Request

**Submitted by:** human
**Date:** 2026-08-29

## Problem statement
Connect our sandbox app (localhost and the one deployed on Cloud Run) to the sandbox database on GCP Cloud SQL (already exists): `bestmodal-492819:europe-west1:bestmodal2-sandbox-mysql`.

Connect the local Multimodalis app AND Cloud Run `multimodalis` to Cloud SQL MySQL sandbox instance. Instance connection name: `bestmodal-492819:europe-west1:bestmodal2-sandbox-mysql`. Project `bestmodal-492819`, region `europe-west1`. Existing app uses AUTH_MODE stub/db, PDO socket/tcp from architecture of 00001. Preference previously recorded: localhost → sandbox DB; Cloud Run → sandbox for now (this is the sandbox DB); secrets not in git; GitHub Actions / Cloud Run env updates as needed. GCP_SA_KEY already configured for deploys.

## Why now
Previous work item `00001-v2-php-cloudrun-login` was accepted. Cloud SQL instance connection was deferred in that item; the sandbox MySQL instance now exists and both local and Cloud Run apps need to use it.

## Known constraints (if any)
- Do not invent DB credentials or commit secrets to git.
- Secrets via Secret Manager / env as needed (not in git).
- GitHub Actions / Cloud Run env updates as needed for Cloud SQL attach (`--add-cloudsql-instances`) and AUTH_MODE.
- Open questions expected: DB user, password Secret Manager, which tables for AUTH_MODE=db, local Auth Proxy setup, Cloud Run `--add-cloudsql-instances`, AUTH_MODE flip from stub to db.
- PHP app in `public/`; deploy workflow `.github/workflows/deploy.yml`; architecture in work-item 00001 artifacts.
