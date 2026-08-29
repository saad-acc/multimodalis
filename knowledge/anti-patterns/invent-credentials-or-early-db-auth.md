---
type: Anti-pattern
title: Invent credentials or flip AUTH_MODE=db before Better Auth
description: Do not invent DB name/user/password in repo artifacts, and do not switch login to AUTH_MODE=db or Cloud Run SQL attach for login until after Better Auth assessment.
tags: [architecture, secrets, auth]
timestamp: 2026-08-29
---

# What it looks like
Filling `.env.example`, workflow YAML, or docs with plausible MySQL database names, users, or passwords “so CI works”; or flipping Cloud Run / local defaults to `AUTH_MODE=db` and wiring `DB_USERS_*` / `--add-cloudsql-instances` in the same slice as first sandbox connectivity.

# Why it's wrong here
Operators own real sandbox credentials; inventing them pollutes git and fails live proof. Human clarified (`00005`) that DB login and login-related Cloud Run attach wait on a Better Auth assessment — connectivity and secrets scaffolding must not drag auth flip along.

# Rejected in
- [00005-cloudsql-sandbox-connection](/work-items/00005-cloudsql-sandbox-connection/architecture.md) — requirements/clarifications 2026-08-29 (human).

# Prefer instead
[Env-based DB targets](/decisions/env-based-db-targets.md), [GitHub Environment sandbox for DB secrets](/decisions/github-environment-sandbox-db-secrets.md), and local Auth Proxy + `SELECT 1` connectivity proof with `AUTH_MODE=stub`.
