<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> <!-- Link to an external CSS file if needed -->
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f9fafb;
            /* Light background */
            color: #4a5568;
            /* Text color */
            margin: 0;
        }

        .header {
            background-color: #ffffff;
            /* Header background */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .nav-links {
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }

        .nav-links a {
            margin-left: 15px;
            text-decoration: none;
            color: #4a5568;
            /* Link color */
            font-weight: 600;
        }

        .nav-links a:hover {
            color: #ef3b2d;
            /* Hover color */
        }

        .content {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #ffffff;
            /* Card background */
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .content h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }

        .content p {
            margin-bottom: 30px;
        }

        .svg-container {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        /* Responsive styles */
        @media (max-width: 640px) {
            .content {
                padding: 15px;
            }

            .content h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>

<body class="antialiased">
    <header class="header">
        @if (Route::has('login'))
        <div class="nav-links">
            @auth
            <a href="{{ url('/photos') }}" class="text-sm underline">photos</a>
            @else
            <a href="{{ route('login') }}" class="text-sm underline">Log in</a>
            @if (Route::has('register'))
            <a href="{{ route('register') }}" class="text-sm underline">Register</a>
            @endif
            @endauth
        </div>
        @endif
    </header>

    <main class="content">
        <div class="svg-container">
            
        </div>

        <h1>Welcome</h1>
    </main>

    <!-- Add scripts if needed -->
</body>

</html>