@csrf

<style>
    .form-container {
        max-width: 600px;
        margin: 0 auto;
    }

    .form-section {
        margin-bottom: 24px;
        padding-bottom: 24px;
        border-bottom: 1px solid #e5e7eb;
    }

    .form-section:last-child {
        border-bottom: none;
    }

    .form-section-title {
        font-size: 14px;
        font-weight: 700;
        color: #374151;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 16px;
        display: block;
    }

    .form-group {
        margin-bottom: 16px;
        display: flex;
        flex-direction: column;
    }

    .form-group-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .form-group label {
        font-weight: 600;
        font-size: 13px;
        color: #374151;
        margin-bottom: 6px;
        display: block;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        padding: 8px 12px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 13px;
        font-family: inherit;
        background-color: #fff;
        color: #111827;
        transition: all 0.2s ease;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        background-color: #f0f9ff;
    }

    .form-group input[disabled],
    .form-group input[readonly],
    .form-group select[disabled] {
        background-color: #f3f4f6;
        color: #6b7280;
        cursor: not-allowed;
    }

    .form-group textarea {
        resize: vertical;
        min-height: 100px;
    }
</style>

<div class="form-container">
    <div class="form-section">
        <span class="form-section-title">Persoonlijke gegevens</span>

        <div class="form-group">
            <label>BSN-nummer</label>
            <input type="text" name="bsn_nummer" value="{{ old('bsn_nummer', $gedetineerde->bsn_nummer ?? '') }}" required>
        </div>

        <div class="form-group-row">
            <div class="form-group">
                <label>Voornaam</label>
                <input type="text" name="voornaam" value="{{ old('voornaam', $gedetineerde->voornaam ?? '') }}" required>
            </div>
            <div class="form-group">
                <label>Achternaam</label>
                <input type="text" name="achternaam" value="{{ old('achternaam', $gedetineerde->achternaam ?? '') }}" required>
            </div>
        </div>

        <div class="form-group">
            <label>Geboortedatum</label>
            <input type="date" name="geboortedatum" value="{{ old('geboortedatum', isset($gedetineerde) && $gedetineerde->geboortedatum ? $gedetineerde->geboortedatum->format('Y-m-d') : '') }}" required>
        </div>
    </div>

    <div class="form-section">
        <span class="form-section-title">Adresgegevens</span>

        <div class="form-group-row">
            <div class="form-group">
                <label>Straatnaam</label>
                <input type="text" name="straatnaam" value="{{ old('straatnaam', $gedetineerde->straatnaam ?? '') }}" required>
            </div>
            <div class="form-group">
                <label>Huisnummer</label>
                <input type="text" name="huisnummer" value="{{ old('huisnummer', $gedetineerde->huisnummer ?? '') }}" required>
            </div>
        </div>

        <div class="form-group-row">
            <div class="form-group">
                <label>Postcode</label>
                <input type="text" name="postcode" value="{{ old('postcode', $gedetineerde->postcode ?? '') }}" required>
            </div>
            <div class="form-group">
                <label>Woonplaats</label>
                <input type="text" name="woonplaats" value="{{ old('woonplaats', $gedetineerde->woonplaats ?? '') }}" required>
            </div>
        </div>
    </div>

    <div class="form-section">
        <span class="form-section-title">Contactgegevens</span>

        <div class="form-group-row">
            <div class="form-group">
                <label>Telefoonnummer</label>
                <input type="text" name="telefoonnummer" value="{{ old('telefoonnummer', $gedetineerde->telefoonnummer ?? '') }}">
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
                <input type="date" name="aanhoudingsdatum" value="{{ old('aanhoudingsdatum', isset($gedetineerde) && $gedetineerde->aanhoudingsdatum ? $gedetineerde->aanhoudingsdatum->format('Y-m-d') : '') }}" required>
            </div>
            <div class="form-group">
                <label>Datum schorsing</label>
                <input type="date" name="datum_schorsing" value="{{ old('datum_schorsing', isset($gedetineerde) && $gedetineerde->datum_schorsing ? $gedetineerde->datum_schorsing->format('Y-m-d') : '') }}">
            </div>
        </div>
    </div>

    <div class="form-section">
        <span class="form-section-title">Cel & Opmerkingen</span>

        <div class="form-group">
            <label>Cel</label>
            <select name="cel_id">
                <option value="">— Geen —</option>
                @foreach($cellen as $cel)
                    <option value="{{ $cel->id }}" @if(old('cel_id', $gedetineerde->cel_id ?? '') == $cel->id) selected @endif>{{ $cel->cel_nummer }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Opmerkingen</label>
            <textarea name="opmerkingen">{{ old('opmerkingen', $gedetineerde->opmerkingen ?? '') }}</textarea>
        </div>
    </div>
</div>
