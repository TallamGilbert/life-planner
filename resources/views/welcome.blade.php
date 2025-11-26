<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Life Planner</title>
        
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:300,400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            :root {
                --text-primary: #111827;
                --text-secondary: #6b7280;
                --bg-primary: #ffffff;
                --bg-secondary: #f9fafb;
                --accent: #111827; /* Solid Black for minimal look */
                --accent-hover: #374151;
            }

            body {
                margin: 0;
                font-family: 'Figtree', sans-serif;
                background-color: var(--bg-primary);
                color: var(--text-primary);
                line-height: 1.5;
                -webkit-font-smoothing: antialiased;
            }

            /* Navbar */
            .nav {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 24px 40px;
                max-width: 1200px;
                margin: 0 auto;
            }

            .logo {
                font-weight: 700;
                font-size: 20px;
                letter-spacing: -0.5px;
                display: flex;
                align-items: center;
                gap: 8px;
                text-decoration: none;
                color: var(--text-primary);
            }

            .nav-links a {
                color: var(--text-secondary);
                text-decoration: none;
                font-size: 14px;
                font-weight: 500;
                margin-left: 24px;
                transition: color 0.2s ease;
            }

            .nav-links a:hover {
                color: var(--text-primary);
            }

            .nav-links .btn-login {
                color: var(--text-primary);
            }

            /* Main Hero */
            .hero {
                max-width: 800px;
                margin: 100px auto 60px;
                padding: 0 24px;
                text-align: center;
                animation: fadeIn 0.8s ease-out;
            }

            h1 {
                font-size: 56px;
                line-height: 1.1;
                font-weight: 800;
                letter-spacing: -1.5px;
                margin-bottom: 24px;
                background: linear-gradient(to right, #000 20%, #555 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }

            .subtitle {
                font-size: 20px;
                color: var(--text-secondary);
                max-width: 500px;
                margin: 0 auto 40px;
                font-weight: 300;
            }

            /* Buttons */
            .cta-group {
                display: flex;
                gap: 16px;
                justify-content: center;
                align-items: center;
            }

            .btn {
                padding: 12px 28px;
                border-radius: 50px;
                font-weight: 600;
                font-size: 15px;
                text-decoration: none;
                transition: all 0.2s ease;
            }

            .btn-primary {
                background: var(--accent);
                color: white;
                border: 1px solid var(--accent);
            }

            .btn-primary:hover {
                background: var(--accent-hover);
                border-color: var(--accent-hover);
                transform: translateY(-1px);
            }

            .btn-outline {
                background: transparent;
                color: var(--text-primary);
                border: 1px solid #e5e7eb;
            }

            .btn-outline:hover {
                border-color: var(--text-primary);
                background: var(--bg-secondary);
            }

            /* Grid Features */
            .grid-section {
                background: var(--bg-secondary);
                padding: 80px 24px;
                margin-top: 80px;
                border-top: 1px solid #f3f4f6;
            }

            .grid-container {
                max-width: 1000px;
                margin: 0 auto;
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 40px;
            }

            .feature-item {
                display: flex;
                flex-direction: column;
                align-items: flex-start;
            }

            .icon-box {
                width: 40px;
                height: 40px;
                background: white;
                border: 1px solid #e5e7eb;
                border-radius: 10px;
                display: flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 16px;
                color: var(--text-primary);
            }

            .feature-title {
                font-weight: 600;
                font-size: 16px;
                margin-bottom: 8px;
                color: var(--text-primary);
            }

            .feature-desc {
                font-size: 14px;
                color: var(--text-secondary);
                line-height: 1.6;
            }

            /* Animation */
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(20px); }
                to { opacity: 1; transform: translateY(0); }
            }

            /* Mobile */
            @media (max-width: 640px) {
                h1 { font-size: 40px; }
                .nav { padding: 20px; }
                .hero { margin-top: 60px; }
                .grid-container { grid-template-columns: 1fr; gap: 30px; }
            }
        </style>
    </head>
    <body>
        
        <!-- Navigation -->
        <nav class="nav">
            <a href="/" class="logo">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
                LifePlanner
            </a>
            <div class="nav-links">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn-login">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn-login">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Sign up</a>
                        @endif
                    @endauth
                @endif
            </div>
        </nav>

        <!-- Hero Section -->
        <main class="hero">
            <h1>Structure your life,<br>effortlessly.</h1>
            <p class="subtitle">
                The all-in-one minimal workspace for your finances, habits, meals, and bills. 
                Focus on living, not just planning.
            </p>
            
            <div class="cta-group">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-primary">Go to Dashboard</a>
                    @else
                        <a href="{{ route('register') }}" class="btn btn-primary">Get Started</a>
                        <a href="{{ route('login') }}" class="btn btn-outline">Log In</a>
                    @endauth
                @endif
            </div>
        </main>

        <!-- Minimal Feature Grid -->
        <div class="grid-section">
            <div class="grid-container">
                <!-- Feature 1 -->
                <div class="feature-item">
                    <div class="icon-box">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                    </div>
                    <div class="feature-title">Expenses</div>
                    <div class="feature-desc">Track every penny with zero clutter. Visualize where your money goes.</div>
                </div>

                <!-- Feature 2 -->
                <div class="feature-item">
                    <div class="icon-box">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    </div>
                    <div class="feature-title">Habits</div>
                    <div class="feature-desc">Build consistency. Simple streak tracking to keep you motivated daily.</div>
                </div>

                <!-- Feature 3 -->
                <div class="feature-item">
                    <div class="icon-box">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    </div>
                    <div class="feature-title">Bill Tracker</div>
                    <div class="feature-desc">Never miss a due date. See upcoming payments at a glance.</div>
                </div>

                <!-- Feature 4 -->
                <div class="feature-item">
                    <div class="icon-box">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8h1a4 4 0 0 1 0 8h-1"></path><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path><line x1="6" y1="1" x2="6" y2="4"></line><line x1="10" y1="1" x2="10" y2="4"></line><line x1="14" y1="1" x2="14" y2="4"></line></svg>
                    </div>
                    <div class="feature-title">Meal Plans</div>
                    <div class="feature-desc">Organize your weekly menu and generate shopping lists automatically.</div>
                </div>
            </div>
        </div>

    </body>
</html>