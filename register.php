<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/session.php';

if (isset($_SESSION['username'])) {
    redirect('index.php');
}

$fields = [
    'username' => ['Username', 50],
    'first_name' => ['First name', 60],
    'surname' => ['Surname', 60],
    'address_line_1' => ['Address line 1', 120],
    'address_line_2' => ['Address line 2', 120],
    'city' => ['City', 60],
    'telephone' => ['Telephone', 20],
    'mobile' => ['Mobile number', 10],
];
$values = array_fill_keys(array_keys($fields), '');
$errors = [];
$submitted = $_SERVER['REQUEST_METHOD'] === 'POST';

if ($submitted) {
    foreach ($fields as $name => [$label, $maxLength]) {
        $value = trim((string) filter_input(INPUT_POST, $name));
        $values[$name] = $value;

        if ($value === '') {
            $errors[$name] = "$label is required.";
        } elseif (!mb_check_encoding($value, 'UTF-8') || mb_strlen($value, 'UTF-8') > $maxLength) {
            $errors[$name] = "$label must contain at most $maxLength characters.";
        }
    }

    $mobile = $values['mobile'];
    if ($mobile !== '' && (strlen($mobile) !== 10 || !ctype_digit($mobile))) {
        $errors['mobile'] = 'Enter exactly 10 digits for the mobile number.';
    }

    $password = (string) filter_input(INPUT_POST, 'password');
    $confirmation = (string) filter_input(INPUT_POST, 'password_confirmation');
    if (!mb_check_encoding($password, 'UTF-8')
        || mb_strlen($password, 'UTF-8') !== 6
        || str_contains($password, "\0")) {
        $errors['password'] = 'Enter a password with exactly 6 characters.';
    }
    if ($confirmation === '') {
        $errors['password_confirmation'] = 'Confirm your password.';
    } elseif ($password !== $confirmation) {
        $errors['password_confirmation'] = 'The passwords do not match.';
    }
    if (!valid_csrf_token()) {
        $errors['form'] = 'The form expired. Please try again.';
    }
}

if ($submitted && $errors === []) {
    try {
        require __DIR__ . '/includes/database.php';

        $statement = $db->prepare(
            'INSERT INTO users
                (username, first_name, surname, address_line_1, address_line_2, city, telephone, mobile, password)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)'
        );
        $statement->execute([
            $values['username'],
            $values['first_name'],
            $values['surname'],
            $values['address_line_1'],
            $values['address_line_2'],
            $values['city'],
            $values['telephone'],
            $values['mobile'],
            password_hash($password, PASSWORD_DEFAULT),
        ]);

        $_SESSION['registered'] = true;
        redirect('login.php');
    } catch (PDOException $exception) {
        if (($exception->errorInfo[1] ?? null) === 1062) {
            $errors['username'] = 'That username is already taken.';
        } else {
            error_log($exception->getMessage());
            $errors['form'] = 'Registration is temporarily unavailable. Please try again.';
        }
    }
}

$pageTitle = 'Create an account';
require __DIR__ . '/includes/header.php';
?>
<section class="card card-wide">
    <h1>Create an account</h1>
    <?php if ($errors): ?>
        <div class="error" role="alert">
            <p>Check your registration details.</p>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= escape($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form method="post" class="form">
        <input type="hidden" name="csrf_token" value="<?= escape(csrf_token()) ?>">
        <div class="field-grid">
            <div class="field">
                <label for="username">Username</label>
                <input id="username" name="username" autocomplete="username" value="<?= escape($values['username']) ?>"
                       <?= isset($errors['username']) ? 'aria-invalid="true"' : '' ?> required>
            </div>
            <div class="field">
                <label for="first_name">First name</label>
                <input id="first_name" name="first_name" autocomplete="given-name" value="<?= escape($values['first_name']) ?>"
                       <?= isset($errors['first_name']) ? 'aria-invalid="true"' : '' ?> required>
            </div>
            <div class="field">
                <label for="surname">Surname</label>
                <input id="surname" name="surname" autocomplete="family-name" value="<?= escape($values['surname']) ?>"
                       <?= isset($errors['surname']) ? 'aria-invalid="true"' : '' ?> required>
            </div>
            <div class="field">
                <label for="address_line_1">Address line 1</label>
                <input id="address_line_1" name="address_line_1" autocomplete="address-line1"
                       value="<?= escape($values['address_line_1']) ?>" <?= isset($errors['address_line_1']) ? 'aria-invalid="true"' : '' ?> required>
            </div>
            <div class="field">
                <label for="address_line_2">Address line 2</label>
                <input id="address_line_2" name="address_line_2" autocomplete="address-line2"
                       value="<?= escape($values['address_line_2']) ?>" <?= isset($errors['address_line_2']) ? 'aria-invalid="true"' : '' ?> required>
            </div>
            <div class="field">
                <label for="city">City</label>
                <input id="city" name="city" autocomplete="address-level2" value="<?= escape($values['city']) ?>"
                       <?= isset($errors['city']) ? 'aria-invalid="true"' : '' ?> required>
            </div>
            <div class="field">
                <label for="telephone">Telephone</label>
                <input id="telephone" name="telephone" type="tel" autocomplete="tel" value="<?= escape($values['telephone']) ?>"
                       <?= isset($errors['telephone']) ? 'aria-invalid="true"' : '' ?> required>
            </div>
            <div class="field">
                <label for="mobile">Mobile number</label>
                <input id="mobile" name="mobile" type="tel" autocomplete="tel" value="<?= escape($values['mobile']) ?>"
                       inputmode="numeric" pattern="[0-9]{10}" aria-describedby="mobile-hint"
                       <?= isset($errors['mobile']) ? 'aria-invalid="true"' : '' ?> required>
                <p class="hint" id="mobile-hint">10 digits, including any leading zero.</p>
            </div>
            <div class="field">
                <label for="password">Password</label>
                <input id="password" name="password" type="password" autocomplete="new-password"
                       aria-describedby="password-hint" <?= isset($errors['password']) ? 'aria-invalid="true"' : '' ?> required>
                <p class="hint" id="password-hint">Exactly 6 characters.</p>
            </div>
            <div class="field">
                <label for="password_confirmation">Confirm password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                       <?= isset($errors['password_confirmation']) ? 'aria-invalid="true"' : '' ?> required>
            </div>
        </div>
        <button type="submit">Create account</button>
    </form>
    <p class="form-link"><a href="login.php">Back to sign in</a></p>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
