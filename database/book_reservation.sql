-- Book reservation database for Web Development 2.
-- Import once into a fresh database through phpMyAdmin.
-- Demo logins from the assignment (passwords are stored as bcrypt hashes):
--   alanjmckenna / t1234s
--   joecrotty    / kj7899
--   tommy100    / 123456
-- Sample-data normalization: each nine-digit mobile from the brief is prefixed with 0.
-- Clipped addresses and author names use the visible text without the [clipped] marker.

CREATE DATABASE IF NOT EXISTS book_reservation
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE book_reservation;

CREATE TABLE users (
    username VARCHAR(50) PRIMARY KEY,
    password VARCHAR(255) NOT NULL,
    first_name VARCHAR(60) NOT NULL,
    surname VARCHAR(60) NOT NULL,
    address_line_1 VARCHAR(120) NOT NULL,
    address_line_2 VARCHAR(120) NOT NULL,
    city VARCHAR(60) NOT NULL,
    telephone VARCHAR(20) NOT NULL,
    mobile CHAR(10) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE categories (
    category_id CHAR(3) PRIMARY KEY,
    category_description VARCHAR(60) NOT NULL
) ENGINE=InnoDB;

-- ISBN and category IDs are text so leading zeros are preserved.
CREATE TABLE books (
    isbn VARCHAR(20) PRIMARY KEY,
    book_title VARCHAR(200) NOT NULL,
    author VARCHAR(120) NOT NULL,
    edition SMALLINT UNSIGNED NOT NULL,
    publication_year SMALLINT UNSIGNED NOT NULL,
    category_id CHAR(3) NOT NULL,
    reserved ENUM('N', 'Y') NOT NULL DEFAULT 'N',
    FOREIGN KEY (category_id) REFERENCES categories (category_id)
) ENGINE=InnoDB;

-- ISBN is the primary key, so a book can have only one active reservation.
CREATE TABLE reservations (
    isbn VARCHAR(20) PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    reserved_date DATE NOT NULL,
    FOREIGN KEY (isbn) REFERENCES books (isbn),
    FOREIGN KEY (username) REFERENCES users (username)
) ENGINE=InnoDB;

-- Keep the Reserved column from the assignment in sync with Reservations.
-- The PHP code can add or delete a reservation without updating Books itself.
CREATE TRIGGER reservations_after_insert
AFTER INSERT ON reservations
FOR EACH ROW
    UPDATE books SET reserved = 'Y' WHERE isbn = NEW.isbn;

CREATE TRIGGER reservations_after_delete
AFTER DELETE ON reservations
FOR EACH ROW
    UPDATE books SET reserved = 'N' WHERE isbn = OLD.isbn;

CREATE TRIGGER reservations_after_update
AFTER UPDATE ON reservations
FOR EACH ROW
    UPDATE books
    SET reserved = CASE WHEN isbn = NEW.isbn THEN 'Y' ELSE 'N' END
    WHERE isbn IN (OLD.isbn, NEW.isbn);

START TRANSACTION;

INSERT INTO users
    (username, password, first_name, surname, address_line_1, address_line_2, city, telephone, mobile)
VALUES
    ('alanjmckenna', '$2y$10$rx3JOUrA8JhLICqGr.4YOuoNf1ptXiIQPH8iaM7mD2LAWtd.qrOse', 'Alan', 'McKenna', '38 Cranley Roa', 'Fairview', 'Dublin', '9998377', '0856625567'),
    ('joecrotty', '$2y$10$XJsRYtgD.b0f5EPurYIt0u9K1HP.EM9NqnVVdhSuzYw6JPIt2orMO', 'Joseph', 'Crotty', 'Apt 5 Clyde Ro', 'Donnybrook', 'Dublin', '8887889', '0876654456'),
    ('tommy100', '$2y$10$MZ/bzJIP0mbs9XnrvyG/Oe5etbqPMutK9/Or0Jt2lpH2SdMJ8O9f.', 'tom', 'behan', '14 hyde road', 'dalkey', 'dublin', '9983747', '0876738782');

INSERT INTO categories (category_id, category_description) VALUES
    ('001', 'Health'),
    ('002', 'Business'),
    ('003', 'Biography'),
    ('004', 'Technology'),
    ('005', 'Travel'),
    ('006', 'Self-Help'),
    ('007', 'Cookery'),
    ('008', 'Fiction');

INSERT INTO books
    (isbn, book_title, author, edition, publication_year, category_id)
VALUES
    ('093-403992', 'Computers in Business', 'Alicia Oneill', 3, 1997, '003'),
    ('23472-8729', 'Exploring Peru', 'Stephanie Birchi', 4, 2005, '005'),
    ('237-34823', 'Business Strategy', 'Joe Peppard', 2, 2002, '002'),
    ('23u8-923849', 'A guide to nutrition', 'John Thorpe', 2, 1997, '001'),
    ('2983-3494', 'Cooking for children', 'Anabelle Sharpe', 1, 2003, '007'),
    ('82n8-308', 'computers for idiots', 'Susan O''Neill', 5, 1998, '004'),
    ('9823-23984', 'My life in picture', 'Kevin Graham', 8, 2004, '001'),
    ('9823-2403-0', 'DaVinci Code', 'Dan Brown', 1, 2003, '008'),
    ('98234-029384', 'My ranch in Texas', 'George Bush', 1, 2005, '001'),
    ('9823-98345', 'How to cook Italian food', 'Jamie Oliver', 2, 2005, '007'),
    ('9823-98487', 'Optimising your business', 'Cleo Blair', 1, 2001, '002'),
    ('988745-234', 'Tara Road', 'Maeve Binchy', 4, 2002, '008'),
    ('993-004-00', 'My life in bits', 'John Smith', 1, 2001, '001'),
    ('9987-0039882', 'Shooting History', 'Jon Snow', 1, 2003, '001');

INSERT INTO reservations (isbn, username, reserved_date) VALUES
    ('98234-029384', 'joecrotty', '2008-10-11'),
    ('9823-98345', 'tommy100', '2008-10-11');

COMMIT;
