<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Forgot Password - Life Planner</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background-color: #f5f5f5;
            min-height: 100vh;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }

        .form {
            display: flex;
            flex-direction: column;
            gap: 10px;
            background-color: #ffffff;
            padding: 30px;
            width: 100%;
            max-width: 450px;
            border-radius: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        ::placeholder {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }

        .flex-column {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .flex-column > label {
            color: #151717;
            font-weight: 600;
            font-size: 14px;
        }

        .inputForm {
            border: 1.5px solid #ecedec;
            border-radius: 10px;
            height: 50px;
            display: flex;
            align-items: center;
            padding-left: 10px;
            transition: 0.2s ease-in-out;
        }

        .input {
            margin-left: 10px;
            border-radius: 10px;
            border: none;
            width: 100%;
            height: 100%;
            font-size: 14px;
        }

        .input:focus {
            outline: none;
        }

        .inputForm:focus-within {
            border: 1.5px solid #2d79f3;
        }

        .span {
            font-size: 14px;
            margin-left: 5px;
            color: #2d79f3;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
        }

        .span:hover {
            text-decoration: underline;
        }

        .button-submit {
            margin: 20px 0 10px 0;
            background-color: #151717;
            border: none;
            color: white;
            font-size: 15px;
            font-weight: 500;
            border-radius: 10px;
            height: 50px;
            width: 100%;
            cursor: pointer;
            transition: 0.2s ease-in-out;
        }

        .button-submit:hover {
            background-color: #2d2e2f;
        }

        .p {
            text-align: center;
            color: black;
            font-size: 14px;
            margin: 5px 0;
        }

        .logo-section {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo-section h1 {
            color: #151717;
            font-size: 24px;
            font-weight: 700;
            margin: 0;
        }

        .logo-section p {
            color: #666;
            font-size: 14px;
            margin: 5px 0 0 0;
        }

        .error-text {
            color: #dc2626;
            font-size: 13px;
        }

        .info-text {
            color: #059669;
            font-size: 13px;
            background-color: #d1fae5;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        @media (max-width: 480px) {
            .form {
                padding: 20px;
                max-width: 100%;
            }
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen flex items-center justify-center p-4">
        <form method="POST" action="{{ route('password.email') }}" class="form">
            @csrf

            <!-- Logo & Welcome -->
            <div class="logo-section">
                <h1>LifePlanner</h1>
                <p>Reset your password</p>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="info-text">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Help Text -->
            <p class="p" style="margin-top: 0; font-size: 13px; color: #666;">
                No problem. Just let us know your email address and we'll send you a password reset link.
            </p>

            <!-- Email Address -->
            <div class="flex-column">
                <label for="email">Email</label>
                <div class="inputForm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="0 0 32 32" height="20">
                        <g data-name="Layer 3" id="Layer_3">
                            <path d="m30.853 13.87a15 15 0 0 0 -29.729 4.082 15.1 15.1 0 0 0 12.876 12.918 15.6 15.6 0 0 0 2.016.13 14.85 14.85 0 0 0 7.715-2.145 1 1 0 1 0 -1.031-1.711 13.007 13.007 0 1 1 5.458-6.529 2.149 2.149 0 0 1 -4.158-.759v-10.856a1 1 0 0 0 -2 0v1.726a8 8 0 1 0 .2 10.325 4.135 4.135 0 0 0 7.83.274 15.2 15.2 0 0 0 .823-7.455zm-14.853 8.13a6 6 0 1 1 6-6 6.006 6.006 0 0 1 -6 6z" fill="#666"></path>
                        </g>
                    </svg>
                    <input 
                        id="email"
                        placeholder="you@example.com" 
                        class="input" 
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="email">
                </div>
                @error('email')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit" class="button-submit">Send Reset Link</button>

            <!-- Back to Login Link -->
            <p class="p">Remember your password? <a href="{{ route('login') }}" class="span">Sign In</a></p>
        </form>
    </div>
</body>
</html>