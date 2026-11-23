<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= escape($pageTitle) ?> | Book Reservation</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<header class="site-header">
    <div class="header-content">
        <a class="site-name" href="index.php">Book Reservation</a>
        <?php if (isset($_SESSION['username'])): ?>
            <form method="post" action="logout.php">
                <input type="hidden" name="csrf_token" value="<?= escape(csrf_token()) ?>">
                <button class="secondary" type="submit">Sign out</button>
            </form>
        <?php endif; ?>
    </div>
</header>
<main>
