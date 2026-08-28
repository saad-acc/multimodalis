---
type: Domain Concept
title: Better Auth
description: Intended library for Multimodalis v2 authentication — Node/TypeScript, email/password first, OAuth later; not a PHP SDK.
tags: [auth, domain]
timestamp: 2026-08-28
---

# Definition
In this project, **Better Auth** means the [better-auth](https://www.better-auth.com) TypeScript library (`betterAuth()`), not a PHP drop-in. Email/password (`emailAndPassword`) is the first method to assess against today’s PHP session login. OAuth / `socialProviders` are a later work item, not part of the current assessment.

There is no official PHP SDK. A swap cannot live only inside `public/includes/auth.php`; it implies a Node runtime (sidecar, BFF, reverse-proxy split, or replacing PHP for auth). Default hashing is Node **scrypt**; sessions are Better Auth cookies plus its own schema (`user`, `session`, `account`, `verification` typical), not PHP `$_SESSION` + `password_verify` on an env-named users table.

# Related terms
- [Multimodalis PHP app (v2)](../components/multimodalis-php-app.md)
- [Login (stub / session)](../features/login.md)
