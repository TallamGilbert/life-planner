# Pre-Production Checklist

Complete this checklist before deploying to production.

## Code Quality

- [ ] No syntax errors: `php artisan tinker`
- [ ] All tests pass: `php artisan test`
- [ ] Code formatted: `php artisan pint`
- [ ] No debug statements in code
- [ ] No TODO comments in critical files
- [ ] All branches merged to main
- [ ] Changelog updated

## Security

- [ ] APP_DEBUG set to false
- [ ] APP_KEY generated and unique
- [ ] All user inputs validated
- [ ] SQL injection prevention (using Eloquent)
- [ ] CSRF tokens on all forms
- [ ] Password hashing used (bcrypt)
- [ ] Environment variables not in `.env` file
- [ ] Sensitive files not in Git
- [ ] Rate limiting configured (if needed)
- [ ] File uploads validated

## Database

- [ ] Migrations tested locally
- [ ] Database backups planned
- [ ] Foreign key constraints enabled
- [ ] Indexes created on large tables
- [ ] Database size acceptable
- [ ] No test data in production
- [ ] Connection pooling configured (if needed)

## Environment

- [ ] `.env.production` created with all required variables
- [ ] APP_KEY generated: `php artisan key:generate --show`
- [ ] APP_URL matches actual domain
- [ ] Database credentials secured
- [ ] Email credentials configured (if using email)
- [ ] File storage configured
- [ ] Redis configured (if using cache/session)
- [ ] AWS credentials (if using S3)

## Application Configuration

- [ ] All routes tested
- [ ] Authentication system working
- [ ] Authorization checks in place
- [ ] Profile picture upload working
- [ ] Expense CRUD operations work
- [ ] Habit tracking works
- [ ] Meal planning works
- [ ] Bill management works
- [ ] Admin panel accessible
- [ ] Activity logging works

## Performance

- [ ] Database queries optimized
- [ ] N+1 queries eliminated (eager loading)
- [ ] Indexes created
- [ ] Cache configured
- [ ] Static assets minified
- [ ] Images optimized
- [ ] Middleware ordered correctly
- [ ] No unnecessary loops

## Files & Assets

- [ ] `Procfile` created
- [ ] `Dockerfile` created (for Docker deployments)
- [ ] `.dockerignore` created
- [ ] `.railway.json` created (for Railway)
- [ ] `.env.production` created
- [ ] Frontend assets built: `npm run build`
- [ ] Storage link created: `php artisan storage:link`

## Deployment Platform Setup

### Railway
- [ ] GitHub account connected
- [ ] Repository authorized
- [ ] PostgreSQL database created
- [ ] Environment variables configured
- [ ] Procfile recognized
- [ ] Health check endpoint working

### Heroku
- [ ] Heroku CLI installed
- [ ] Account created and verified
- [ ] App created
- [ ] PostgreSQL add-on added
- [ ] Environment variables set
- [ ] Procfile present

## Post-Deployment

- [ ] Application loads without errors
- [ ] Health check passes: `/up`
- [ ] Login page renders
- [ ] Can register new user
- [ ] Can login with credentials
- [ ] Profile picture upload works
- [ ] Can create/edit/delete expenses
- [ ] Can create/edit/delete habits
- [ ] Can plan meals
- [ ] Can manage bills
- [ ] Admin panel accessible
- [ ] Activity logs captured
- [ ] Database migrations completed
- [ ] No 500 errors in logs
- [ ] Page load times acceptable
- [ ] Images display correctly

## Monitoring & Backup

- [ ] Error logs configured
- [ ] Database backups scheduled
- [ ] Application monitoring enabled
- [ ] Alert notifications set up
- [ ] Uptime monitoring enabled
- [ ] Daily backup verification
- [ ] Rollback plan documented

## Documentation

- [ ] DEPLOYMENT.md reviewed
- [ ] QUICK_DEPLOY.md reviewed
- [ ] Environment variables documented
- [ ] Database schema documented
- [ ] API endpoints documented
- [ ] Troubleshooting guide available
- [ ] Team members trained

## Domain & SSL

- [ ] Domain registered
- [ ] DNS records configured
- [ ] SSL certificate issued
- [ ] HTTPS working
- [ ] HTTP redirects to HTTPS
- [ ] Mixed content warnings eliminated

## Rollback Plan

- [ ] Previous version tagged in Git
- [ ] Database backup taken
- [ ] Rollback procedure documented
- [ ] Team knows how to rollback
- [ ] Rollback time estimated

## Go-Live Decision

- [ ] All checklist items completed
- [ ] Team approval obtained
- [ ] Stakeholders notified
- [ ] Support team trained
- [ ] Go-live window scheduled
- [ ] Monitoring tools ready

---

## Sign-Off

**Checked By:** _____________________ **Date:** ___________

**Approved By:** _____________________ **Date:** ___________

**Deployed By:** _____________________ **Date:** ___________

---

## Notes

```

```

---

**Created:** December 29, 2025  
**Version:** 1.0
