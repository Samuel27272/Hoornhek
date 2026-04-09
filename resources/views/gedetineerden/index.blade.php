<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gedetineerden</title>
</head>
<body>
    <main>
    <h1 style="font-size:28px; margin-bottom:8px;">Gedetineerden</h1>

    <p style="margin-bottom:16px;">Welkom, {{ auth()->user()?->name ?? __('Gast') }}.</p>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="login">Uitloggen</button>
    </form>
</main>
</body>
</html>
