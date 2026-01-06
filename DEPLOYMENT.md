# Life Planner - Deployment Guide

Complete guide for deploying Life Planner to Railway, Heroku, or other platforms.

## Table of Contents

1. [Quick Start](#quick-start)
2. [Railway Deployment](#railway-deployment)
3. [Heroku Deployment](#heroku-deployment)
4. [Environment Variables](#environment-variables)
5. [Database Setup](#database-setup)
6. [Post-Deployment](#post-deployment)
7. [Troubleshooting](#troubleshooting)

---

## Quick Start

### Prerequisites
- Git account (GitHub, GitLab, Bitbucket)
- Application pushed to remote repository
- All changes committed and pushed

### Choose Your Platform
- **Railway** (Recommended) - Simple, affordable, full Laravel support
- **Heroku** - Well-known, free tier available
- **DigitalOcean App Platform** - More control, affordable
- **Render** - Modern, good performance

---

## Railway Deployment

### Step 1: Prepare Your Repository

```bash
# Ensure all changes are committed
cd /home/belion/Desktop/life-planner
git add .
git commit -m "Prepare for deployment"
git push origin main
```

### Step 2: Connect to Railway

1. Visit [railway.app](https://railway.app)
2. Click "Start New Project"
3. Select "Deploy from GitHub"
4. Authorize Railway with your GitHub account
5. Select `life-planner` repository
6. Railway automatically detects it's a Laravel app

### Step 3: Add PostgreSQL Database

1. In Railway dashboard, click "+ New Service"
2. Select "PostgreSQL"
3. Railway automatically sets `DATABASE_URL` environment variable
4. No additional configuration needed!

### Step 4: Configure Environment Variables

In Railway dashboard, go to Variables tab:

```
APP_NAME=Life Planner
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:YOUR_APP_KEY_HERE (generate below)
APP_URL=https://your-app-domain.railway.app

DB_CONNECTION=pgsql
CACHE_DRIVER=redis
SESSION_DRIVER=database
QUEUE_CONNECTION=sync

LOG_CHANNEL=stack
LOG_LEVEL=notice
```

### Step 5: Generate APP_KEY

```bash
# Generate locally and copy the output
php artisan key:generate --show
# Output: base64:xxxxxxxxxxxxx
```

Copy the output and paste in Railway's APP_KEY variable.

### Step 6: Deploy

Railway automatically deploys when you push to GitHub:

```bash
git push origin main
```

Watch the deployment logs in Railway dashboard.

### Step 7: Verify Deployment

```bash
# Railway provides a URL like:
# https://life-planner-production.railway.app

# Check if app is running
curl https://your-app-url.railway.app/up
# Should return: OK
```

---

## Heroku Deployment

### Step 1: Install Heroku CLI

```bash
# macOS
brew tap heroku/brew && brew install heroku

# Linux
curl https://cli-assets.heroku.com/install.sh | sh

# Windows
# Download from https://devcenter.heroku.com/articles/heroku-cli
```

### Step 2: Login to Heroku

```bash
heroku login
```

### Step 3: Create Heroku App

```bash
# Create app with unique name
heroku create life-planner-app

# Or use existing app
heroku apps
```

### Step 4: Add PostgreSQL Database

```bash
# Add PostgreSQL add-on
heroku addons:create heroku-postgresql:essential-0
```

### Step 5: Set Environment Variables

```bash
heroku config:set APP_ENV=production
heroku config:set APP_DEBUG=false
heroku config:set LOG_CHANNEL=stack

# Generate APP_KEY locally
php artisan key:generate --show
# Copy the base64:xxxxx output

heroku config:set APP_KEY=base64:xxxxxxxxxxxxx
```

### Step 6: Configure App URL

```bash
# Get your Heroku URL
heroku apps:info -a life-planner-app

# Set APP_URL (from output above)
heroku config:set APP_URL=https://life-planner-app.herokuapp.com
```

### Step 7: Deploy

```bash
# Push to Heroku
git push heroku main

# View logs
heroku logs --tail
```

### Step 8: Run Migrations

```bash
# Automatically runs via Procfile release command
# Or manually:
heroku run php artisan migrate --force
```

### Step 9: Verify

```bash
# Open app in browser
heroku open

# Or check health endpoint
curl https://life-planner-app.herokuapp.com/up
```

---

## Environment Variables

### Essential Variables

```
APP_NAME=Life Planner
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:xxxxxxxxxxxxx (REQUIRED - generate locally)
APP_URL=https://your-domain.com (REQUIRED - set to actual domain)
```

### Database Variables

Railway & Heroku automatically set `DATABASE_URL`, but you can also set individually:

```
DB_CONNECTION=pgsql
DB_HOST=your-host
DB_PORT=5432
DB_DATABASE=database_name
DB_USERNAME=username
DB_PASSWORD=password
```

### Cache & Session

```
CACHE_DRIVER=redis
SESSION_DRIVER=database
QUEUE_CONNECTION=sync
```

### Logging

```
LOG_CHANNEL=stack
LOG_STACK=single
LOG_LEVEL=notice
```

### Email (Optional)

```
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-username
MAIL_PASSWORD=your-password
MAIL_FROM_ADDRESS=noreply@lifeplanner.app
MAIL_FROM_NAME=Life Planner
```

---

## Database Setup

### PostgreSQL Configuration

Life Planner uses PostgreSQL in production (configured in `.env.production`).

#### Initial Setup

```bash
# Migrations run automatically via Procfile release command
# Or manually:
heroku run php artisan migrate --force

# Seed demo data (optional)
heroku run php artisan db:seed --force
```

#### Database Backup

**Railway:**
```bash
# Railway automatically backs up PostgreSQL
# Access in dashboard under "Backups" tab
```

**Heroku:**
```bash
# Create backup
heroku pg:backups:capture

# Download backup
heroku pg:backups:download

# Restore backup
heroku pg:backups:restore b001 DATABASE_URL
```

#### Database Commands

```bash
# View database info
heroku pg:info

# Connect to database
heroku pg:psql

# Reset database (CAREFUL!)
heroku pg:reset
```

---

## Post-Deployment

### 1. Verify Application

```bash
# Check health endpoint
curl https://your-app.railway.app/up
# Should return: OK

# Check logs for errors
heroku logs --tail
```

### 2. Test Key Features

- [ ] Visit login page (without errors)
- [ ] Register new account
- [ ] Login with new account
- [ ] Upload profile picture
- [ ] Add expense/habit/meal
- [ ] View analytics dashboard
- [ ] Admin access (if applicable)

### 3. Custom Domain Setup

#### Railway

1. Go to Settings tab
2. Click "Add Custom Domain"
3. Enter your domain (e.g., lifeplanner.app)
4. Update DNS records with provided values
5. Wait for SSL certificate (usually 10 minutes)

#### Heroku

```bash
# Add domain
heroku domains:add www.lifeplanner.app

# View DNS target
heroku domains

# Update DNS provider with CNAME record
```

### 4. SSL/HTTPS

- Railway: Automatic (Let's Encrypt)
- Heroku: Automatic for `*.herokuapp.com`, custom domains need Paid Dynos

### 5. Monitoring

**Railway Dashboard:**
- Metrics tab shows CPU, Memory, Network
- Logs tab for application logs
- Deployments tab for history

**Heroku:**
```bash
# View metrics
heroku metrics

# View logs in real-time
heroku logs --tail --source app

# View logs from specific time
heroku logs --dyno web.1 --num 50
```

---

## Troubleshooting

### Common Issues

#### 1. Migration Fails on Deploy

```bash
# Check for syntax errors
php artisan migrate --dry-run

# Manual migration
heroku run php artisan migrate --force

# View migration history
heroku run php artisan migrate:status
```

#### 2. APP_KEY Not Set

```bash
# Generate locally
php artisan key:generate --show

# Set on platform
heroku config:set APP_KEY=base64:xxxxx
```

#### 3. 500 Error on Visit

```bash
# View logs
heroku logs --tail

# Check storage permissions
heroku run chmod -R 775 storage bootstrap/cache

# Clear cache
heroku run php artisan config:clear
heroku run php artisan cache:clear
```

#### 4. Profile Pictures Not Uploading

```bash
# Check storage link
heroku run php artisan storage:link

# Fix permissions
heroku run chmod -R 775 storage/app/public
```

#### 5. Database Connection Error

```bash
# Check connection
heroku pg:psql

# View connection variables
heroku config | grep DATABASE

# Test connection
heroku run php artisan db
```

#### 6. Out of Memory

**Railway:**
- Upgrade to higher tier in Plan settings
- Reduce build artifacts in Dockerfile

**Heroku:**
- Upgrade dyno type
- Enable Memory optimization

#### 7. Build Fails

```bash
# View build log
heroku builds

# Rebuild
heroku builds:cancel
git push heroku main

# Force clean build
git commit --allow-empty -m "Rebuild"
git push heroku main
```

### Debug Mode

```bash
# Temporarily enable debug
heroku config:set APP_DEBUG=true

# View detailed errors
heroku logs --tail --source app

# Disable debug (IMPORTANT!)
heroku config:set APP_DEBUG=false
```

### Performance Optimization

```bash
# Clear cache
heroku run php artisan config:clear
heroku run php artisan cache:clear
heroku run php artisan view:clear

# Optimize autoloader
heroku run composer install --optimize-autoloader --no-dev

# Compile routes
heroku run php artisan route:cache
```

---

## Advanced Configuration

### Custom Buildpack

For Heroku, if auto-detection fails:

```bash
heroku buildpacks:set heroku/php
```

### Scaling

**Railway:**
- Automatic horizontal scaling based on resource usage
- Configure in Plan settings

**Heroku:**
```bash
# Scale dynos (web processes)
heroku ps:scale web=2

# View scaling info
heroku ps
```

### Environment-Specific Config

For staging environment:

```bash
# Create staging app
heroku create life-planner-staging

# Set specific variables
heroku config:set APP_ENV=staging -a life-planner-staging
```

### Continuous Deployment

Both platforms support automatic deployment from GitHub:

1. Connect GitHub repository
2. Select branch to auto-deploy (e.g., `main`)
3. Enable "Wait for CI to pass"
4. Every push to `main` deploys automatically

---

## Security Checklist

- [ ] APP_DEBUG=false in production
- [ ] APP_KEY set and unique
- [ ] Database credentials strong and unique
- [ ] HTTPS enabled (automatic on both platforms)
- [ ] Email configuration complete
- [ ] File upload paths secured
- [ ] Session driver set to database
- [ ] Regular backups enabled
- [ ] Monitor logs for errors
- [ ] Keep dependencies updated

---

## Updating Deployed App

### Push New Changes

```bash
# Commit changes locally
git add .
git commit -m "Update features"

# Push to GitHub (Railway/Heroku auto-deploy)
git push origin main

# Or push directly to Heroku
git push heroku main
```

### Update Dependencies

```bash
# Update composer packages
composer update

# Update npm packages
npm update

# Commit and push
git add composer.lock package-lock.json
git commit -m "Update dependencies"
git push origin main
```

### Run Commands in Production

**Railway:**
- Click Service → Console
- Run command (e.g., `php artisan migrate`)

**Heroku:**
```bash
heroku run php artisan command:name
```

---

## Support & Resources

- **Laravel Deployment:** https://laravel.com/docs/deployment
- **Railway Docs:** https://docs.railway.app
- **Heroku Docs:** https://devcenter.heroku.com
- **PostgreSQL:** https://www.postgresql.org/docs

---

## Quick Reference

### Railway
```bash
# Clone and push to GitHub
git push origin main

# Connect to Railway
# → Select GitHub repo
# → Auto-deploy enabled

# Set environment variables in Railway dashboard
# → Database auto-created
# → Migrations auto-run
```

### Heroku
```bash
# Install CLI: brew install heroku
# Login: heroku login
# Create app: heroku create app-name
# Add DB: heroku addons:create heroku-postgresql:essential-0
# Set vars: heroku config:set VAR=value
# Deploy: git push heroku main
# View logs: heroku logs --tail
```

---

**Last Updated:** December 29, 2025  
**Status:** Production Ready
