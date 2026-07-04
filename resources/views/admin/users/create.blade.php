@extends('layouts.hekkensluiter')

@section('content')

    <h2 style="margin:0 0 16px 0; font-size:16px;">Nieuwe gebruiker</h2>

    @if ($errors->any())
        <div
            style="color:#d32f2f; background:#ffebee; padding:8px 12px; margin-bottom:12px; border-radius:3px; border-left:4px solid #d32f2f; font-size:13px;">
            <strong>Validatiefouten:</strong>
            <ul style="margin:6px 0 0 20px; padding:0;">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.users.store') }}" style="max-width:600px; margin:0 auto;">
        @csrf
        <link rel="stylesheet" href="{{ asset('css/_form.css') }}">
        <div class="form-container">
            <div class="form-section">
                <span class="form-section-title">Gegevens</span>

                <div class="form-group">
                    <label>Naam</label>
                    <input type="text" name="name" value="{{ old('name') }}" required maxlength="255">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required maxlength="255">
                </div>
                <div class="form-group">
                    <label>Geboortedatum</label>
                    <input type="date" name="geboortedatum" value="{{ old('geboortedatum') }}"
                        max="{{ now()->format('Y-m-d') }}">
                </div>
                <div class="form-group">
                    <label>Telefoonnummer</label>
                    <input type="tel" name="telefoonnummer" value="{{ old('telefoonnummer') }}" maxlength="20"
                        inputmode="tel" pattern="[0-9+\-\s()]{6,20}" title="Gebruik alleen cijfers, spaties en + - ( ).">
                </div>
                <div class="form-group">
                    <label>Rol</label>
                    <select name="role_id" required>
                        <option value="">— Kies een rol —</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                {{ $role->display_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-section">
                <span class="form-section-title">Adresgegevens</span>

                <div class="form-group-row">
                    <div class="form-group">
                        <label>Straatnaam</label>
                        <input type="text" name="straatnaam" value="{{ old('straatnaam') }}" maxlength="255">
                    </div>
                    <div class="form-group">
                        <label>Huisnummer</label>
                        <input type="number" name="huisnummer" value="{{ old('huisnummer') }}" min="1"
                            max="99999" inputmode="numeric">
                    </div>
                </div>

                <div class="form-group-row">
                    <div class="form-group">
                        <label>Postcode</label>
                        <input type="text" name="postcode" value="{{ old('postcode') }}" maxlength="7"
                            pattern="[1-9][0-9]{3}\s?[A-Za-z]{2}" title="Gebruik het formaat 1234 AB.">
                    </div>
                    <div class="form-group">
                        <label>Woonplaats</label>
                        <input type="text" name="woonplaats" value="{{ old('woonplaats') }}" maxlength="255">
                    </div>
                </div>
            </div>

            <div class="form-section">
                <span class="form-section-title">Wachtwoord</span>

                <div class="form-group">
                    <label>Wachtwoord</label>
                    <input type="password" name="password" required minlength="8">
                </div>
                <div class="form-group">
                    <label>Wachtwoord bevestigen</label>
                    <input type="password" name="password_confirmation" required minlength="8">
                </div>
            </div>
        </div>

        <div style="margin-top:16px; display:flex; gap:8px; justify-content:center;">
            <button type="submit"
                style="background:#007bff; color:white; border:none; padding:6px 12px; border-radius:3px; cursor:pointer; font-size:13px;">Aanmaken</button>
            <a href="{{ route('admin.users.index') }}"
                style="background:#666; color:white; border:none; padding:6px 12px; border-radius:3px; cursor:pointer; font-size:13px; text-decoration:none; display:inline-block;">Annuleren</a>
        </div>
    </form>

@endsection
