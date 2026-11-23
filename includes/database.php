<?php

declare(strict_types=1);

$host = getenv('BOOK_DB_HOST') ?: 'localhost';
$databaseName = getenv('BOOK_DB_NAME') ?: 'book_reservation';
$databaseUser = getenv('BOOK_DB_USER') ?: 'root';
$databasePassword = (string) getenv('BOOK_DB_PASSWORD');

$db = new PDO(
    "mysql:host=$host;dbname=$databaseName;charset=utf8mb4",
    $databaseUser,
    $databasePassword,
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]
);
