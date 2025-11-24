<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Register - Life Planner</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
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

        .terms-checkbox {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            margin-top: 10px;
        }

        .terms-checkbox input {
            margin-top: 3px;
            accent-color: #2d79f3;
            cursor: pointer;
        }

        .terms-checkbox label {
            font-size: 13px;
            color: #666;
            margin: 0;
            cursor: pointer;
        }

        .terms-checkbox a {
            color: #2d79f3;
            text-decoration: none;
            font-weight: 500;
        }

        .terms-checkbox a:hover {
            text-decoration: underline;
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
        <form method="POST" action="{{ route('register') }}" class="form">
            @csrf

            <!-- Logo & Welcome -->
            <div class="logo-section">
                <h1>LifePlanner</h1>
                <p>Create your account</p>
            </div>

            <!-- Name -->
            <div class="flex-column">
                <label for="name">Full Name</label>
                <div class="inputForm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="0 0 24 24" height="20" fill="none" stroke="#666" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    <input 
                        id="name"
                        placeholder="John Doe" 
                        class="input" 
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        autofocus
                        autocomplete="name">
                </div>
                @error('name')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

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
                        autocomplete="email">
                </div>
                @error('email')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div class="flex-column">
                <label for="password">Password</label>
                <div class="inputForm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="-64 0 512 512" height="20">
                        <path d="m336 512h-288c-26.453125 0-48-21.523438-48-48v-224c0-26.476562 21.546875-48 48-48h288c26.453125 0 48 21.523438 48 48v224c0 26.476562-21.546875 48-48 48zm-288-288c-8.8125 0-16 7.167969-16 16v224c0 8.832031 7.1875 16 16 16h288c8.8125 0 16-7.167969 16-16v-224c0-8.832031-7.1875-16-16-16zm0 0"></path>
                        <path d="m304 224c-8.832031 0-16-7.167969-16-16v-80c0-52.929688-43.070312-96-96-96s-96 43.070312-96 96v80c0 8.832031-7.167969 16-16 16s-16-7.167969-16-16v-80c0-70.59375 57.40625-128 128-128s128 57.40625 128 128v80c0 8.832031-7.167969 16-16 16zm0 0"></path>
                    </svg>
                    <input 
                        id="password"
                        placeholder="••••••••" 
                        class="input" 
                        type="password"
                        name="password"
                        required
                        autocomplete="new-password">
                </div>
                @error('password')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="flex-column">
                <label for="password_confirmation">Confirm Password</label>
                <div class="inputForm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="-64 0 512 512" height="20">
                        <path d="m336 512h-288c-26.453125 0-48-21.523438-48-48v-224c0-26.476562 21.546875-48 48-48h288c26.453125 0 48 21.523438 48 48v224c0 26.476562-21.546875 48-48 48zm-288-288c-8.8125 0-16 7.167969-16 16v224c0 8.832031 7.1875 16 16 16h288c8.8125 0 16-7.167969 16-16v-224c0-8.832031-7.1875-16-16-16zm0 0"></path>
                        <path d="m304 224c-8.832031 0-16-7.167969-16-16v-80c0-52.929688-43.070312-96-96-96s-96 43.070312-96 96v80c0 8.832031-7.167969 16-16 16s-16-7.167969-16-16v-80c0-70.59375 57.40625-128 128-128s128 57.40625 128 128v80c0 8.832031-7.167969 16-16 16zm0 0"></path>
                    </svg>
                    <input 
                        id="password_confirmation"
                        placeholder="••••••••" 
                        class="input" 
                        type="password"
                        name="password_confirmation"
                        required
                        autocomplete="new-password">
                </div>
                @error('password_confirmation')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <!-- Terms & Conditions -->
            <div class="terms-checkbox">
                <input id="agree-terms" name="agree_terms" type="checkbox" required>
                <label for="agree-terms">
                    I agree to the <a href="#">Terms & Conditions</a>
                </label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="button-submit">Create Account</button>

            <!-- Sign In Link -->
            <p class="p">Already have an account? <a href="{{ route('login') }}" class="span">Sign In</a></p>
        </form>
    </div>
</body>
</html>