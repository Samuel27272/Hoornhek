@csrf

<link rel="stylesheet" href="{{ asset('css/_form.css') }}">

<div class="form-container">
    <div class="form-section">
        <span class="form-section-title">Pasfoto</span>

        @if (isset($gedetineerde) && $gedetineerde->foto_pad)
            <div style="margin-bottom:12px;">
                <img src="{{ route('gedetineerden.foto', $gedetineerde) }}"
                    style="width:120px; height:120px; object-fit:cover; border-radius:6px; border:1px solid #d1d5db;">
            </div>
            <div style="margin-bottom:8px; display:flex; align-items:center; gap:8px;">
                <input type="checkbox" name="foto_verwijderen" id="foto_verwijderen" value="1">
                <label for="foto_verwijderen" style="font-size:13px; margin-bottom:0; font-weight:400;">Huidige foto
                    verwijderen</label>
            </div>
        @endif

        <div class="form-group">
            <label for="foto_pad"
                style="display:inline-block; padding:6px 12px; background:#6c757d; color:white; border-radius:3px; cursor:pointer; font-size:13px;">
                {{ isset($gedetineerde) && $gedetineerde->foto_pad ? 'Foto wijzigen' : 'Foto kiezen' }}
            </label>
            <input type="file" name="foto_pad" id="foto_pad" accept="image/*,.jpg,.jpeg,.png,.webp"
                style="display:none;"
                onchange="document.getElementById('foto_naam').textContent = this.files[0]?.name ?? 'Geen foto gekozen'">
            <span id="foto_naam" style="font-size:13px; color:#6b7280; margin-left:8px;">Geen foto gekozen</span>
        </div>
    </div>

    <div class="form-section">
        <span class="form-section-title">Persoonlijke gegevens</span>

        <div class="form-group">
            <label>BSN-nummer</label>
            <input type="text" name="bsn_nummer" value="{{ old('bsn_nummer', $gedetineerde->bsn_nummer ?? '') }}"
                required maxlength="9" inputmode="numeric" autocomplete="off" pattern="[0-9]{9}"
                title="BSN moet uit 9 cijfers bestaan." oninput="this.value = this.value.replace(/[^0-9]/g, '')">
            @error('bsn_nummer')
                <div style="margin-top:6px; font-size:13px; color:#d32f2f;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group-row">
            <div class="form-group">
                <label>Voornaam</label>
                <input type="text" name="voornaam" value="{{ old('voornaam', $gedetineerde->voornaam ?? '') }}"
                    required maxlength="255" autocomplete="given-name">
            </div>
            <div class="form-group">
                <label>Achternaam</label>
                <input type="text" name="achternaam" value="{{ old('achternaam', $gedetineerde->achternaam ?? '') }}"
                    required maxlength="255" autocomplete="family-name">
            </div>
        </div>

        <div class="form-group">
            <label>Geboortedatum</label>
            <input type="date" name="geboortedatum"
                value="{{ old('geboortedatum', isset($gedetineerde) && $gedetineerde->geboortedatum ? $gedetineerde->geboortedatum->format('Y-m-d') : '') }}"
                required max="{{ now()->format('Y-m-d') }}">
        </div>
    </div>

    <div class="form-section">
        <span class="form-section-title">Adresgegevens</span>

        <div class="form-group-row">
            <div class="form-group">
                <label>Straatnaam</label>
                <input type="text" name="straatnaam" value="{{ old('straatnaam', $gedetineerde->straatnaam ?? '') }}"
                    @if (isset($gedetineerde) && $gedetineerde->exists) required @endif maxlength="255" autocomplete="address-line1">
            </div>
            <div class="form-group">
                <label>Huisnummer</label>
                <input type="number" name="huisnummer"
                    value="{{ old('huisnummer', $gedetineerde->huisnummer ?? '') }}"
                    @if (isset($gedetineerde) && $gedetineerde->exists) required @endif min="1" max="99999" step="1"
                    inputmode="numeric">
            </div>
        </div>

        <div class="form-group-row">
            <div class="form-group">
                <label>Postcode</label>
                <input type="text" name="postcode" value="{{ old('postcode', $gedetineerde->postcode ?? '') }}"
                    @if (isset($gedetineerde) && $gedetineerde->exists) required @endif maxlength="7" autocomplete="postal-code"
                    pattern="[1-9][0-9]{3}\s?[A-Za-z]{2}" title="Gebruik het formaat 1234 AB.">
            </div>
            <div class="form-group">
                <label>Woonplaats</label>
                <input type="text" name="woonplaats"
                    value="{{ old('woonplaats', $gedetineerde->woonplaats ?? '') }}"
                    @if (isset($gedetineerde) && $gedetineerde->exists) required @endif maxlength="255" autocomplete="address-level2">
            </div>
        </div>
    </div>

    <div class="form-section">
        <span class="form-section-title">Contactgegevens</span>

        <div class="form-group-row">
            <div class="form-group">
                <label>Telefoonnummer</label>
                <input type="tel" name="telefoonnummer"
                    value="{{ old('telefoonnummer', $gedetineerde->telefoonnummer ?? '') }}" maxlength="20"
                    autocomplete="tel" inputmode="tel" pattern="[0-9+\-\s()]{6,20}"
                    title="Gebruik alleen cijfers, spaties en + - ( ).">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email', $gedetineerde->email ?? '') }}"
                    maxlength="255" autocomplete="email">
            </div>
        </div>
    </div>

    <div class="form-section">
        <span class="form-section-title">Aanhoudingsgegevens</span>

        <div class="form-group-row">
            <div class="form-group">
                <label>Aanhoudingsdatum</label>
                <input type="date" name="aanhoudingsdatum"
                    value="{{ old('aanhoudingsdatum', isset($gedetineerde) && $gedetineerde->aanhoudingsdatum ? $gedetineerde->aanhoudingsdatum->format('Y-m-d') : '') }}"
                    required max="{{ now()->format('Y-m-d') }}">
            </div>
            <div class="form-group">
                <label>Datum schorsing</label>
                <input type="date" name="datum_schorsing"
                    value="{{ old('datum_schorsing', isset($gedetineerde) && $gedetineerde->datum_schorsing ? $gedetineerde->datum_schorsing->format('Y-m-d') : '') }}">
            </div>
        </div>
    </div>

    <div class="form-section">
        <span class="form-section-title">Cel & Opmerkingen</span>

        <div class="form-group">
            <label>Cel</label>
            <select name="cel_id">
                <option value="">— Geen —</option>
                @foreach ($cellen as $cel)
                    <option value="{{ $cel->id }}" @if (old('cel_id', $gedetineerde->cel_id ?? '') == $cel->id) selected @endif>
                        {{ $cel->cel_nummer }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Opmerkingen</label>
            <textarea name="opmerkingen" maxlength="2000">{{ old('opmerkingen', $gedetineerde->opmerkingen ?? '') }}</textarea>
        </div>
    </div>

    <div class="form-section">
        <span class="form-section-title">Zaken</span>

        @if (isset($alleZaken) && $alleZaken->isNotEmpty())
            <div class="form-group">
                @foreach ($alleZaken as $zaak)
                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                        <input type="checkbox" name="zaken[]" value="{{ $zaak->id }}"
                            id="zaak_{{ $zaak->id }}"
                            {{ isset($gedetineerde) && $gedetineerde->zaken->contains($zaak->id) ? 'checked' : '' }}>
                        <label for="zaak_{{ $zaak->id }}" style="margin-bottom: 0; font-weight: 400;">
                            {{ $zaak->zaaknummer }} — {{ $zaak->omschrijving }}
                        </label>
                    </div>
                @endforeach
            </div>
        @else
            <p style="font-size: 13px; color: #6b7280;">Geen zaken beschikbaar.</p>
        @endif
    </div>
</div>
