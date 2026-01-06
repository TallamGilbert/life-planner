# Quick Deployment Reference

## 30-Second Railway Deploy

```bash
# 1. Prepare code
git add .
git commit -m "Ready for production"
git push origin main

# 2. Go to railway.app and click "Start New Project"
# 3. Select "Deploy from GitHub"
# 4. Choose your repository
# 5. Click "+ New" → PostgreSQL
# 6. Add variables in Variables tab (see below)
# 7. Deploy! 

# Variables to add:
# APP_NAME=Life Planner
# APP_ENV=production
# APP_DEBUG=false
# APP_KEY=base64:YOUR_KEY_HERE (run: php artisan key:generate --show)
# APP_URL=https://your-domain.railway.app
```

## Generate APP_KEY

```bash
# Run locally and copy output
php artisan key:generate --show

# Example output:
# base64:abc123def456ghi789jkl0mnopqr123stu456vwx=

# Use this value in APP_KEY variable
```

## Post-Deploy Checklist

- [ ] Visit your app URL
- [ ] Test login/register
- [ ] Test profile picture upload
- [ ] Test adding expense
- [ ] Check admin panel
- [ ] Verify database is working
- [ ] Check logs for errors
- [ ] Set custom domain (optional)

## Heroku 30-Second Deploy

```bash
# 1. Install CLI
brew install heroku

# 2. Login
heroku login

# 3. Create app
heroku create life-planner-app

# 4. Add database
heroku addons:create heroku-postgresql:essential-0

# 5. Set APP_KEY
heroku config:set APP_KEY=base64:YOUR_KEY_HERE

# 6. Set APP_URL
heroku config:set APP_URL=https://life-planner-app.herokuapp.com

# 7. Deploy
git push heroku main

# 8. View logs
heroku logs --tail
```

## Emergency Rollback

### Railway
```bash
# Go to Deployments tab
# Click three dots on previous deployment
# Select "Rollback"
```

### Heroku
```bash
# View deployment history
heroku releases

# Rollback to previous release
heroku releases:rollback v123
```

## Common Commands

### View Logs
```bash
# Railway (in Console tab)
# Heroku
heroku logs --tail

# Last 50 lines
heroku logs -n 50

# Specific dyno
heroku logs --dyno web.1 --tail
```

### Run Commands
```bash
# Railway
# Click Service → Console → Type command

# Heroku
heroku run php artisan migrate
heroku run php artisan cache:clear
heroku run php artisan db:seed
```

### Set Variables
```bash
# Railway
# Dashboard → Variables tab

# Heroku
heroku config:set VAR_NAME=value
heroku config:get VAR_NAME
heroku config
```

### Database Access
```bash
# Railway
# Dashboard → Data tab

# Heroku
heroku pg:psql
```

## Troubleshooting

### App Won't Start
```bash
# Check logs
heroku logs --tail

# Check if migrations ran
heroku run php artisan migrate:status

# Clear cache
heroku run php artisan config:clear
```

### 500 Error
```bash
# Enable debug temporarily
heroku config:set APP_DEBUG=true

# Check logs
heroku logs --tail

# Disable debug
heroku config:set APP_DEBUG=false
```

### Database Error
```bash
# Check connection
heroku pg:psql

# View credentials
heroku config | grep DATABASE

# Reset database (CAREFUL!)
heroku pg:reset
heroku run php artisan migrate --force
```

### Out of Memory
```bash
# Check memory usage
heroku metrics

# Upgrade dyno
heroku ps:type standard-1x
```

## Cost Comparison

| Platform | Free | Paid Starting | Features |
|----------|------|---|---|
| Railway | $5 credit/mo | $7/mo | Full Laravel, Auto-scaling |
| Heroku | None | $7/mo | Simple, Well-known |
| DigitalOcean | $5 trial | $5/mo | More control, Droplets |
| Render | Free tier | $5/mo | Modern, Good perf |

## Environment Variables Quick Copy

```bash
# Add these to your platform's environment variables

APP_NAME=Life Planner
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:GENERATE_LOCALLY
APP_URL=https://your-domain.com
LOG_CHANNEL=stack
LOG_LEVEL=notice
DB_CONNECTION=pgsql
CACHE_DRIVER=redis
SESSION_DRIVER=database
QUEUE_CONNECTION=sync
```

## Custom Domain Setup

### Railway
1. Settings → Domains → Add Domain
2. Follow DNS instructions
3. Wait for SSL (10 minutes)

### Heroku
1. `heroku domains:add www.yoursite.com`
2. Update DNS with provided CNAME
3. Wait for verification

## Need Help?

1. Check logs first
2. Review DEPLOYMENT.md
3. Check Laravel docs: laravel.com/docs
4. Platform docs: railway.app or heroku.com

---

**Status:** Ready for Production  
**Created:** December 29, 2025
