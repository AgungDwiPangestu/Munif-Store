# Configuration Guide

## Database Configuration

### Setup

1. Copy the example configuration file:

   ```bash
   cp config/db.example.php config/db.php
   ```

2. Edit `config/db.php` with your database credentials:
   ```php
   define('DB_HOST', 'localhost');    // Your database host
   define('DB_USER', 'root');         // Your database username
   define('DB_PASS', '');             // Your database password
   define('DB_NAME', 'apguns_store'); // Database name
   ```

### Security Notes

⚠️ **IMPORTANT**:

- **NEVER** commit `config/db.php` to version control
- The `.gitignore` file already excludes this file
- Only `config/db.example.php` should be in the repository
- Each developer should create their own `config/db.php` locally

### Different Environments

#### Development

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'apguns_store');
```

#### Production (Example)

```php
define('DB_HOST', 'your-production-host.com');
define('DB_USER', 'your_production_user');
define('DB_PASS', 'your_strong_password');
define('DB_NAME', 'apguns_store_production');
```

## Uploaded Files

The `assets/images/books/` directory stores book cover images:

- This directory is ignored in `.gitignore` (except default images)
- Images are uploaded by users/admins
- Make sure this directory is writable by the web server

### Permissions (Linux/Mac)

```bash
chmod 755 assets/images/books/
```

## Security Files

These files should **NEVER** be in production or repository:

- `reset_admin_password.php` - Password reset utility
- `FIX_DATABASE_NOW.php` - Database fix tool
- `check_database.php` - Database checker
- `test.php` - Testing files
- `debug.php` - Debug files

These are automatically ignored by `.gitignore`.

## First Time Setup

1. Clone the repository
2. Copy `config/db.example.php` to `config/db.php`
3. Configure database credentials in `config/db.php`
4. Run the installer: `http://localhost/ApGuns-Store/install.php`
5. Login with default credentials (admin/admin123)
6. **Change the admin password immediately!**

## Troubleshooting

### Config file not found

If you get "config/db.php not found" error:

```bash
cp config/db.example.php config/db.php
```

### Database connection failed

- Check your credentials in `config/db.php`
- Make sure MySQL is running
- Verify database name exists
- Check user permissions

### Permission errors

- Make sure web server has read access to all files
- Make sure `assets/images/books/` is writable
