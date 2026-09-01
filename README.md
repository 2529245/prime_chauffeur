# Prime Chauffeur — Localhost Setup (XAMPP)

GitHub Repository: https://github.com/2529245/prime_chauffeur/

Follow these steps after cloning the GitHub repository or extracting the project ZIP.

## Required

- XAMPP
- Composer
- PHP 8.0.2 or compatible
- `prime_chauffeur.sql` in the main project folder

## Steps

1. Extract the project to `C:\xampp\htdocs\prime_chauffeur`.
2. Start **Apache** and **MySQL** from XAMPP.
3. Open Command Prompt in the project folder.
4. Run `composer install`.
5. If `.env` is missing, run `copy .env.example .env`.
6. Run `php artisan key:generate`.
7. Open `.env` and configure:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=prime_chauffeur
DB_USERNAME=root
DB_PASSWORD=
```

8. Open `http://localhost/phpmyadmin`.
9. Create a database named `prime_chauffeur`.
10. Select the database → **Import** → choose `prime_chauffeur.sql` from the main project folder → **Go**.
11. Run `php artisan config:clear`.
12. Run `php artisan serve`.
13. Open `http://127.0.0.1:8000`.

## Admin Login

- Email: `admin@admin.com`
- Password: `Admin123`

## Alternative Database Setup

Instead of importing `prime_chauffeur.sql`, you can create an empty `prime_chauffeur` database and run:

```bash
php artisan migrate --seed
```

Or, if migrations already exist:

```bash
php artisan db:seed
```

Use only one database setup method.
