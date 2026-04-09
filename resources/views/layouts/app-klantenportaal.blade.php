<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>HoornHek</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        html {
            scroll-behavior: smooth;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 40px;
            background: #6b3b1d;
            position: relative;
        }

        .navbar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 50%;
            height: 101%;
            background: #cfc8a9;
            clip-path: polygon(0 0, 90% 0, 100% 100%, 0 100%);
            filter: drop-shadow(4px 0 6px rgba(0, 0, 0, 0.4));
        }

        .menu a {
            margin: 0 10px;
            text-decoration: none;
            color: white;
        }

        .login {
            background: #cfc8a9;
            color: black !important;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
        }

        .hero {
            height: min(100vh);
            background-image: url('/images/building.png');
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
            position: relative;
        }

        .hero .overlay {
            position: absolute;
            top: 80px;
            left: 50px;
            color: white;
        }

        .hero .overlay h1 {
            font-size: 38px;
            margin: 10px;
            margin-top: 0;
        }

        .hero .overlay h2 {
            font-size: 30px;
            margin: 10px;
        }

        .about {
            padding: 60px;
            padding-bottom: 20px;
            display: flex;
            justify-content: center;
        }

        .history {
            padding: 60px;
            padding-top: 20px;
            display: flex;
            justify-content: center;
        }

        .container {
            display: flex;
            gap: 40px;
            max-width: 1000px;
        }

        .container img {
            width: 500px;
        }

        .contact {
            background: #6b3b1d;
            color: white;
            padding: 20px 40px;
            position: relative;
        }

        .contact::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 45%;
            height: 100%;
            background: #cfc8a9;
            clip-path: polygon(0 0, 100% 0, 100% 100%, 10% 100%);
            filter: drop-shadow(-4px 0 6px rgba(0, 0, 0, 0.4));
        }

        .logo {
            position: relative;
            z-index: 1;
        }
        .logo img {
            height: 60px;
        }

        .navbar {
            display: flex;
            align-items: center;
        }
    </style>

</head>
<body>

<nav class="navbar">
    <a class="logo-link" href="{{ url('/') }}">
        <div class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="HoornHek logo">
        </div>
    </a>

    <div class="menu">
        <a href="#about">Over ons</a>
        <a href="#contact">Contact</a>
        <a href="{{ route('login') }}" class="login">Inloggen</a>
    </div>
</nav>

@yield('content')

</body>
</html>
