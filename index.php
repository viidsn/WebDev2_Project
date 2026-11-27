<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/session.php';
require_login();

$books = [];
$error = '';
$booksPerPage = 5;

try {
    require __DIR__ . '/includes/database.php';

    $bookCount = (int) $db->query('SELECT COUNT(*) FROM books')->fetchColumn();
    $pageCount = max(1, (int) ceil($bookCount / $booksPerPage));
    $requestedPage = (int) filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
    $page = min($pageCount, max(1, $requestedPage));
    $offset = ($page - 1) * $booksPerPage;

    $statement = $db->prepare(
        'SELECT books.book_title, books.author, categories.category_description, books.reserved
         FROM books
         JOIN categories ON categories.category_id = books.category_id
         ORDER BY books.book_title, books.isbn
         LIMIT ? OFFSET ?'
    );
    $statement->bindValue(1, $booksPerPage, PDO::PARAM_INT);
    $statement->bindValue(2, $offset, PDO::PARAM_INT);
    $statement->execute();
    $books = $statement->fetchAll();
} catch (PDOException $exception) {
    error_log($exception->getMessage());
    $error = 'The book list is temporarily unavailable.';
    http_response_code(503);
}

$pageTitle = 'Books';
require __DIR__ . '/includes/header.php';
?>
<section class="card card-wide">
    <h1>Books</h1>
    <?php if ($error !== ''): ?>
        <p class="error" role="alert"><?= escape($error) ?></p>
    <?php elseif ($books === []): ?>
        <p>No books in the catalogue.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($books as $book): ?>
                <li>
                    <strong><?= escape($book['book_title']) ?></strong>
                    by <?= escape($book['author']) ?><br>
                    <?= escape($book['category_description']) ?>
                    &middot; <?= $book['reserved'] === 'Y' ? 'Reserved' : 'Available' ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <?php if ($pageCount > 1): ?>
            <nav aria-label="Book list pages">
                <?php if ($page > 1): ?>
                    <a href="?page=<?= $page - 1 ?>">Previous</a>
                <?php endif; ?>
                <span>Page <?= $page ?> of <?= $pageCount ?></span>
                <?php if ($page < $pageCount): ?>
                    <a href="?page=<?= $page + 1 ?>">Next</a>
                <?php endif; ?>
            </nav>
        <?php endif; ?>
    <?php endif; ?>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
