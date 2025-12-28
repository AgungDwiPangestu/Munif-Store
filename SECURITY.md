# Security Policy

## 🔒 Security Best Practices

### Before Going to Production

1. **Change Default Credentials**

   - Default admin password is `admin123`
   - **IMMEDIATELY** change this after installation
   - Use strong passwords (min 12 characters, mix of letters, numbers, symbols)

2. **Database Configuration**

   - Never commit `config/db.php` to version control
   - Use strong database passwords
   - Limit database user permissions (don't use root in production)
   - Consider using separate database users for read/write operations

3. **Remove Development Files**

   - Delete `reset_admin_password.php` after use
   - Remove `install.php` after initial setup
   - Delete any test/debug files
   - Remove auto-commit scripts

4. **File Permissions**

   ```bash
   # Set proper permissions
   chmod 644 *.php
   chmod 755 admin/ pages/ api/
   chmod 755 assets/images/books/
   ```

5. **PHP Configuration**

   - Set `display_errors = Off` in production
   - Enable `error_logging`
   - Set appropriate `upload_max_filesize`
   - Configure `session` settings properly

6. **HTTPS**
   - Always use HTTPS in production
   - Never transmit passwords over HTTP
   - Use SSL certificates (Let's Encrypt is free)

### Input Validation

The application uses several security measures:

- SQL injection prevention using parameterized queries
- XSS prevention using `htmlspecialchars()`
- Password hashing using `password_hash()`
- Session management
- File upload validation

### Reporting a Vulnerability

If you discover a security vulnerability, please email:

- **Email**: security@yourdomain.com (replace with your email)
- **Do NOT** create a public GitHub issue

Please include:

- Description of the vulnerability
- Steps to reproduce
- Potential impact
- Suggested fix (if any)

We will respond within 48 hours and work on a fix.

## 🛡️ Known Security Considerations

### Session Security

- Sessions are stored on the server
- Session timeout is browser-dependent
- Consider implementing session timeout mechanism

### Password Storage

- Passwords are hashed using `password_hash()` (bcrypt)
- Never store plain-text passwords
- Password reset requires secure token generation

### File Uploads

- Only image files are allowed for book covers
- File size is limited
- Files are validated before upload
- Consider adding virus scanning for production

### SQL Injection

- Most queries use string interpolation (needs improvement)
- **TODO**: Migrate to prepared statements for all queries
- Never trust user input

### XSS Prevention

- User input is escaped where displayed
- **TODO**: Implement Content Security Policy (CSP)
- Sanitize all user inputs

## 🚨 Security Checklist for Production

- [ ] Changed default admin password
- [ ] Removed `install.php`
- [ ] Removed `reset_admin_password.php`
- [ ] Configured proper file permissions
- [ ] Enabled HTTPS
- [ ] Set PHP `display_errors = Off`
- [ ] Configured error logging
- [ ] Set strong database password
- [ ] Limited database user permissions
- [ ] Configured session timeout
- [ ] Set up regular backups
- [ ] Configured firewall rules
- [ ] Implemented rate limiting (if needed)
- [ ] Set up monitoring and alerts

## 📚 Additional Resources

- [OWASP Top 10](https://owasp.org/www-project-top-ten/)
- [PHP Security Best Practices](https://www.php.net/manual/en/security.php)
- [MySQL Security Guidelines](https://dev.mysql.com/doc/refman/8.0/en/security-guidelines.html)

---

**Remember**: Security is an ongoing process, not a one-time task. Stay updated with security best practices and keep your dependencies up to date.
