<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /index.php?page=login');
    exit;
}

$email = isset($_POST['email']) ? trim((string) $_POST['email']) : '';
$password = isset($_POST['password']) ? (string) $_POST['password'] : '';

if (attempt_login($email, $password)) {
    header('Location: /index.php?page=tariff_query', true, 302);
    exit;
}

$query = http_build_query([
    'page' => 'login',
    'error' => '1',
    'email' => $email,
]);
header('Location: /index.php?' . $query, true, 302);
exit;
