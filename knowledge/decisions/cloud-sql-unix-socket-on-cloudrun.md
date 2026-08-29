---
type: Architecture Decision
title: Cloud SQL Unix socket on Cloud Run
description: Cloud Run services connect to Cloud SQL MySQL via the platform’s native Unix socket attachment, using INSTANCE_CONNECTION_NAME as the wiring placeholder.
tags: [architecture, gcp, cloud-sql, cloud-run]
timestamp: 2026-08-28
status: proposed
---

# Context
The Multimodalis PHP app on Cloud Run must use Cloud SQL MySQL in project `bestmodal-492819`. Instance name may be deferred; connector choice must still be fixed so deploy and PDO wiring stay consistent across work items.

# Decision
Cloud Run attaches Cloud SQL and the app connects with PDO over the Unix socket at `/cloudsql/${INSTANCE_CONNECTION_NAME}` (native Cloud SQL connection), not via a sidecar Auth Proxy or public IP.

# Consequences
Deploy needs `--add-cloudsql-instances` (or equivalent) and a runtime SA with Cloud SQL Client. Local development uses a different path (Auth Proxy TCP or Compose). Instance connection name can remain an env/secret placeholder until ops names the instance.

# Rejected alternatives
- [Auth Proxy sidecar on Cloud Run]: redundant with native attachment.
- [Public IP TCP from Cloud Run]: weaker default security posture.

# Citations
[1] Work item: [00001-v2-php-cloudrun-login architecture](/work-items/00001-v2-php-cloudrun-login/architecture.md)
[2] Work item: [00005-cloudsql-sandbox-connection architecture](/work-items/00005-cloudsql-sandbox-connection/architecture.md) — instance named; attach + Client role deferred with Better Auth / login; still the intended Cloud Run connector when enabled.
