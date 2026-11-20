# Book Reservation

A coursework project for a library book reservation website built with PHP, HTML, CSS and MySQL. The assignment calls for users to be able to search by title, author or category, reserve available books and cancel their own reservations. The database schema and sample data are ready.

## Project structure

- Database schema and sample data ([book_reservation.sql](database/book_reservation.sql))
- Website requirements and source data ([PROJECT_BRIEF.md](docs/PROJECT_BRIEF.md))
- Original assignment ([assignment2026.docx](docs/assignment2026.docx))

## Import the database in XAMPP

1. Start Apache and MySQL from the XAMPP control panel.
2. Open [phpMyAdmin](http://localhost/phpmyadmin/) and select the **Import** tab at the server level.
3. Select [database/book_reservation.sql](database/book_reservation.sql) and run the import. The script creates the `book_reservation` database and loads the sample data. The import requires a database without any existing project tables. If those tables already exist, back up your data before reimporting.
4. Open `book_reservation` and check the table counts. A fresh import should contain 3 rows in `users`, 8 in `categories`, 14 in `books` and 2 in `reservations`.

## Next step

Add a shared database connection file, implement registration and login in PHP, and verify that the PHP session keeps users signed in as they navigate between pages.
