<?php
declare(strict_types=1);

/**
 * Env → typed settings for Multimodalis PHP app.
 */
function app_config(): array
{
    static $config = null;
    if ($config !== null) {
        return $config;
    }

    $authMode = getenv('AUTH_MODE') ?: 'stub';
    if (!in_array($authMode, ['stub', 'db'], true)) {
        $authMode = 'stub';
    }

    $dsnMode = getenv('DB_DSN_MODE') ?: 'tcp';
    if (!in_array($dsnMode, ['socket', 'tcp'], true)) {
        $dsnMode = 'tcp';
    }

    $instance = getenv('INSTANCE_CONNECTION_NAME') ?: '';
    $socket = getenv('DB_SOCKET') ?: '';
    if ($socket === '' && $instance !== '') {
        $socket = '/cloudsql/' . $instance;
    }

    $config = [
        'app_env' => getenv('APP_ENV') ?: 'local',
        'auth_mode' => $authMode,
        'stub_email' => getenv('STUB_EMAIL') ?: '',
        'stub_password' => getenv('STUB_PASSWORD') ?: '',
        'instance_connection_name' => $instance,
        'db_dsn_mode' => $dsnMode,
        'db_socket' => $socket,
        'db_host' => getenv('DB_HOST') ?: '127.0.0.1',
        'db_port' => getenv('DB_PORT') ?: '3306',
        'db_name' => getenv('DB_NAME') ?: '',
        'db_user' => getenv('DB_USER') ?: '',
        'db_password' => getenv('DB_PASSWORD') !== false ? (string) getenv('DB_PASSWORD') : '',
        // Table/columns from env when AUTH_MODE=db — confirmed by ops, not invented here
        'db_users_table' => getenv('DB_USERS_TABLE') ?: '',
        'db_users_email_column' => getenv('DB_USERS_EMAIL_COLUMN') ?: 'email',
        'db_users_password_hash_column' => getenv('DB_USERS_PASSWORD_HASH_COLUMN') ?: 'password',
    ];

    return $config;
}
