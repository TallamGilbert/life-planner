<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Life Planner - Manage Your Life with Ease</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                min-height: 100vh;
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            }

            .container {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                min-height: 100vh;
                padding: 20px;
            }

            .content {
                background: white;
                border-radius: 20px;
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
                padding: 60px 40px;
                max-width: 600px;
                text-align: center;
                animation: slideIn 0.6s ease-out;
            }

            @keyframes slideIn {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .logo {
                font-size: 48px;
                font-weight: 700;
                color: #667eea;
                margin-bottom: 20px;
            }

            h1 {
                font-size: 36px;
                color: #1a1a1a;
                margin-bottom: 15px;
                font-weight: 700;
            }

            .subtitle {
                font-size: 18px;
                color: #666;
                margin-bottom: 30px;
                line-height: 1.6;
            }

            .features {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
                gap: 20px;
                margin: 40px 0;
                text-align: left;
            }

            .feature {
                padding: 20px;
                background: #f8f9ff;
                border-radius: 12px;
                border-left: 4px solid #667eea;
            }

            .feature-icon {
                font-size: 28px;
                margin-bottom: 10px;
            }

            .feature-title {
                font-weight: 600;
                color: #1a1a1a;
                margin-bottom: 5px;
            }

            .feature-desc {
                font-size: 13px;
                color: #666;
            }

            .buttons {
                display: flex;
                gap: 15px;
                justify-content: center;
                margin-top: 40px;
                flex-wrap: wrap;
            }

            .btn {
                padding: 14px 32px;
                border: none;
                border-radius: 10px;
                font-size: 16px;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.3s ease;
                text-decoration: none;
                display: inline-block;
            }

            .btn-primary {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
            }

            .btn-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
            }

            .btn-secondary {
                background: white;
                color: #667eea;
                border: 2px solid #667eea;
            }

            .btn-secondary:hover {
                background: #f8f9ff;
                transform: translateY(-2px);
            }

            .nav {
                position: absolute;
                top: 20px;
                right: 20px;
                display: flex;
                gap: 15px;
            }

            .nav a {
                padding: 10px 20px;
                background: rgba(255, 255, 255, 0.2);
                color: white;
                border-radius: 8px;
                text-decoration: none;
                font-weight: 500;
                transition: all 0.3s ease;
                border: 1px solid rgba(255, 255, 255, 0.3);
            }

            .nav a:hover {
                background: white;
                color: #667eea;
            }

            @media (max-width: 600px) {
                .content {
                    padding: 40px 20px;
                }

                h1 {
                    font-size: 28px;
                }

                .logo {
                    font-size: 36px;
                }

                .features {
                    grid-template-columns: 1fr;
                }

                .buttons {
                    flex-direction: column;
                }

                .btn {
                    width: 100%;
                    box-sizing: border-box;
                }

                .nav {
                    position: static;
                    justify-content: center;
                    margin-bottom: 20px;
                }
            }
        </style>
    </head>
    <body>
        <div class="nav">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}">Dashboard</a>
                @else
                    <a href="{{ route('login') }}">Log In</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}">Register</a>
                    @endif
                @endauth
            @endif
        </div>

        <div class="container">
            <div class="content">
                <div class="logo">📋</div>
                <h1>Life Planner</h1>
                <p class="subtitle">Take control of your life. Track expenses, build habits, plan meals, and manage bills—all in one place.</p>

                <div class="features">
                    <div class="feature">
                        <div class="feature-icon">💰</div>
                        <div class="feature-title">Expenses</div>
                        <div class="feature-desc">Track spending easily</div>
                    </div>
                    <div class="feature">
                        <div class="feature-icon">🔥</div>
                        <div class="feature-title">Habits</div>
                        <div class="feature-desc">Build streaks & goals</div>
                    </div>
                    <div class="feature">
                        <div class="feature-icon">🍽️</div>
                        <div class="feature-title">Meals</div>
                        <div class="feature-desc">Plan & organize meals</div>
                    </div>
                    <div class="feature">
                        <div class="feature-icon">📊</div>
                        <div class="feature-title">Bills</div>
                        <div class="feature-desc">Never miss a payment</div>
                    </div>
                </div>

                <div class="buttons">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn btn-primary">Go to Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary">Get Started</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-secondary">Create Account</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </body>
</html>
