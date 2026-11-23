<?php

declare(strict_types=1);

session_start([
    'use_strict_mode' => true,
    'cookie_httponly' => true,
    'cookie_samesite' => 'Lax',
    'cookie_secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
]);

function redirect(string $page): never
{
    header('Location: ' . $page, true, 303);
    exit;
}

function require_login(): void
{
    if (!isset($_SESSION['username'])) {
        redirect('login.php');
    }
}

function escape(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function csrf_token(): string
{
    return $_SESSION['csrf_token'] ??= bin2hex(random_bytes(32));
}

function valid_csrf_token(): bool
{
    $submittedToken = (string) filter_input(INPUT_POST, 'csrf_token');
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $submittedToken);
}
