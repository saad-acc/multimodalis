---
type: Pattern
title: PHP public docroot with session auth
description: Apache serves public/ as document root; pages use PHP sessions and a shared require_auth gate; login POSTs to api/check_login.php.
tags: [architecture]
timestamp: 2026-08-28
---

# When to use
Adding or extending the Multimodalis PHP UI behind login on `php:8.3-apache`, when matching sandbox-style `index.php?page=` routing without a heavy framework.

# How
1. Document root is `public/` (Dockerfile remaps Apache).
2. `index.php` dispatches on `page`; unauthenticated users get `login`; protected pages call `require_auth()` before any shell HTML.
3. Login form POSTs `email` and `password` to `/api/check_login.php`; success regenerates the session id, stores identity (e.g. `user_email`), redirects to the authenticated landing (`page=tariff_query` for v0.0.1).
4. Shared helpers live under `public/includes/` (`auth.php`, `db.php`, `config.php`).
5. Host label for chrome uses the real request host, not a hardcoded sandbox name.

# Seen in
- [00001-v2-php-cloudrun-login architecture](/work-items/00001-v2-php-cloudrun-login/architecture.md)
