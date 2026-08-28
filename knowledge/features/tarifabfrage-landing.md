---
type: Feature
title: Tarifabfrage landing (chrome)
description: Authenticated Tarifabfrage shell matching sandbox layout; search/filters stubbed with empty results.
resource: public/pages/tariff_query.php
tags: [tarifabfrage, ui]
timestamp: 2026-08-28
---

# Sub-features
- Post-login landing only authenticated product page for v0.0.1
- Sidebar / top bar / Allgemeine Auswahl / Dispo-Filter / Filter / empty results / side panels
- Tarife suchen and filters: local UI only; no DB tariff query
- Nav destinations (Dashboard, News-Board, etc.): chrome only — re-show Tarifabfrage
- Landmarks + `aria-current="page"` on Tarifabfrage

# How to get to it (user POV)
- Successful **Anmelden** → lands on Tarifabfrage
- Or open `index.php?page=tariff_query` while already authenticated

# Driving it with compose+curl harness
Preconditions: authenticated session cookie from [Login](login.md) success step.

1. **Land** — `GET /index.php?page=tariff_query` with session → HTTP 200; title `Tarifabfrage`.
2. **Shell** — body includes sidebar Tarifabfrage with `aria-current="page"`, Allgemeine Auswahl, empty results text `Keine Ergebnisse`, side panels Preisdetails / Angebotsvorschau / Einkaufspreise, footer Acceltra.
3. **No live search** — page does not return fabricated tariff rows; search submit is client no-op staying on empty results (prove via HTML: empty results region present; no tariff data table rows with prices).

Evidence for item `00001-v2-php-cloudrun-login`: `knowledge/features/evidence/00001-v2-php-cloudrun-login/05-tariff.html` (+ headers).

# Gotchas
- Without a session, this page never renders (redirect login) — drive login first.
- Do not treat chrome nav links as product features in this slice.
