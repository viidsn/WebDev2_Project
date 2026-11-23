# Book Reservation

A coursework project for a library book reservation website built with PHP, HTML, CSS and MySQL. The current version includes the database, registration and sign-in.

## Project structure

- Database schema and sample data ([book_reservation.sql](database/book_reservation.sql))
- Website requirements and source data ([PROJECT_BRIEF.md](docs/PROJECT_BRIEF.md))
- Original assignment ([assignment2026.docx](docs/assignment2026.docx))
- Application pages in the project root, including [login.php](login.php) and [register.php](register.php)
- Shared PHP files in `includes/` and styles in `assets/`

## Import the database in XAMPP

1. Start Apache and MySQL from the XAMPP control panel.
2. Open [phpMyAdmin](http://localhost/phpmyadmin/) and select the **Import** tab at the server level.
3. Select [database/book_reservation.sql](database/book_reservation.sql) and run the import. The script creates the `book_reservation` database and loads the sample data. The import requires a database without any existing project tables. If those tables already exist, back up your data before reimporting.
4. Open `book_reservation` and check the table counts. A fresh import should contain 3 rows in `users`, 8 in `categories`, 14 in `books` and 2 in `reservations`.

## Run the application in XAMPP

Once the database is imported and both services are running, open [Book Reservation on localhost](http://localhost/WebDev2_Project/). The connection defaults to the local XAMPP MySQL server and the `book_reservation` database. If your connection settings differ, set `BOOK_DB_HOST`, `BOOK_DB_NAME`, `BOOK_DB_USER` and `BOOK_DB_PASSWORD` in the PHP environment as needed.

Sign in with the sample account `tommy100` and password `123456`, or create a new account. Open the home page again to check that the session keeps you signed in. Sign out and verify that opening the home page sends you back to sign-in.

## Work plan

1. Prepare and import the database.
2. Build registration, sign-in and sign-out with a shared layout and a protected home page.
3. Add partial title and author search, a database-backed category filter and pagination with up to five results per page.
4. Add reservations with a date, prevent duplicate bookings and let users view and cancel their own reservations.
5. Use AI to refine the design and usability, and document the changes for the demonstration.
6. Test the complete workflow in XAMPP, then assemble the PDF with page descriptions, source listings, screenshots of each screen and the design document.

The next implementation step is catalogue search and pagination.
