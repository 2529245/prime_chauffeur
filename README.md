# Prime Chauffeur — Localhost Setup (XAMPP)

GitHub Repository: https://github.com/2529245/prime_chauffeur/

Follow these steps after cloning the GitHub repository or extracting the project ZIP.

## Required

- XAMPP
- Composer
- PHP 8.0.2 or compatible
- `prime_chauffeur.sql` in the main project folder

## Steps

1. Extract the project to:

   ```text
   C:\xampp\htdocs\prime_chauffeur
   ```

2. Start **Apache** and **MySQL** from the XAMPP Control Panel.

3. Open Command Prompt in the project folder:

   ```bash
   cd C:\xampp\htdocs\prime_chauffeur
   ```

4. Install the project dependencies:

   ```bash
   composer install
   ```

5. If `.env` is missing, create it from `.env.example`:

   ```bash
   copy .env.example .env
   ```

6. If you created a new `.env` file in Step 5, generate the Laravel application key:

   ```bash
   php artisan key:generate
   ```

   If `.env` already exists and contains a valid `APP_KEY`, skip this step and do not generate a new key.

7. Open `.env` and check/configure the database settings:

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=prime_chauffeur
   DB_USERNAME=root
   DB_PASSWORD=
   ```

   The settings above use the common default XAMPP MySQL username and blank password. If your local MySQL configuration is different, update `DB_USERNAME` and `DB_PASSWORD` accordingly.

8. Open phpMyAdmin:

   ```text
   http://localhost/phpmyadmin
   ```

9. Create a new database named:

   ```text
   prime_chauffeur
   ```

10. Select the `prime_chauffeur` database → click **Import** → choose `prime_chauffeur.sql` from the main project folder → click **Go**.

11. Clear the Laravel configuration cache:

   ```bash
   php artisan config:clear
   ```

12. Start the Laravel application:

   ```bash
   php artisan serve
   ```

13. Open the application in your browser:

   ```text
   http://127.0.0.1:8000
   ```

## Admin Login

Use the following credentials for assessment/demo access:

- **Email:** `admin@admin.com`
- **Password:** `Admin123`

## Alternative Database Setup

Instead of importing `prime_chauffeur.sql`, you can create an empty database named `prime_chauffeur` and use Laravel migrations and seeders.

Make sure the database details in `.env` are configured correctly, then run:

```bash
php artisan migrate --seed
```

This will run the database migrations and populate the database using the project seeders.

If the migrations have already been run and you only need to run the seeders, use:

```bash
php artisan db:seed
```

> **Important:** Use only one database setup method:
>
> - Import `prime_chauffeur.sql`, **or**
> - Run Laravel migrations and seeders.
>
> You do not need to do both.
