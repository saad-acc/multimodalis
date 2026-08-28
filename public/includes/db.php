<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';

/**
 * PDO factory: Unix socket (Cloud Run) or TCP (Auth Proxy / Compose).
 * Does not hardcode INSTANCE_CONNECTION_NAME.
 */
function db_pdo(): PDO
{
    static $pdo = null;
    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $c = app_config();
    $user = $c['db_user'];
    $pass = $c['db_password'];
    $name = $c['db_name'];

    if ($name === '' || $user === '') {
        throw new RuntimeException('DB_NAME and DB_USER must be set for AUTH_MODE=db');
    }

    if ($c['db_dsn_mode'] === 'socket') {
        $socket = $c['db_socket'];
        if ($socket === '') {
            throw new RuntimeException('DB_SOCKET or INSTANCE_CONNECTION_NAME required for socket DSN');
        }
        $dsn = sprintf('mysql:unix_socket=%s;dbname=%s;charset=utf8mb4', $socket, $name);
    } else {
        $dsn = sprintf(
            'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
            $c['db_host'],
            $c['db_port'],
            $name
        );
    }

    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);

    return $pdo;
}

/**
 * Look up password hash for an existing user row. Table/columns from config env.
 * Returns null if not found or table not configured.
 */
function db_find_user_password_hash(string $email): ?string
{
    $c = app_config();
    $table = $c['db_users_table'];
    if ($table === '') {
        throw new RuntimeException(
            'DB_USERS_TABLE must be set for AUTH_MODE=db (existing Cloud SQL table — do not invent schema)'
        );
    }

    $emailCol = preg_replace('/[^a-zA-Z0-9_]/', '', $c['db_users_email_column']) ?: 'email';
    $hashCol = preg_replace('/[^a-zA-Z0-9_]/', '', $c['db_users_password_hash_column']) ?: 'password';
    $tableSafe = preg_replace('/[^a-zA-Z0-9_]/', '', $table);
    if ($tableSafe === '') {
        throw new RuntimeException('Invalid DB_USERS_TABLE');
    }

    $sql = sprintf(
        'SELECT `%s` AS password_hash FROM `%s` WHERE `%s` = :email LIMIT 1',
        $hashCol,
        $tableSafe,
        $emailCol
    );

    $stmt = db_pdo()->prepare($sql);
    $stmt->execute(['email' => $email]);
    $row = $stmt->fetch();
    if ($row === false || !isset($row['password_hash']) || $row['password_hash'] === '') {
        return null;
    }

    return (string) $row['password_hash'];
}
