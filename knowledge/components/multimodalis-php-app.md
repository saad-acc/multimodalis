---
type: Component
title: Multimodalis PHP app (v2)
description: Greenfield PHP 8.3 Apache app in this repo — login + Tarifabfrage chrome, Docker/Compose local, GitHub Actions → Cloud Run.
resource: public/
tags: [app, php, cloud-run]
timestamp: 2026-08-28
---

# Responsibility
Serves Multimodalis v2 UI at app root (`public/` docroot): session login via `api/check_login.php`, authenticated Tarifabfrage chrome stub, env-driven stub/db auth and Cloud SQL PDO wiring. Deploy image from repo `Dockerfile`; local via `docker-compose.yml`.

# Depends on / depended on by
- Visual/auth contract mirrors [Sandbox BestModal](sandbox-bestmodal.md) (external v1 reference during piecemeal migration; not a deploy dependency). Product branding in this app is **Multimodalis**.
- Process/knowledge still owned by [Multimodalis delivery workflow](multimodalis-workflow.md).
- Cloud SQL instance name and users table columns deferred (env placeholders).
