<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Hekkensluiter</title>
    <link rel="stylesheet" href="{{ asset('css/hekkensluiter.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

    <header class="hs-header">
        <div class="container hs-topbar">
            <div class="hs-logo">
                <img src="{{ asset('images/logo.png') }}" alt="logo">
                <strong>Hekkensluiter applicatie</strong>
            </div>

            <nav class="hs-tabs" aria-label="Hoofdmenu">
                @if (in_array(auth()->user()->rol, ['bewaker', 'developer', 'maatschappelijk_werker']))
                    <a class="hs-tab {{ Route::is('gedetineerden.*') ? 'active' : '' }}"
                        href="{{ route('gedetineerden.index') }}">Gedetineerden</a>
                @endif

                @if (in_array(auth()->user()->rol, ['bewaker', 'developer']))
                    <a class="hs-tab {{ Route::is('zaken.*') ? 'active' : '' }}"
                        href="{{ route('zaken.index') }}">Zaken</a>
                    <a class="hs-tab {{ Route::is('cellen.*') ? 'active' : '' }}"
                        href="{{ route('cellen.index') }}">Cellen</a>
                @endif

                @if (in_array(auth()->user()->rol, ['portier', 'bewaker', 'developer']))
                    <a class="hs-tab {{ Route::is('bezoekers.*') ? 'active' : '' }}"
                        href="{{ route('bezoekers.index') }}">Bezoekers</a>
                @endif

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="hs-tab" style="cursor: pointer" type="submit">Uitloggen</button>
                </form>
            </nav>
        </div>
    </header>

    <main class="container" role="main">
        <div style="display:flex; gap:16px; align-items:flex-start;">
            @hasSection('buiten_panel')
                <div style="flex-shrink:0;">
                    @yield('buiten_panel')
                </div>
            @endif
            <div class="panel" style="flex:1;">
                @yield('content')
            </div>
        </div>
    </main>

</body>

</html>
