@csrf

<link rel="stylesheet" href="{{ asset('css/_form.css') }}">

<div class="form-container">
    <div class="form-section">
        <span class="form-section-title">Celgegevens</span>

        <div class="form-group-row">
            <div class="form-group">
                <label>Cel nummer</label>
                <input type="text" name="cel_nummer" value="{{ old('cel_nummer', $cel->cel_nummer ?? '') }}" required
                    maxlength="20" autocomplete="off" pattern="[A-Za-z0-9\-]+"
                    title="Gebruik alleen letters, cijfers en koppeltekens.">
            </div>
            <div class="form-group">
                <label>Capaciteit</label>
                <input type="number" name="capaciteit" value="{{ old('capaciteit', $cel->capaciteit ?? '') }}"
                    min="1" max="999" step="1" inputmode="numeric" required>
            </div>
        </div>

        <div class="form-group">
            <label>Status</label>
            <select name="status" required>
                <option value="">— Selecteer status —</option>
                <option value="beschikbaar" @if (old('status', $cel->status ?? '') == 'beschikbaar') selected @endif>Beschikbaar</option>
                <option value="bezet" @if (old('status', $cel->status ?? '') == 'bezet') selected @endif>Bezet</option>
                <option value="buiten_gebruik" @if (old('status', $cel->status ?? '') == 'buiten_gebruik') selected @endif>Buiten gebruik</option>
            </select>
        </div>
    </div>

    <div class="form-section">
        <span class="form-section-title">Opmerkingen</span>

        <div class="form-group">
            <label>Opmerkingen</label>
            <textarea name="opmerkingen" maxlength="2000">{{ old('opmerkingen', $cel->opmerkingen ?? '') }}</textarea>
        </div>
    </div>
</div>
