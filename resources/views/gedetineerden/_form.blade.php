@csrf

<link rel="stylesheet" href="{{ asset('css/_form.css') }}">

<div class="form-container">
    <div class="form-section">
        <span class="form-section-title">Pasfoto</span>

        @if (isset($gedetineerde) && $gedetineerde->foto_pad)
            <div style="margin-bottom:12px;">
                <img src="{{ Storage::url($gedetineerde->foto_pad) }}"
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
            <input type="file" name="foto_pad" id="foto_pad" accept="image/*" style="display:none;"
                onchange="document.getElementById('foto_naam').textContent = this.files[0]?.name ?? 'Geen foto gekozen'">
            <span id="foto_naam" style="font-size:13px; color:#6b7280; margin-left:8px;">Geen foto gekozen</span>
        </div>
    </div>

    <div class="form-section">
        <span class="form-section-title">Persoonlijke gegevens</span>

        <div class="form-group">
            <label>BSN-nummer</label>
            <input type="text" name="bsn_nummer" value="{{ old('bsn_nummer', $gedetineerde->bsn_nummer ?? '') }}"
                required>
        </div>

        <div class="form-group-row">
            <div class="form-group">
                <label>Voornaam</label>
                <input type="text" name="voornaam" value="{{ old('voornaam', $gedetineerde->voornaam ?? '') }}"
                    required>
            </div>
            <div class="form-group">
                <label>Achternaam</label>
                <input type="text" name="achternaam" value="{{ old('achternaam', $gedetineerde->achternaam ?? '') }}"
                    required>
            </div>
        </div>

        <div class="form-group">
            <label>Geboortedatum</label>
            <input type="date" name="geboortedatum"
                value="{{ old('geboortedatum', isset($gedetineerde) && $gedetineerde->geboortedatum ? $gedetineerde->geboortedatum->format('Y-m-d') : '') }}"
                required>
        </div>
    </div>

    <div class="form-section">
        <span class="form-section-title">Adresgegevens</span>

        <div class="form-group-row">
            <div class="form-group">
                <label>Straatnaam</label>
                <input type="text" name="straatnaam" value="{{ old('straatnaam', $gedetineerde->straatnaam ?? '') }}"
                    required>
            </div>
            <div class="form-group">
                <label>Huisnummer</label>
                <input type="text" name="huisnummer" value="{{ old('huisnummer', $gedetineerde->huisnummer ?? '') }}"
                    required>
            </div>
        </div>

        <div class="form-group-row">
            <div class="form-group">
                <label>Postcode</label>
                <input type="text" name="postcode" value="{{ old('postcode', $gedetineerde->postcode ?? '') }}"
                    required>
            </div>
            <div class="form-group">
                <label>Woonplaats</label>
                <input type="text" name="woonplaats"
                    value="{{ old('woonplaats', $gedetineerde->woonplaats ?? '') }}" required>
            </div>
        </div>
    </div>

    <div class="form-section">
        <span class="form-section-title">Contactgegevens</span>

        <div class="form-group-row">
            <div class="form-group">
                <label>Telefoonnummer</label>
                <input type="text" name="telefoonnummer"
                    value="{{ old('telefoonnummer', $gedetineerde->telefoonnummer ?? '') }}">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email', $gedetineerde->email ?? '') }}">
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
                    required>
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
            <textarea name="opmerkingen">{{ old('opmerkingen', $gedetineerde->opmerkingen ?? '') }}</textarea>
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
