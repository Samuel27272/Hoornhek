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
            padding: 15px 40px;
            background: #cfc8a9;
        }

        .menu a {
            margin: 0 10px;
            text-decoration: none;
            color: black;
        }

        .btn {
            background: #6b3b1d;
            color: white;
            padding: 8px 15px;
            border: none;
        }

        .hero {
            height: 100vh;
            background: url('/images/building.jpg') center/cover no-repeat;
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
            padding: 20px;
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
    <div class="logo">
    <img src="{{ asset('images/logo.png') }}" alt="HoornHek logo">
    </div>

    <div class="menu">
        <a href="#about">Over ons</a>
        <a href="#contact">Contact</a>
        <button class="btn">Inloggen</button>
    </div>
</nav>

@yield('content')

</body>
</html>
