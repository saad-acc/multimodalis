# Requirements

**Status:** draft
**Approved by:**
**Approved on:**

## Business requirement
Every later MySQL feature must see the same PDO handles as modal (`$pdo`, `$pdo_ltl`, `$pdo_sales`) without rewriting SQL or merging tenant databases.

## Stakeholder requirements
- [Feature ports]: Include/bootstrap once; use `$pdo` / `$pdo_ltl` / `$pdo_sales`; null when that tenant DB is not configured.
- [Ops]: Credentials and instance IDs stay in env/secrets; no host `connectdb.inc.php` committed.
- [Users]: No new `?page=` slug; no JSON URL changes.

## Solution requirements

### Functional
- FR1: Application bootstrap exposes `$pdo`, `$pdo_ltl`, `$pdo_sales` with the same nullability as modal (missing LTL/Sales → null, not a shared connection).
- FR2: Connection selection is env/host equivalent to `connectdb.inc.php` + `connectdb_sales.php` — not a new query API and not a merge of three databases into one PDO.
- FR3: No SQL text changes in this item. No schema migrations.
- FR4: No dedicated `?page=` for bootstrap. Unknown slugs remain a routing concern (00002), not this item.
- FR5: Do not migrate feature pages or change `/api/` contracts here.

### Non-functional
- NFR1: Secrets never in git (align with env-based DB ADR).
- NFR2: Cloud Run continues Unix socket attach when `DB_DSN_MODE=socket`; local TCP/proxy as already decided for v2 — extended for extra DBs via env, not hardcoded hosts in PHP.
- NFR3: Boot with missing LTL/Sales config must not fatal the core login path solely because `$pdo_ltl` is null (legacy: later LTL 503).

## Needs clarification
- What env/secret names and Cloud SQL databases correspond to core `$pdo`, `$pdo_ltl`, and `$pdo_sales` for sandbox/prod (ops must name existing DBs; do not invent)? How does tenant/host switching from `$_sites[SERVER_NAME]` work on a single Cloud Run service?
- Is `connectdb_p2p.inc.php` / a fourth PDO in or out of this slice (request lists three variables only)?
- Should bootstrap always attempt PDO when `AUTH_MODE=stub`, or skip DB when stub (today login can run without `db_pdo()`)?
