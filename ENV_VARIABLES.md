# Environment Variables Guide

This guide explains each environment variable required for production deployment.

## Essential Variables (Required)

### APP_NAME
**Value:** `Life Planner`  
**Description:** Application name used in emails, headers, etc.  
**Example:** `APP_NAME=Life Planner`

### APP_ENV
**Value:** `production` (for live), `staging` (for testing)  
**Description:** Environment mode. Controls debug output, error logging, etc.  
**Example:** `APP_ENV=production`

### APP_DEBUG
**Value:** `false` (production), `true` (development only)  
**Description:** Shows detailed error messages. MUST be false in production!  
**Example:** `APP_DEBUG=false`

### APP_KEY
**Value:** Generated with `php artisan key:generate --show`  
**Description:** Encryption key for sensitive data. Must be unique per deployment.  
**How to generate:**
```bash
php artisan key:generate --show
# Output: base64:abc123def456ghi789jkl0mnopqr123stu456vwx=
```
**Example:** `APP_KEY=base64:abc123def456ghi789jkl0mnopqr123stu456vwx=`

### APP_URL
**Value:** Your actual application URL  
**Description:** Base URL for generating links in emails, redirects, etc.  
**Examples:**
- `APP_URL=https://lifeplanner.app`
- `APP_URL=https://app.example.com`
- `APP_URL=https://life-planner.railway.app`

---

## Database Variables (Required)

### DB_CONNECTION
**Value:** `pgsql` (PostgreSQL), `mysql` (MySQL), `sqlite` (SQLite)  
**Description:** Database system to use.  
**Recommended:** `pgsql` (PostgreSQL - most reliable for production)  
**Example:** `DB_CONNECTION=pgsql`

### DB_HOST
**Value:** Database hostname  
**Description:** Server address where database runs  
**Examples:**
- Railway/Heroku: Usually `localhost` or provided URL
- External: `db.example.com`
- Local: `127.0.0.1`

### DB_PORT
**Value:** Database port number  
**Description:** Port to connect to database  
**Examples:**
- PostgreSQL default: `5432`
- MySQL default: `3306`
- Example:** `DB_PORT=5432`

### DB_DATABASE
**Value:** Database name  
**Description:** Name of the actual database  
**Example:** `DB_DATABASE=life_planner_prod`

### DB_USERNAME
**Value:** Database user  
**Description:** Username to authenticate with database  
**Example:** `DB_USERNAME=postgres_user`

### DB_PASSWORD
**Value:** Database password  
**Description:** Password for database user  
**Security:** Use strong, random passwords. Never share or commit.  
**Example:** `DB_PASSWORD=sUperSecureP@ssw0rd123`

---

## Logging Variables

### LOG_CHANNEL
**Value:** `stack`, `single`, `daily`  
**Description:** How logs are stored  
**Recommended:** `stack` (aggregates multiple channels)  
**Example:** `LOG_CHANNEL=stack`

### LOG_STACK
**Value:** `single`, `daily`  
**Description:** Underlying log channels for stack  
**Example:** `LOG_STACK=single`

### LOG_LEVEL
**Value:** `debug`, `info`, `notice`, `warning`, `error`, `critical`  
**Description:** Minimum severity level to log  
**Recommended (Production):** `notice`  
**Example:** `LOG_LEVEL=notice`

---

## Cache & Session Variables

### CACHE_DRIVER
**Value:** `redis`, `memcached`, `database`, `array`, `file`  
**Description:** How application caches data  
**Recommended (Production):** `redis`  
**Example:** `CACHE_DRIVER=redis`

### SESSION_DRIVER
**Value:** `database`, `redis`, `file`, `cookie`  
**Description:** Where user sessions are stored  
**Recommended:** `database` (persistent)  
**Example:** `SESSION_DRIVER=database`

### SESSION_LIFETIME
**Value:** Minutes (default 120)  
**Description:** How long before sessions expire  
**Example:** `SESSION_LIFETIME=120`

### QUEUE_CONNECTION
**Value:** `sync`, `database`, `redis`, `sqs`  
**Description:** Queue driver for background jobs  
**For MVP:** `sync` (synchronous, no queue)  
**Example:** `QUEUE_CONNECTION=sync`

---

## Email Variables (Optional but Recommended)

### MAIL_MAILER
**Value:** `smtp`, `mailgun`, `sendgrid`, `ses`  
**Description:** Email service to use  
**Example:** `MAIL_MAILER=smtp`

### MAIL_HOST
**Value:** SMTP server hostname  
**Description:** Email server address  
**Examples:**
- Gmail: `smtp.gmail.com`
- Mailtrap: `smtp.mailtrap.io`
- SendGrid: `smtp.sendgrid.net`

### MAIL_PORT
**Value:** SMTP port  
**Description:** Email server port  
**Examples:**
- Standard: `587` (TLS)
- Secure: `465` (SSL)
- Mailtrap: `2525`

### MAIL_USERNAME
**Value:** Email account username  
**Description:** Username for SMTP authentication  
**Example:** `MAIL_USERNAME=your-email@gmail.com`

### MAIL_PASSWORD
**Value:** Email account password or app password  
**Description:** Password for SMTP authentication  
**Security:** Use app-specific passwords, never account password  
**Example:** `MAIL_PASSWORD=xxxx-xxxx-xxxx-xxxx`

### MAIL_ENCRYPTION
**Value:** `tls`, `ssl`, `null`  
**Description:** Encryption method for SMTP  
**Recommended:** `tls`  
**Example:** `MAIL_ENCRYPTION=tls`

### MAIL_FROM_ADDRESS
**Value:** Email address  
**Description:** Email address shown as "from" in emails  
**Example:** `MAIL_FROM_ADDRESS=noreply@lifeplanner.app`

### MAIL_FROM_NAME
**Value:** Display name  
**Description:** Name shown in "from" field of emails  
**Example:** `MAIL_FROM_NAME=Life Planner`

---

## File Storage Variables (For S3 uploads)

### FILESYSTEM_DISK
**Value:** `local`, `public`, `s3`  
**Description:** Default storage disk  
**For MVP:** `public`  
**Example:** `FILESYSTEM_DISK=public`

### AWS_ACCESS_KEY_ID
**Value:** AWS access key  
**Description:** Amazon Web Services credentials  
**Only if using S3 for storage**

### AWS_SECRET_ACCESS_KEY
**Value:** AWS secret key  
**Description:** Amazon Web Services credentials  
**Security:** Use IAM user, never root account

### AWS_DEFAULT_REGION
**Value:** AWS region  
**Example:** `AWS_DEFAULT_REGION=us-east-1`

### AWS_BUCKET
**Value:** S3 bucket name  
**Example:** `AWS_BUCKET=life-planner-uploads`

---

## Redis Variables (For Caching/Sessions)

### REDIS_HOST
**Value:** Redis server hostname  
**Description:** Where Redis runs  
**Example:** `REDIS_HOST=redis.example.com`

### REDIS_PASSWORD
**Value:** Redis password  
**Description:** Authentication password for Redis  
**Example:** `REDIS_PASSWORD=redis123`

### REDIS_PORT
**Value:** Redis port  
**Default:** `6379`  
**Example:** `REDIS_PORT=6379`

---

## Platform-Specific Variables

### For Railway

Railway provides automatic variables (don't set these):
- `DATABASE_URL` - Full PostgreSQL connection string
- `PORT` - Port to listen on
- `RAILWAY_ENVIRONMENT_NAME` - Environment name

You only need to set:
```
APP_NAME=Life Planner
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:...
APP_URL=https://your-domain.railway.app
LOG_LEVEL=notice
```

### For Heroku

Heroku sets:
- `DATABASE_URL` - PostgreSQL connection string
- `PORT` - Port to listen on

You set via:
```bash
heroku config:set APP_KEY=base64:...
heroku config:set APP_ENV=production
```

---

## How to Set Variables

### Railway

1. Go to Project → Service → Variables
2. Click "+ New Variable"
3. Enter Name and Value
4. Click Save
5. Redeploy if needed

### Heroku

```bash
# Set single variable
heroku config:set APP_KEY=base64:xxxxx

# Set multiple
heroku config:set \
  APP_ENV=production \
  APP_DEBUG=false \
  LOG_LEVEL=notice

# View all variables
heroku config

# View specific variable
heroku config:get APP_KEY

# Unset variable
heroku config:unset VAR_NAME
```

---

## Common Configuration Sets

### Minimal Production Setup
```
APP_NAME=Life Planner
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:YOUR_KEY
APP_URL=https://your-domain.com
DB_CONNECTION=pgsql
LOG_CHANNEL=stack
LOG_LEVEL=notice
SESSION_DRIVER=database
CACHE_DRIVER=redis
QUEUE_CONNECTION=sync
```

### Full Production Setup
```
# Application
APP_NAME=Life Planner
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:YOUR_KEY
APP_URL=https://your-domain.com

# Database
DB_CONNECTION=pgsql
DB_HOST=your-host
DB_PORT=5432
DB_DATABASE=life_planner
DB_USERNAME=postgres
DB_PASSWORD=strong-password

# Logging
LOG_CHANNEL=stack
LOG_STACK=single
LOG_LEVEL=notice

# Cache & Session
SESSION_DRIVER=database
CACHE_DRIVER=redis
QUEUE_CONNECTION=sync

# Email
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@lifeplanner.app
MAIL_FROM_NAME=Life Planner
```

### Development Setup
```
APP_NAME=Life Planner
APP_ENV=local
APP_DEBUG=true
APP_KEY=base64:local-key
APP_URL=http://localhost:8000
DB_CONNECTION=sqlite
LOG_CHANNEL=stack
LOG_LEVEL=debug
```

---

## Security Best Practices

1. **Never commit `.env` files** to Git
2. **Use strong passwords** (20+ characters, mixed case, numbers, symbols)
3. **Keep secrets secret** - use platform's secret management
4. **Rotate credentials** regularly
5. **Use separate credentials** for each environment
6. **Enable 2FA** on provider accounts
7. **Audit access logs** regularly
8. **Document variable purposes** for your team

---

## Troubleshooting

### "APP_KEY is not set"
```bash
# Generate APP_KEY
php artisan key:generate --show

# Copy output and set in production
heroku config:set APP_KEY=base64:...
```

### Database Connection Error
```bash
# Check DATABASE_URL or individual DB_* variables
heroku config | grep DATABASE

# Verify credentials
psql postgresql://user:pass@host:5432/database
```

### Email Not Sending
```bash
# Test email configuration
php artisan tinker
>>> Mail::raw('Test', function($m) { $m->to('test@example.com'); })->send();
```

### Cache Not Working
```bash
# Check CACHE_DRIVER is set
heroku config:get CACHE_DRIVER

# Clear cache
heroku run php artisan cache:clear
```

---

## Environment Variable Template

Copy and customize this template:

```
APP_NAME=Life Planner
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:GENERATE_WITH_php_artisan_key:generate
APP_URL=https://YOUR_DOMAIN_HERE

LOG_CHANNEL=stack
LOG_STACK=single
LOG_LEVEL=notice

DB_CONNECTION=pgsql
DB_HOST=YOUR_DB_HOST
DB_PORT=5432
DB_DATABASE=YOUR_DB_NAME
DB_USERNAME=YOUR_DB_USER
DB_PASSWORD=YOUR_DB_PASSWORD

SESSION_DRIVER=database
CACHE_DRIVER=redis
QUEUE_CONNECTION=sync

MAIL_MAILER=smtp
MAIL_HOST=YOUR_MAIL_HOST
MAIL_PORT=587
MAIL_USERNAME=YOUR_MAIL_USER
MAIL_PASSWORD=YOUR_MAIL_PASSWORD
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@YOUR_DOMAIN
MAIL_FROM_NAME=Life Planner
```

---

**Last Updated:** December 29, 2025  
**Status:** Complete
