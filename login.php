<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/session.php';

if (isset($_SESSION['username'])) {
    redirect('index.php');
}

$username = '';
$error = '';
$registered = $_SESSION['registered'] ?? false;
unset($_SESSION['registered']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim((string) filter_input(INPUT_POST, 'username'));
    $password = (string) filter_input(INPUT_POST, 'password');

    if (!valid_csrf_token()) {
        $error = 'The form expired. Please try again.';
    } elseif ($username === '' || $password === '') {
        $error = 'Enter your username and password.';
    } else {
        try {
            require __DIR__ . '/includes/database.php';

            $statement = $db->prepare('SELECT username, password FROM users WHERE username = ?');
            $statement->execute([$username]);
            $user = $statement->fetch();

            if ($user && password_verify($password, $user['password'])) {
                session_regenerate_id(true);
                $_SESSION = ['username' => $user['username']];
                redirect('index.php');
            }

            $error = 'The username or password is incorrect.';
        } catch (PDOException $exception) {
            error_log($exception->getMessage());
            $error = 'Sign-in is temporarily unavailable. Please try again.';
        }
    }
}

$pageTitle = 'Sign in';
require __DIR__ . '/includes/header.php';
?>
<section class="card">
    <h1>Sign in</h1>
    <?php if ($registered): ?>
        <p class="notice" role="status">Your account was created. You can sign in now.</p>
    <?php endif; ?>
    <?php if ($error !== ''): ?>
        <p class="error" role="alert"><?= escape($error) ?></p>
    <?php endif; ?>
    <form method="post" class="form">
        <input type="hidden" name="csrf_token" value="<?= escape(csrf_token()) ?>">
        <label for="username">Username</label>
        <input id="username" name="username" autocomplete="username" value="<?= escape($username) ?>" required>
        <label for="password">Password</label>
        <input id="password" name="password" type="password" autocomplete="current-password" required>
        <button type="submit">Sign in</button>
    </form>
    <p class="form-link"><a href="register.php">Create an account</a></p>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
