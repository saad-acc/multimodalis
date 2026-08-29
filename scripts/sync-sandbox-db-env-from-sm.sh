#!/usr/bin/env bash
# Write gitignored local .env DB_* from Secret Manager (sandbox), never echo password.
# Optionally run SELECT 1 via scripts/check-db-connection.php (Auth Proxy must be up).
#
# Prerequisites:
#   - gcloud authenticated as an identity that can access
#     projects/bestmodal-492819/secrets/bestmodal2-sandbox-database-url
#   - Optional: GOOGLE_APPLICATION_CREDENTIALS pointing at deployer SA JSON
#   - For --check: cloud-sql-proxy on 127.0.0.1:3306 for the sandbox instance
#
# Usage (from repo root):
#   ./scripts/sync-sandbox-db-env-from-sm.sh           # write/update .env only
#   ./scripts/sync-sandbox-db-env-from-sm.sh --check   # write .env then php scripts/check-db-connection.php
#
# Never commit .env. Password is never printed.

set -euo pipefail

ROOT="$(cd "$(dirname "$0")/.." && pwd)"
cd "$ROOT"

PROJECT_ID="${PROJECT_ID:-bestmodal-492819}"
SECRET_ID="${SECRET_ID:-bestmodal2-sandbox-database-url}"
INSTANCE_CONNECTION_NAME="${INSTANCE_CONNECTION_NAME:-bestmodal-492819:europe-west1:bestmodal2-sandbox-mysql}"
DB_NAME_DEFAULT="${DB_NAME_DEFAULT:-bestmodal2}"
DB_USER_DEFAULT="${DB_USER_DEFAULT:-bestmodal}"
ENV_FILE="${ENV_FILE:-$ROOT/.env}"
DO_CHECK=0

for arg in "$@"; do
  case "$arg" in
    --check) DO_CHECK=1 ;;
    -h|--help)
      sed -n '2,16p' "$0"
      exit 0
      ;;
    *)
      echo "Unknown arg: $arg (use --check or --help)" >&2
      exit 2
      ;;
  esac
done

if ! command -v gcloud >/dev/null 2>&1; then
  echo "FAIL: gcloud not found" >&2
  exit 1
fi
if ! command -v python3 >/dev/null 2>&1; then
  echo "FAIL: python3 not found" >&2
  exit 1
fi

# Parse password from mysql URL in SM; write only to a temp file (mode 600).
TMP_PASS="$(mktemp)"
chmod 600 "$TMP_PASS"
cleanup() { rm -f "$TMP_PASS"; }
trap cleanup EXIT

python3 - "$PROJECT_ID" "$SECRET_ID" "$TMP_PASS" <<'PY'
import os, re, subprocess, sys, urllib.parse
project, secret, out_path = sys.argv[1], sys.argv[2], sys.argv[3]
raw = subprocess.check_output(
    [
        "gcloud", "secrets", "versions", "access", "latest",
        f"--secret={secret}",
        f"--project={project}",
    ],
    env=os.environ,
).decode("utf-8").strip()
m = re.match(r"^[a-zA-Z0-9+]+://([^:/@]+):([^@]+)@", raw)
if m:
    password = urllib.parse.unquote(m.group(2))
else:
    u = urllib.parse.urlparse(raw)
    if not u.password:
        sys.stderr.write("FAIL: could not parse password from Secret Manager URL\n")
        sys.exit(1)
    password = urllib.parse.unquote(u.password)
with open(out_path, "w", encoding="utf-8") as f:
    f.write(password)
PY

DB_PASSWORD="$(cat "$TMP_PASS")"

# Merge into .env without printing secrets.
python3 - "$ENV_FILE" "$INSTANCE_CONNECTION_NAME" "$DB_NAME_DEFAULT" "$DB_USER_DEFAULT" "$TMP_PASS" <<'PY'
import pathlib, sys
env_path = pathlib.Path(sys.argv[1])
instance, db_name, db_user, pass_path = sys.argv[2], sys.argv[3], sys.argv[4], sys.argv[5]
password = pathlib.Path(pass_path).read_text(encoding="utf-8")

updates = {
    "APP_ENV": "local",
    "AUTH_MODE": "stub",
    "INSTANCE_CONNECTION_NAME": instance,
    "DB_DSN_MODE": "tcp",
    "DB_HOST": "127.0.0.1",
    "DB_PORT": "3306",
    "DB_NAME": db_name,
    "DB_USER": db_user,
    "DB_PASSWORD": password,
}

lines = []
if env_path.is_file():
    lines = env_path.read_text(encoding="utf-8").splitlines()

seen = set()
out = []
for line in lines:
    stripped = line.strip()
    if not stripped or stripped.startswith("#") or "=" not in line:
        out.append(line)
        continue
    key = line.split("=", 1)[0].strip()
    if key in updates:
        out.append(f"{key}={updates[key]}")
        seen.add(key)
    else:
        out.append(line)

for key, value in updates.items():
    if key not in seen:
        out.append(f"{key}={value}")

env_path.write_text("\n".join(out) + "\n", encoding="utf-8")
print(f"Wrote {env_path} (DB_NAME={db_name}, DB_USER={db_user}; password set, not printed).")
print("Reminder: .env is gitignored — do not commit it.")
PY

unset DB_PASSWORD

if [[ "$DO_CHECK" -eq 1 ]]; then
  echo "Running php scripts/check-db-connection.php (Auth Proxy must be listening)…"
  php "$ROOT/scripts/check-db-connection.php"
fi
