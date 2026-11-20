# Web Development Book Reservation Website

This brief transcribes and organises the requirements of [assignment2026.docx](assignment2026.docx), including the database screenshots. The original Word document remains the source for resolving transcription uncertainty.

## Aim

Develop a book reservation website using PHP, a MySQL database and artificial intelligence. Users must be able to search for library books, reserve available books and view their own reservations.

## Required functionality

### Login

- Users must identify themselves to use the system.
- Their identity must be maintained throughout the site.
- New users must register their details before using the system.

### Registration

- Allow a user to enter their registration details.
- Validate that all details are entered.
- Mobile phone numbers must be numeric and exactly 10 characters long.
- Passwords must be exactly six characters long.
- Include password confirmation.
- Each user must have a unique username.

### Search for a book

- Search by title and/or author, supporting partial matches in both fields.
- Search by category description using a dropdown menu.
- Retrieve the category options from the database.
- Display results as a list from which available books can be reserved.
- Prevent users from reserving books that are already reserved.
- Display no more than five rows of search results per page.
- Provide pagination so results can span multiple pages.

### Reserve a book

- Allow a user to reserve a book only if nobody else has reserved it.
- Record the date of the reservation.

### View and remove reservations

- Display the books currently reserved by the logged-in user.
- Allow that user to remove their reservations.

## Technology and other requirements

- Implement all required functionality using raw PHP and HTML.
- Then integrate an AI tool of your choice to improve the website's design, usability and overall professionalism, providing a polished and user-friendly experience.
- Create or duplicate the database supplied in the assignment. Additional data may be added as needed.
- Use a common header and footer throughout the application.
- Avoid hard-coding in the programs.
- Include appropriate error checking.
- Fully test all code. The examiner will not debug code that fails to compile or run, or does not function as required.

## Database from the assignment

The database has four tables. Some column headings and values are cut off in the screenshots. The labels below expand headings where their meaning is clear. A value ending in `[clipped]` records only the visible text, without guessing its ending. The empty new-record rows in the screenshots are excluded.

### Users

Stores registration and password details. Each user is uniquely identified by their username.

| Username | Password | FirstName | Surname | AddressLine1 | AddressLine2 | City | Telephone | Mobile |
| --- | --- | --- | --- | --- | --- | --- | --- | --- |
| alanjmckenna | t1234s | Alan | McKenna | 38 Cranley Roa [clipped] | Fairview | Dublin | 9998377 | 856625567 |
| joecrotty | kj7899 | Joseph | Crotty | Apt 5 Clyde Ro [clipped] | Donnybrook | Dublin | 8887889 | 876654456 |
| tommy100 | 123456 | tom | behan | 14 hyde road | dalkey | dublin | 9983747 | 876738782 |

The screenshot shows nine digits in each Mobile value, whereas the registration requirement specifies ten. Preserve this discrepancy when reviewing the source and document any data normalisation used in the implementation.

### Books

Stores book details, indexed by ISBN. The category code links to Categories. The screenshot includes a Reserved field with values `N` and `Y`.

| ISBN | BookTitle | Author | Edition | Year | Category | Reserved |
| --- | --- | --- | --- | --- | --- | --- |
| 093-403992 | Computers in Business | Alicia Oneill | 3 | 1997 | 003 | N |
| 23472-8729 | Exploring Peru | Stephanie Birchi [clipped] | 4 | 2005 | 005 | N |
| 237-34823 | Business Strategy | Joe Peppard | 2 | 2002 | 002 | N |
| 23u8-923849 | A guide to nutrition | John Thorpe | 2 | 1997 | 001 | N |
| 2983-3494 | Cooking for children | Anabelle Sharpe | 1 | 2003 | 007 | N |
| 82n8-308 | computers for idiots | Susan O'Neill | 5 | 1998 | 004 | N |
| 9823-23984 | My life in picture | Kevin Graham | 8 | 2004 | 001 | N |
| 9823-2403-0 | DaVinci Code | Dan Brown | 1 | 2003 | 008 | N |
| 98234-029384 | My ranch in Texas | George Bush | 1 | 2005 | 001 | Y |
| 9823-98345 | How to cook Italian food | Jamie Oliver | 2 | 2005 | 007 | Y |
| 9823-98487 | Optimising your business | Cleo Blair | 1 | 2001 | 002 | N |
| 988745-234 | Tara Road | Maeve Binchy | 4 | 2002 | 008 | N |
| 993-004-00 | My life in bits | John Smith | 1 | 2001 | 001 | N |
| 9987-0039882 | Shooting History | Jon Snow | 1 | 2003 | 001 | N |

### Categories

Stores category descriptions and links to Books through the category code.

| CategoryID | CategoryDescription |
| --- | --- |
| 001 | Health |
| 002 | Business |
| 003 | Biography |
| 004 | Technology |
| 005 | Travel |
| 006 | Self-Help |
| 007 | Cookery |
| 008 | Fiction |

### Reservations

Called Reserved Books in the assignment prose and Reservations in its screenshot. Links to Books by ISBN and Users by username.

| ISBN | Username | ReservedDate |
| --- | --- | --- |
| 98234-029384 | joecrotty | 11-Oct-2008 |
| 9823-98345 | tommy100 | 11-Oct-2008 |

## Marking

The assignment carries 70 marks, accounting for 70% of the Web Development continuous assessment mark. The source prints the following allocations as percentages, which total 70%.

| Criterion | Allocation as printed |
| --- | --- |
| Completeness of functionality | 30% |
| Documentation | 5% |
| Improvement by AI | 15% |
| Technical implementation | 20% |

## Deadline and demonstration

- Deadline in the assignment is 4 December at 9am. Demonstrations start at 9am.
- The assignment filename identifies the year as 2026. This project uses 4 December 2026 at 09:00, Europe/Dublin, as the working deadline.
- Demonstrate the program in the lab.

## Submission through Brightspace

Submit electronically on or before the deadline. The required PDF must include all of the following.

- A list of the application's PHP pages, with a textual description of what each page does and how it interacts with the other pages.
- A listing of the source code, including `.php` and `.html` files.
- A sample screenshot of every application screen.
- A design document. The brief does not specify its structure or length.

## Assignment regulations and penalties

This is an individual assignment.

1. Failure to submit the assignment or demonstrate it in the lab results in no marks for that element of the assessment.
2. Submission after the deadline but within one working week results in a 50% reduction of marks.
3. Submission more than one working week after the deadline results in no marks.
4. Plagiarised assessment components result in zero marks for all parties involved.

The source allows exceptions to the penalties in exceptional circumstances.
