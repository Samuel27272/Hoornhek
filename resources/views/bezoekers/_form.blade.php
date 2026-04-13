@csrf

<link rel="stylesheet" href="{{ asset('css/_form.css') }}">

<div class="form-container">
    <div class="form-section">
        <span class="form-section-title">Persoonlijke gegevens</span>

        <div class="form-group-row">
            <div class="form-group">
                <label>Voornaam</label>
                <input type="text" name="voornaam" value="{{ old('voornaam', $bezoeker->voornaam ?? '') }}" required>
            </div>
            <div class="form-group">
                <label>Achternaam</label>
                <input type="text" name="achternaam" value="{{ old('achternaam', $bezoeker->achternaam ?? '') }}"
                    required>
            </div>
        </div>

        <div class="form-group-row">
            <div class="form-group">
                <label>Telefoonnummer</label>
                <input type="text" name="telefoonnummer"
                    value="{{ old('telefoonnummer', $bezoeker->telefoonnummer ?? '') }}">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email', $bezoeker->email ?? '') }}">
            </div>
        </div>
    </div>

    <div class="form-section">
        <span class="form-section-title">Bezoekgegevens</span>

        <div class="form-group">
            <label>Start bezoek</label>
            <input type="datetime-local" name="start_bezoek"
                value="{{ old('start_bezoek', isset($bezoeker) && $bezoeker->start_bezoek ? $bezoeker->start_bezoek->format('Y-m-d\TH:i') : '') }}">
        </div>

        <div class="form-group">
            <label>Status</label>
            <select name="status" required>
                <option value="">— Selecteer status —</option>
                <option value="op_bezoek" @if (old('status', $bezoeker->status ?? '') == 'op_bezoek') selected @endif>Op bezoek</option>
                <option value="inactief" @if (old('status', $bezoeker->status ?? '') == 'inactief') selected @endif>Inactief</option>
            </select>
        </div>
    </div>
</div>
