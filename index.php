<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/session.php';
require_login();

$pageTitle = 'Home';
require __DIR__ . '/includes/header.php';
?>
<section class="card">
    <h1>Welcome, <?= escape($_SESSION['username']) ?></h1>
    <p>You are signed in.</p>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
