# Discovery

## Existing systems / prior art

- **v2:** Single factory `db_pdo()` in `public/includes/db.php` — one DSN from env (`DB_DSN_MODE` socket|tcp, Cloud SQL socket or TCP). Used for login hash lookup. Decisions: [Env-based DB targets](/knowledge/decisions/env-based-db-targets.md), [Cloud SQL Unix socket on Cloud Run](/knowledge/decisions/cloud-sql-unix-socket-on-cloudrun.md). Component: [Cloud SQL sandbox MySQL](/knowledge/components/cloudsql-sandbox-mysql.md). No `$pdo_ltl` / `$pdo_sales`.
- **Legacy include graph (1:1):**
  - Host **`connectdb.inc.php`** — **not in the modal git repo**. Included from `index.php` and many views/APIs: localhost → `DOCUMENT_ROOT/devbestmodal/connectdb.inc.php`; else → `HOME/connectdb.inc.php`. Exposes **`$pdo`** (core) and **`$pdo_ltl`** (per-subdomain `ltl_db_name` / `ltl_db_user`; nullable / missing tenant). Documented in `modal/docs/feature-map/shell-auth.md`, `ltl.md`, `docs/ltl/projektkontext.md`.
  - **`$pdo_sales`:** `includes/connectdb_sales.php` (in repo). Local vs prod branches; prod reads `HOME/connectdb_sales.cfg.php` (example: `docs/sales/connectdb_sales.cfg.example.php`). Missing config → handle null / logged error, not a merged connection.
  - **P2P (out of this request’s three PDOs but present):** `connectdb_p2p.inc.php` (host, not in repo) from some views/`apipp/`. Request in-scope names only `$pdo`, `$pdo_ltl`, `$pdo_sales`.
- **No `?page=` slug** for this item. Do not change query SQL. Do not merge three PDOs. Public JSON paths unchanged.

## Constraints found

- Env-driven connectivity already chosen for v2; must not hardcode instance IDs beyond env. Do not rewrite SELECT/INSERT. Schema migrations out of scope.
- Missing LTL/Sales DB → those handles **null** (LTL later 503). Verification: same PDO variable names as modal include graph.
- 00005-cloudsql-sandbox-connection still has unanswered DB name/user/password questions in that item’s `clarifications.md`.

## Open questions

- How to map host `connectdb.inc.php` / `$_sites[domain]` tenant selection onto v2 env (one Cloud SQL instance vs three databases vs three instances) without copying host secrets into git.
- Whether `$pdo_p2p` is explicitly out of this slice (request lists three names only).
- Whether bootstrap runs on every request (legacy index) including stub auth with no DB.
