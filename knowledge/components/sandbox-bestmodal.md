---
type: Component
title: Sandbox BestModal (live v1)
description: Existing PHP application running at sandbox.bestmodal.de; visual and login-entry source of truth for the v2 slice. Source is not in this repository.
resource: https://sandbox.bestmodal.de
tags: [external, php, login]
timestamp: 2026-08-28
---

# Responsibility
Hosts the current BestModal sandbox UI and login entry. Unauthenticated visits redirect to `/modal/index.php?page=login`. Login form POSTs to `/modal/api/check_login.php`. Successful login lands on `/modal/index.php?page=tariff_query` (Tarifabfrage). This repo does not contain that PHP source.

# Depends on / depended on by
- Future v2 PHP app in this repository (to be added) — should match captured login + Tarifabfrage landing chrome; not every sidebar submenu.
