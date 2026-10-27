<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Inloggen</title>
    <link rel="stylesheet" href="{{ asset('css/login-custom.css') }}" />
</head>

<body>
    <a class="logo-link" href="{{ url('/') }}">
        <img src="{{ asset('images/logo.png') }}" alt="HoornHek" />
    </a>
    <div class="center-wrap">
        <div class="card-outer">
            <div class="card-inner">
                <form method="POST" action="{{ route('login.store') }}">
                    @csrf
                    @if (session('status'))
                        <div
                            style="
                                background: #fffbeb;
                                border: 1px solid #fef3c7;
                                padding: 10px;
                                border-radius: 6px;
                                margin-bottom: 12px;
                                color: #92400e;
                            "
                        >
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div
                            style="
                                background: #fff1f2;
                                border: 1px solid #fecaca;
                                padding: 10px;
                                border-radius: 6px;
                                margin-bottom: 12px;
                                color: #b91c1c;
                            "
                        >
                            {{ $errors->first() }}
                        </div>
                    @endif

                    @if (session('error'))
                        <p
                            style="
                                background: #fff1f2;
                                border: 1px solid #fecaca;
                                padding: 10px;
                                border-radius: 6px;
                                margin-bottom: 12px;
                                color: #b91c1c;
                            "
                        >
                            {{ session('error') }}
                        </p>
                    @endif

                    <label for="email" class="label">E-mail</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        class="input"
                        placeholder="E-mail"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        maxlength="255"
                        autocomplete="email"
                        inputmode="email"
                    />

                    <label for="password" class="label">Wachtwoord</label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        class="input"
                        placeholder="Wachtwoord"
                        required
                        autocomplete="current-password"
                        autocapitalize="off"
                        spellcheck="false"
                        maxlength="255"
                    />

                    <a
                        href="{{ route('password.request') }}"
                        style="display: block; text-align: right; font-size: 13px; margin: 6px 0 16px 0; color: #007bff"
                    >
                        Wachtwoord vergeten?
                    </a>

                    <button type="submit" class="btn">Inloggen</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
