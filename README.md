# Wintrip 1 — Wintrip Safaris website

Wintrip 1 retains its approved Travelix-inspired visual identity and now includes a PHP/MySQL backend for destination information, trip enquiries and newsletter subscriptions.

## Technology stack
- Frontend: HTML5, CSS3 and vanilla JavaScript
- Backend: PHP 8+ with PDO
- Database: MySQL 5.7.8+/8.0 (InnoDB, utf8mb4; JSON column support recommended)
- Hosting: Apache/PHP hosting such as Hostinger Business

This project is no longer a frontend-only Vercel prototype. Vercel's static hosting does not execute these PHP endpoints. Deploy the complete project to PHP/MySQL hosting (or configure a separate PHP backend).

## Features
- Responsive Wintrip-1 homepage, hero carousel, trip search and destination region filters.
- Individual destination pages at `destination.html?destination=maasai-mara` with descriptions, imagery, region information, highlights, best time to visit and visitor guidance.
- Destination directory served from MySQL through `api/destinations.php`; built-in destination content remains as a frontend preview fallback.
- Enquiry form posts to `api/enquiries.php`, validates input server-side and stores submissions in MySQL.
- If the PHP enquiry endpoint cannot be reached, the form opens the visitor's email application with the enquiry details addressed to wintripsafarishelp@gmail.com.
- Newsletter form validates email addresses in the browser and server, stores subscriptions in MySQL and handles duplicate addresses with a friendly response.
- Responsive navigation and compact purple header with white logo treatment.

## Local setup
1. Install PHP 8+ with PDO MySQL and a MySQL server.
2. Create a database and import `database/schema.sql`.
3. Copy `api/config.example.php` to `api/config.php`.
4. Set the database host, database name, username and password in `api/config.php`.
5. From the project root run `php -S localhost:8000` and open `http://localhost:8000`.

## Hostinger deployment
1. Upload the repository contents into `public_html` (or the domain's document root).
2. Create a MySQL database and database user in hPanel.
3. Import `database/schema.sql` into that database using phpMyAdmin.
4. Copy `api/config.example.php` to `api/config.php` and add the credentials from hPanel. Do not commit `api/config.php`.
5. Ensure PHP 8+ and PDO MySQL are enabled.
6. Test `/api/destinations.php`, submit an enquiry and subscribe a test email.
7. Confirm the company's official contact details and destination content before launch.

## API endpoints
- `GET api/destinations.php` — list active destinations.
- `GET api/destinations.php?destination=maasai-mara` — fetch one destination by slug or name.
- `POST api/enquiries.php` — JSON body: `name`, `email`, optional `destination`, optional `travel_date` (YYYY-MM-DD), and `message`.
- `POST api/newsletter.php` — JSON body: `email`.

## Security and production notes
- `api/config.php` contains secrets and must remain untracked. Restrict direct access to configuration files at the web-server level.
- The API uses PDO prepared statements and server-side validation. Add rate limiting or CAPTCHA/honeypot protection before a public launch.
- Destination visa and entry requirements can change. The visitor guidance is general information, not legal or immigration advice; verify requirements with official sources.
- Confirm the company phone number, email and social links before publishing.
- Use only images owned, licensed or otherwise authorized for Wintrip Safaris.
