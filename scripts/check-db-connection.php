#!/usr/bin/env php
<?php
/**
 * Connectivity proof against sandbox MySQL via existing PDO stack.
 *
 * Does NOT flip AUTH_MODE, call db_find_user_password_hash(), or exercise login.
 *
 * Prerequisites:
 *   1. Cloud SQL Auth Proxy listening on 127.0.0.1:3306 for
 *      bestmodal-492819:europe-west1:bestmodal2-sandbox-mysql
 *   2. Local .env with DB_NAME=bestmodal2, DB_USER=bestmodal, DB_PASSWORD
 *      (prefer: ./scripts/sync-sandbox-db-env-from-sm.sh — password from SM, never echoed)
 *   3. DB_DSN_MODE=tcp, DB_HOST=127.0.0.1, DB_PORT=3306
 *
 * Usage (from repo root):
 *   php scripts/check-db-connection.php
 *   ./scripts/sync-sandbox-db-env-from-sm.sh --check
 *
 * Exit 0 on SELECT 1 success; non-zero on failure.
 */
declare(strict_types=1);

$root = dirname(__DIR__);

// Load gitignored .env if present (simple KEY=VALUE, no export).
$envFile = $root . '/.env';
if (is_readable($envFile)) {
    foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#')) {
            continue;
        }
        if (!str_contains($line, '=')) {
            continue;
        }
        [$key, $value] = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value);
        if ($key === '') {
            continue;
        }
        // Do not override already-exported env.
        if (getenv($key) === false) {
            putenv("{$key}={$value}");
            $_ENV[$key] = $value;
        }
    }
}

require_once $root . '/public/includes/db.php';

$name = getenv('DB_NAME') ?: '';
$user = getenv('DB_USER') ?: '';
if ($name === '' || $user === '') {
    fwrite(STDERR, "FAIL: DB_NAME and DB_USER must be set (operator-supplied; do not invent).\n");
    fwrite(STDERR, "Fill local .env from .env.example placeholders, then retry.\n");
    exit(2);
}

try {
    db_ping();
    $host = getenv('DB_HOST') ?: '127.0.0.1';
    $port = getenv('DB_PORT') ?: '3306';
    $mode = getenv('DB_DSN_MODE') ?: 'tcp';
    echo "OK: SELECT 1 succeeded via db_pdo() (DB_DSN_MODE={$mode}, {$host}:{$port}, db={$name}).\n";
    exit(0);
} catch (Throwable $e) {
    fwrite(STDERR, 'FAIL: ' . $e->getMessage() . "\n");
    exit(1);
}
