<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';

/**
 * Configure session cookie before starting the session.
 */
function auth_bootstrap_session(): void
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return;
    }

    $https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (isset($_SERVER['SERVER_PORT']) && (string) $_SERVER['SERVER_PORT'] === '443')
        || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');

    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'secure' => $https,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);

    session_start();
}

auth_bootstrap_session();

function app_host_label(): string
{
    return $_SERVER['HTTP_HOST'] ?? 'localhost';
}

function is_authenticated(): bool
{
    return !empty($_SESSION['user_email']);
}

function require_auth(): void
{
    if (!is_authenticated()) {
        header('Location: /index.php?page=login');
        exit;
    }
}

function current_user_email(): ?string
{
    return $_SESSION['user_email'] ?? null;
}

function attempt_login(string $email, string $password): bool
{
    $email = trim($email);
    if ($email === '' || $password === '') {
        return false;
    }

    $c = app_config();
    $mode = $c['auth_mode'];

    if ($mode === 'stub') {
        $ok = attempt_login_stub($email, $password, $c);
    } elseif ($mode === 'db') {
        $ok = attempt_login_db($email, $password);
    } else {
        $ok = false;
    }

    if ($ok) {
        session_regenerate_id(true);
        $_SESSION['user_email'] = $email;
    }

    return $ok;
}

function attempt_login_stub(string $email, string $password, array $c): bool
{
    $expectedEmail = $c['stub_email'];
    $expectedPassword = $c['stub_password'];

    if ($expectedEmail !== '' || $expectedPassword !== '') {
        return hash_equals($expectedEmail, $email)
            && hash_equals($expectedPassword, $password);
    }

    // Local default: any non-empty credentials succeed
    return true;
}

function attempt_login_db(string $email, string $password): bool
{
    require_once __DIR__ . '/db.php';

    try {
        $hash = db_find_user_password_hash($email);
    } catch (Throwable $e) {
        error_log('attempt_login_db: ' . $e->getMessage());
        return false;
    }

    if ($hash === null) {
        return false;
    }

    return password_verify($password, $hash);
}

function logout_user(): void
{
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $p = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $p['path'],
            $p['domain'] ?? '',
            (bool) ($p['secure'] ?? false),
            (bool) ($p['httponly'] ?? true)
        );
    }
    session_destroy();
}
