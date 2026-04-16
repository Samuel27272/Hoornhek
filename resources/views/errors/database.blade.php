<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Er ging iets mis</title>
    <style>
        :root {
            color-scheme: light;
            --bg: #f4f7fb;
            --panel: rgba(255, 255, 255, 0.88);
            --border: rgba(15, 23, 42, 0.12);
            --text: #10203a;
            --muted: #52617a;
            --accent: #0f766e;
            --accent-strong: #115e59;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: grid;
            place-items: center;
            font-family: Arial, Helvetica, sans-serif;
            background:
                radial-gradient(circle at top left, rgba(15, 118, 110, 0.14), transparent 35%),
                radial-gradient(circle at bottom right, rgba(15, 23, 42, 0.08), transparent 35%),
                var(--bg);
            color: var(--text);
            padding: 24px;
        }

        .card {
            width: min(640px, 100%);
            background: var(--panel);
            border: 1px solid var(--border);
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(15, 23, 42, 0.12);
            padding: 32px;
            backdrop-filter: blur(10px);
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border-radius: 999px;
            background: rgba(15, 118, 110, 0.1);
            color: var(--accent-strong);
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        h1 {
            margin: 0 0 12px;
            font-size: clamp(28px, 4vw, 40px);
            line-height: 1.1;
        }

        p {
            margin: 0;
            color: var(--muted);
            font-size: 16px;
            line-height: 1.6;
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 28px;
        }

        .button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 44px;
            padding: 0 18px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 700;
        }

        .button-primary {
            background: var(--accent);
            color: white;
        }

        .button-secondary {
            background: white;
            color: var(--text);
            border: 1px solid var(--border);
        }
    </style>
</head>

<body>
    <main class="card" role="main" aria-labelledby="error-title">
        <div class="badge">Systeemfout</div>
        <h1 id="error-title">Opslaan mislukt</h1>
        <p>{{ $message }}</p>

        <div class="actions">
            <a class="button button-primary" href="javascript:history.back()">Ga terug</a>
            <a class="button button-secondary" href="{{ url('/') }}">Naar startpagina</a>
        </div>
    </main>
</body>

</html>
