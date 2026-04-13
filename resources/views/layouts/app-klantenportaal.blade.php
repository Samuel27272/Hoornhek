<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <title>HoornHek</title>
    <link rel="stylesheet" href="{{ asset('css/app-klantenportaal.css') }}">
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
