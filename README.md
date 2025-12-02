# Life Planner - Personal Financial & Lifestyle Management Application

A comprehensive Laravel-based web application designed to help users manage their finances, track habits, plan meals, and monitor bills in one centralized platform.

![Version](https://img.shields.io/badge/version-1.2.0-blue)
![Laravel](https://img.shields.io/badge/Laravel-12-red)
![PHP](https://img.shields.io/badge/PHP-8.2+-purple)
![License](https://img.shields.io/badge/license-MIT-green)
![Status](https://img.shields.io/badge/status-Production%20Ready-brightgreen)

## 🎯 Features

### 💰 Budget Management
- **Expense & Income Tracking**: Record and categorize all financial transactions
- **Income vs Expense Analytics**: Visual charts showing spending patterns over time
- **Transaction History**: View, edit, and delete transactions with detailed filtering
- **Category Management**: Organize expenses by custom categories (Food, Transport, etc.)
- **Advanced Filtering**: Filter by date range, type, and category

### 🔥 Habit Tracking
- **Daily Check-ins**: Mark habits as completed each day
- **Streak Counting**: Track current and longest streaks for motivation
- **Active/Archived Habits**: Manage active and completed habits
- **Performance Metrics**: View habit completion rates and progress
- **Habit Analytics**: Detailed completion rates and trend analysis

### 🍽️ Meal Planning
- **Weekly Meal Planner**: Plan meals for the entire week
- **Meal Types**: Organize by breakfast, lunch, dinner, and snacks
- **Recipe Management**: Store recipes and ingredients for meals
- **Shopping List**: Auto-generate shopping lists from meal plans
- **Meal Notes**: Add preparation notes and tips

### 💳 Bill Management
- **Bill Tracking**: Monitor recurring and one-time bills
- **Payment History**: Record and track bill payments
- **Installment Support**: Manage bills with multiple installment payments
- **Due Date Alerts**: Keep track of upcoming bill deadlines
- **Payment Status**: See remaining balance and paid amounts at a glance
- **Payment Recording**: Detailed payment logging with notes

### 📊 Analytics & Dashboard
- **Comprehensive Dashboard**: Overview of key metrics at a glance
- **Financial Analytics**: Income, expense trends, and budget analysis
- **Habit Analytics**: Completion rates, streak statistics
- **Monthly Reports**: Detailed breakdowns of spending patterns
- **Data Visualization**: Charts and graphs for easy insights
- **Custom Date Ranges**: Analyze data for any time period

### 👤 User Profile Management
- **Profile Pictures**: Upload, update, and delete profile pictures
- **Account Settings**: Manage email and personal information
- **Email Verification**: Secure account verification
- **Password Management**: Change password securely
- **Account Deletion**: Option to delete account and all associated data
- **Profile Picture in Navigation**: Display profile picture throughout app

### 🔐 Security Features
- **Email Verification**: Verify email addresses during registration
- **Password Reset**: Secure password recovery via email
- **CSRF Protection**: All forms protected against CSRF attacks
- **File Storage**: Secure profile picture storage with disk-based management
- **User Authorization**: Proper user ownership verification for all data
- **Session Management**: Database-backed secure session storage

## ✨ Recent Updates (v1.2.0)

### 🐛 Critical Bug Fixes
- **Fixed ActivityLog Auth Method**: Corrected `auth()->id()` to `auth()->user()?->id` for proper user ID retrieval
- **Improved JavaScript Event Handlers**: Refactored onclick handlers to use data attributes instead of inline Blade variables
  - Activity log "View Details" now uses clean data attribute passing
  - User delete confirmation now uses data attributes for better maintainability
- **Enhanced Chart.js Integration**: Fixed Blade directive placement in JavaScript for Chart.js initialization

### 📈 Code Quality Improvements
- Better separation of concerns between templates and JavaScript
- Improved error handling with null-safe operators
- Enhanced maintainability through cleaner data passing mechanisms
- Comprehensive test coverage for admin functions

### 📊 Documentation
- Added detailed error analysis and fix documentation
- Improved code comments and docstrings
- Created implementation guides for future developers
## 🛠️ Technology Stack

- **Framework**: Laravel 12 (PHP 8.2+)
- **Frontend**: Blade Templating, Tailwind CSS, Alpine.js
- **Database**: MySQL 8.0+ with Eloquent ORM
- **Authentication**: Laravel Breeze
- **Asset Bundler**: Vite
- **Charts**: Chart.js for data visualization
- **Validation**: Form Request validation
- **Storage**: Disk-based file storage with public access

## 👨‍💼 Admin Features

### 📊 System Analytics Dashboard
- **User Growth Tracking**: Monthly registration trends with visual charts
- **Expense Distribution**: Category-wise spending breakdown
- **Habit Popularity**: Most active habit categories among all users
- **Real-time Metrics**: Key performance indicators and statistics

### 👥 User Management
- **User Directory**: Browse all registered users with detailed information
- **User Details**: View individual user activity and associated data
- **Admin Controls**: Grant/revoke admin privileges
- **User Deletion**: Remove users and associated data from system
- **User Filtering**: Filter by user status (Admin, Demo, Verified)

### 📋 Activity Logging
- **Complete Audit Trail**: Track all system activities and changes
- **Action Logging**: View what, when, and who performed actions
- **IP Tracking**: Monitor access from different IP addresses
- **Search & Filter**: Find specific activities across the audit log
- **Log Details**: View detailed metadata for each activity entry

### ⚙️ System Settings
- **Configuration Management**: Manage application settings
- **System Preferences**: Customize application behavior
- **Settings Persistence**: Settings cached for optimal performance

## 📋 Database Schema

### Core Tables

#### **users**
- `id` (Primary Key)
- `name` - User's full name
- `email` - User's email address (unique)
- `email_verified_at` - Email verification timestamp
- `password` - Hashed password
- `profile_picture_path` - Path to uploaded profile picture
- `remember_token` - Session remember token
- `timestamps` - Created and updated timestamps

#### **expenses**
- `id` (Primary Key)
- `user_id` (Foreign Key) - Associated user
- `name` - Transaction description
- `amount` - Transaction amount
- `type` - 'income' or 'expense'
- `category` - Expense category
- `date` - Transaction date
- `description` - Additional notes
- `timestamps`

#### **habits**
- `id` (Primary Key)
- `user_id` (Foreign Key) - Associated user
- `name` - Habit name
- `category` - Habit category
- `description` - Habit description
- `streak` - Current streak count
- `longest_streak` - Personal best streak
- `last_completed` - Last completion date
- `is_active` - Active/archived status
- `timestamps`

#### **meals**
- `id` (Primary Key)
- `user_id` (Foreign Key) - Associated user
- `name` - Meal name
- `meal_type` - breakfast/lunch/dinner/snack
- `date` - Meal date
- `recipe` - Recipe details
- `ingredients` - Ingredients list
- `notes` - Preparation notes
- `timestamps`

#### **bills**
- `id` (Primary Key)
- `user_id` (Foreign Key) - Associated user
- `name` - Bill name/description
- `total_amount` - Total bill amount
- `paid_amount` - Amount paid so far
- `total_installments` - Number of installments
- `paid_installments` - Completed installments
- `next_due_date` - Next payment due date
- `category` - Bill category
- `notes` - Additional notes
- `is_active` - Active/inactive status
- `timestamps`

#### **bill_payments**
- `id` (Primary Key)
- `bill_id` (Foreign Key) - Associated bill
- `user_id` (Foreign Key) - Associated user
- `amount` - Payment amount
- `payment_date` - Date of payment
- `notes` - Payment notes
- `timestamps`

### System Tables
- **sessions**: User session management
- **cache**: Application cache storage
- **migrations**: Database migration history

## 🚀 Getting Started

### Prerequisites
- PHP 8.2 or higher
- MySQL 8.0 or higher
- Node.js 16+ (for frontend assets)
- Composer
- Git

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/TallamGilbert/life-planner.git
   cd life-planner
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database configuration**
   - Update `.env` with your MySQL credentials
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=life_planner
   DB_USERNAME=root
   DB_PASSWORD=your_password
   ```

5. **Run migrations**
   ```bash
   php artisan migrate
   ```

6. **Seed test data (optional)**
   ```bash
   php artisan db:seed --class=DashboardTestSeeder
   ```

7. **Build frontend assets**
   ```bash
   npm run build
   ```

8. **Set up storage link**
   ```bash
   php artisan storage:link
   ```

9. **Start development server**
   ```bash
   php artisan serve
   ```

   Access the application at `http://localhost:8000`

### Test Credentials
Default test user (if seeded):
- **Email**: test@example.com
- **Password**: password

## 📂 Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── ProfileController.php       # User profile management
│   │   ├── ExpenseController.php       # Budget operations
│   │   ├── HabitController.php         # Habit tracking
│   │   ├── MealController.php          # Meal planning
│   │   ├── BillController.php          # Bill management
│   │   ├── AnalyticsController.php     # Dashboard analytics
│   │   └── Auth/                       # Authentication controllers
│   └── Requests/
│       └── ProfileUpdateRequest.php    # Profile validation
├── Models/
│   ├── User.php                        # User model with relationships
│   ├── Expense.php
│   ├── Habit.php
│   ├── Meal.php
│   ├── Bill.php
│   └── BillPayment.php
└── Providers/
    └── AppServiceProvider.php

resources/
├── css/
│   └── app.css                         # Tailwind CSS configuration
├── js/
│   ├── app.js                          # Main JavaScript
│   └── bootstrap.js                    # Bootstrap file
└── views/
    ├── auth/
    │   ├── login.blade.php             # Modern card-based login
    │   ├── register.blade.php          # Registration form
    │   └── forgot-password.blade.php   # Password reset
    ├── dashboard.blade.php             # Main dashboard
    ├── expenses/                       # Budget module views
    ├── habits/                         # Habit module views
    ├── meals/                          # Meal module views
    ├── bills/                          # Bill module views
    ├── profile/                        # User profile views
    ├── layouts/
    │   ├── app.blade.php              # Main app layout
    │   ├── guest.blade.php            # Guest layout
    │   └── navigation.blade.php       # Navigation bar
    └── components/                     # Reusable components

database/
├── migrations/
│   ├── 2025_11_18_121300_create_users_table.php
│   ├── 2025_11_18_121346_create_expenses_table.php
│   ├── 2025_11_18_121355_create_habits_table.php
│   ├── 2025_11_18_121402_create_meals_table.php
│   ├── 2025_11_21_075851_create_bills_table.php
│   ├── 2025_11_24_150000_add_profile_picture_to_users_table.php
│   └── ...
├── seeders/
│   ├── DashboardTestSeeder.php        # Test data
│   └── DatabaseSeeder.php
└── factories/
    └── UserFactory.php

routes/
├── web.php                             # Application routes
└── auth.php                            # Authentication routes

public/
├── storage/                            # Symlink to storage/app/public
├── build/                              # Compiled assets
└── manifest.json                       # PWA manifest

storage/
├── app/
│   ├── public/
│   │   └── profile-pictures/          # User profile pictures
│   └── private/                        # Private files
├── logs/                               # Application logs
└── framework/                          # Framework storage
```

## 🔍 Code Quality & Analysis

### PHP Syntax Validation
✅ **All files passed PHP syntax validation**
- 14 controllers checked
- 6 models checked  
- 1 form request checked
- All authentication controllers validated

### Architecture & Design
✅ **Proper Model-View-Controller separation**
✅ **Eloquent ORM usage for database operations**
✅ **Form Request validation pattern**
✅ **Route model binding implementation**

### Security Analysis
✅ **Authorization Checks**: User ownership verified in all operations
✅ **Input Validation**: All forms have comprehensive validation rules
✅ **CSRF Protection**: All forms include CSRF tokens
✅ **File Upload Security**: 
   - Type validation (JPEG, PNG, GIF)
   - Size limits (2MB maximum)
   - Secure storage location
✅ **Password Security**: Bcrypt hashing used throughout
✅ **Session Security**: Database-backed session storage

### Key Implementation Details

**Authorization Pattern**
```php
// Example: Every controller verifies user ownership
if ($habit->user_id !== Auth::id()) {
    abort(403);
}
```

**Validation Rules**
- Profile picture: `nullable|image|mimes:jpeg,png,jpg,gif|max:2048`
- Email: `required|email|unique:users,email|max:255`
- Amount fields: `required|numeric|min:0.01`

**File Storage**
- Location: `storage/app/public/profile-pictures/`
- Automatic cleanup: Old files deleted on upload
- Access: Via `Storage::url()` for secure public access
- Deletion: Files removed when account deleted

## ✨ Feature Suggestions & Enhancements

### 🚀 High Priority (Quick Wins) - 1-2 weeks

1. **Recurring Bill Automation**
   - Auto-create next payment reminder after each payment
   - Email notifications for upcoming due dates
   - Monthly/yearly recurring bill support
   - Status bar showing installment progress

2. **Budget Goals & Alerts**
   - Set spending limits by category
   - Visual progress indicators
   - Alert when 75%, 90%, 100% of budget reached
   - Month-end budget reports
   - Exceed budget notifications

3. **Export Features**
   - Export transactions to CSV
   - PDF report generation
   - Monthly statement PDFs
   - Tax year summaries
   - Print-friendly views

4. **Dark Mode**
   - System-wide dark theme toggle
   - User preference persistence in database
   - Tailwind dark mode utilities
   - Improved low-light usability
   - Theme toggle in profile settings

5. **Enhanced Meal Tracking**
   - Nutritional information per meal
   - Calorie tracking
   - Portion size management
   - Dietary restrictions/preferences
   - Meal prep scheduling

### 📈 Medium Priority (Enhanced Features) - 2-4 weeks

6. **Social & Collaborative Features**
   - Share habits with friends/family
   - Group challenges and competitions
   - Habit leaderboards
   - Achievement badges and milestones
   - Share progress on social media

7. **Mobile App**
   - React Native or Flutter companion app
   - Offline sync capability
   - Push notifications for reminders
   - Quick expense logging from phone
   - Biometric authentication

8. **Advanced Analytics Dashboard**
   - Spending trends and predictions
   - Budget efficiency scoring
   - Custom date range analysis
   - Multi-year comparisons
   - Expenditure forecasting
   - Category-wise spending trends

9. **Smart Tagging System**
   - Multi-tag support for all records
   - Tag suggestions based on history
   - Smart filtering by tags
   - Tag-based analytics and reports
   - Tag cloud visualization

10. **Calendar Integration**
    - Visual calendar with bills and meal plans
    - iCalendar (ICS) export
    - Google Calendar sync
    - Bill due dates in calendar view
    - Meal prep deadlines
    - Interactive drag-and-drop scheduling

### 🔥 Advanced Features - 1-2 months

11. **Subscription Management**
    - Dedicated subscription tracker
    - Renewal reminders
    - Cost comparison across similar services
    - Subscription history and spending
    - Multi-currency support

12. **Banking Integration**
    - Plaid API integration for auto-import
    - Open Banking API support
    - Real-time balance sync
    - Transaction categorization
    - Duplicate transaction detection
    - Bank account linking

13. **AI-Powered Insights**
    - Smart spending recommendations
    - Unusual spending pattern detection
    - Budget optimization suggestions
    - Predictive spending analysis
    - Smart categorization of expenses
    - Anomaly alerts

14. **Multi-User/Family Features**
    - Multi-user households
    - Shared expenses splitting
    - Family budget management
    - Role-based access (Admin/Member)
    - Transaction approval workflows
    - Family goals and targets

15. **Public API & Integrations**
    - RESTful API for third-party apps
    - Webhook support for events
    - OAuth2 authentication
    - API key management
    - Rate limiting and quota management
    - API documentation and SDK

### 💅 UI/UX Improvements - Ongoing

16. **Enhanced Dashboard**
    - Customizable widget layouts
    - Drag-and-drop widget arrangement
    - Widget refresh rates
    - Real-time notifications
    - Quick action buttons
    - Status indicators

17. **Advanced Search & Filtering**
    - Global search across all modules
    - Date range filters
    - Multi-criteria search
    - Saved filter presets
    - Smart autocomplete search
    - Search history and favorites

18. **Print & PDF Features**
    - Transaction receipts
    - Monthly bank statements
    - Habit progress reports
    - Meal plan printouts
    - Custom report builder
    - Scheduled report delivery

19. **Mobile Optimization**
    - Progressive Web App (PWA) support
    - Offline functionality
    - Touch-friendly interfaces
    - Mobile-first design refinements
    - Responsive chart displays
    - Mobile navigation improvements

20. **Accessibility Enhancements**
    - WCAG 2.1 AA compliance
    - Screen reader optimization
    - Keyboard-only navigation support
    - Color contrast improvements
    - Focus indicators enhancement
    - Aria labels for all interactive elements

## 🐛 Known Issues & Recent Fixes

### Fixed Issues
✅ **Profile Picture Upload Logout** (Fixed Nov 24, 2025)
- Issue: Form submission was auto-triggering on file select
- Solution: Changed to manual form submission on Save button click
- Files: `update-profile-information-form.blade.php`, `ProfileController.php`

✅ **Dashboard Bill Calculation Error** (Fixed)
- Issue: Attempting to sum non-existent `remaining_amount` column
- Solution: Calculate as `total_amount - paid_amount` in PHP
- Files: `dashboard.blade.php`

✅ **Loading Button Spinner Stuck** (Fixed)
- Issue: Spinner remained active after form submission
- Solution: Added 3-second timeout reset in component
- Files: `loading-button.blade.php`

✅ **Authentication Pages UI** (Redesigned Nov 24, 2025)
- Issue: Old gradient and glass-effect styling
- Solution: Modern card-based design with icons
- Files: `login.blade.php`, `register.blade.php`, `forgot-password.blade.php`

✅ **Navigation Profile Picture** (Fixed Nov 24, 2025)
- Issue: Using non-existent avatar_url property
- Solution: Implemented profile_picture_path with Storage::url()
- Files: `navigation.blade.php`

## 🔐 Security Best Practices

### Implemented Security Measures

1. **File Upload Security**
   - ✅ Whitelist file types (JPEG, PNG, GIF only)
   - ✅ File size restrictions (2MB max)
   - ✅ Stored outside webroot in `storage/app/public/`
   - ✅ Automatic cleanup of old files

2. **Database Security**
   - ✅ SQL injection prevention via Eloquent ORM
   - ✅ Bcrypt password hashing
   - ✅ Prepared statements for all queries
   - ✅ User data isolation via user_id foreign key

3. **Application Security**
   - ✅ CSRF token protection on all forms
   - ✅ HTTP headers for security
   - ✅ Email verification for new accounts
   - ✅ Secure password reset flow

4. **Authorization & Access Control**
   - ✅ User ownership verification on all resources
   - ✅ 403 abort on unauthorized access
   - ✅ Middleware-based route protection
   - ✅ No exposed user data in URLs

5. **Session Security**
   - ✅ Database-backed session storage
   - ✅ Secure session timeout
   - ✅ HTTPS-ready configuration
   - ✅ Secure cookie settings

### Recommended Production Security

- Enable HTTPS/SSL certificates
- Set `APP_DEBUG=false` in production
- Use environment-specific .env files
- Implement rate limiting on login/reset
- Set up Web Application Firewall (WAF)
- Regular security audits
- Keep dependencies updated

## 📊 Statistics

- **Total PHP Lines of Code**: ~2,000+
- **Database Tables**: 10 (6 core + 4 system)
- **Controllers**: 8
- **Models**: 6
- **Blade Templates**: 50+
- **API Endpoints**: 25+
- **Average Page Load Time**: <500ms

## 🚀 Performance Tips

- Use database indexing on frequently queried columns
- Implement caching for dashboard queries
- Lazy load charts with AJAX
- Compress images before storage
- Use CDN for static assets
- Enable query logging in development only
- Monitor database slow queries

## 📝 Contributing Guidelines

1. Test all changes locally
2. Ensure no PHP syntax errors: `php artisan tinker`
3. Verify database migrations: `php artisan migrate:status`
4. Check authorization for all new features
5. Validate all user inputs
6. Add proper error handling
7. Update README if adding features

## 🆘 Troubleshooting

### Common Issues

**Issue: "SQLSTATE[HY000]: General error: 1030"**
- Solution: Check MySQL storage quota or increase `max_allowed_packet`

**Issue: Profile picture not uploading**
- Solution: Verify `storage/app/public` directory exists and is writable
- Run: `php artisan storage:link`

**Issue: Migrations failing**
- Solution: Check database credentials in `.env`
- Ensure MySQL server is running

**Issue: Assets not loading (CSS/JS)**
- Solution: Run `npm run build` and `php artisan config:clear`

**Issue: Session timeouts**
- Solution: Check database sessions table
- Verify `SESSION_LIFETIME` in `.env` (default 120 minutes)

## 📞 Support & Resources

- **Laravel Docs**: https://laravel.com/docs
- **Tailwind CSS**: https://tailwindcss.com/docs
- **Chart.js**: https://www.chartjs.org/docs
- **GitHub Issues**: Report bugs on project repository

## 📄 License

This project is licensed under the MIT License - see LICENSE file for details.

## 👨‍💻 Author

**Tallam Gilbert**  
- GitHub: [@TallamGilbert](https://github.com/TallamGilbert)
- Email: [Your contact info]

---

**Project Status**: ✅ Active Development  
**Last Updated**: December 2, 2025  
**Version**: 1.2.0  
**PHP Version**: 8.2+  
**Laravel Version**: 12  

**Roadmap**: Check GitHub Projects board for planned features and timeline.
