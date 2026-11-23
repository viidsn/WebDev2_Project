<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/session.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Allow: POST');
    http_response_code(405);
    exit('Use the sign-out button to end your session.');
}

if (!valid_csrf_token()) {
    http_response_code(403);
    exit('The form expired. Return to the previous page and try again.');
}

$_SESSION = [];
$cookieOptions = session_get_cookie_params();
unset($cookieOptions['lifetime']);
$cookieOptions['expires'] = time() - 3600;
setcookie(session_name(), '', $cookieOptions);
session_destroy();
redirect('login.php');
