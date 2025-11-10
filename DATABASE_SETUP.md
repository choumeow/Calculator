# Database Setup Guide for Calculator2 Project

## Step 1: Create Database in phpMyAdmin

1. **Open phpMyAdmin** in your web browser (usually at `http://localhost/phpmyadmin`)

2. **Login** with your MySQL credentials (usually username: `root`, password: your MySQL password)

3. **Click on "New" or "Databases"** tab in the left sidebar

4. **Create a new database:**
   - Database name: `calculator2` (or your preferred name)
   - Collation: `utf8mb4_unicode_ci` (recommended)
   - Click "Create" button

5. **Verify the database** appears in the left sidebar

## Step 2: Configure Laravel .env File

1. **Check if `.env` file exists** in your project root directory
   - If it doesn't exist, copy `.env.example` to `.env`:
     ```bash
     copy .env.example .env
     ```
   - Or create a new `.env` file

2. **Update the following database variables** in your `.env` file:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=calculator2
DB_USERNAME=root
DB_PASSWORD=your_mysql_password
```

**Replace:**
- `calculator2` with your actual database name (if different)
- `root` with your MySQL username (if different)
- `your_mysql_password` with your actual MySQL password

## Step 3: Run Migrations

After setting up the database and `.env` file, run:

```bash
php artisan migrate
```

This will create all the necessary tables in your MySQL database.

## Troubleshooting

- **Connection refused**: Make sure MySQL/MariaDB service is running
- **Access denied**: Verify your MySQL username and password in `.env`
- **Database doesn't exist**: Make sure you created the database in phpMyAdmin first
- **PDO Exception**: Ensure PHP MySQL extension is installed (`php -m | grep pdo_mysql`)





