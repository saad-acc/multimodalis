<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/auth.php';

$page = isset($_GET['page']) ? (string) $_GET['page'] : '';

// Forgot-password is out of scope — redirect to login (no recovery UI)
if ($page === 'set_password') {
    header('Location: /index.php?page=login');
    exit;
}

if ($page === '' || $page === 'login') {
    if (is_authenticated()) {
        header('Location: /index.php?page=tariff_query');
        exit;
    }
    require __DIR__ . '/pages/login.php';
    exit;
}

// Authenticated shell: tariff_query and unknown pages → Tarifabfrage chrome
require_auth();

if ($page !== 'tariff_query') {
    // Chrome-only nav destinations: re-show Tarifabfrage (no feature pages)
    // Still require_auth already ran before any chrome
}

require __DIR__ . '/pages/tariff_query.php';
