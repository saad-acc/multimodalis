---
type: Architecture Decision
title: Dedicated multimodalis-run runtime SA
description: Cloud Run service multimodalis uses a dedicated runtime service account multimodalis-run; Cloud SQL Client is granted when instance attach is enabled, not earlier.
tags: [architecture, gcp, iam, cloud-run]
timestamp: 2026-08-29
status: proposed
---

# Context
Deploy auth already uses `GCP_SA_KEY` (deployer SA). Cloud Run needs a least-privilege **runtime** identity for future Cloud SQL attach, matching the ratecardwiz pattern of separating deployer and runtime accounts. Login-related attach is deferred with Better Auth, but the SA should exist early so later attach is a grant + flag change, not an identity redesign.

# Decision
Create dedicated runtime service account **`multimodalis-run`** in project `bestmodal-492819` for Cloud Run service `multimodalis`. Grant **Cloud SQL Client** (`roles/cloudsql.client`) when `--add-cloudsql-instances` (or equivalent) is later enabled — not required merely to create the SA or keep `AUTH_MODE=stub`. Do not invent broader roles for connectivity scaffolding.

# Consequences
Deploy workflow may set `--service-account=multimodalis-run@bestmodal-492819.iam.gserviceaccount.com` while attach remains off. Future attach work items add Client role + Unix-socket env; they must not reintroduce a second ad-hoc runtime SA.

# Rejected alternatives
- [Default Compute / App Engine runtime SA with broad roles]: weaker least privilege; rejected in favor of dedicated SA.
- [Grant Cloud SQL Client before any attach]: unnecessary privilege this phase.
- [Reuse deployer SA as runtime]: conflates deploy and runtime blast radius.

# Citations
[1] Work item: [00005-cloudsql-sandbox-connection architecture](/work-items/00005-cloudsql-sandbox-connection/architecture.md)
