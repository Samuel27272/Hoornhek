@csrf

<link rel="stylesheet" href="{{ asset('css/_form.css') }}">

<div class="form-container">
    <div class="form-section">
        <span class="form-section-title">Zaakgegevens</span>

        <div class="form-group">
            <label>Zaak nummer</label>
            <input type="text" name="zaaknummer" value="{{ old('zaaknummer', $zaak->zaaknummer ?? '') }}" required>
        </div>

        <div class="form-group">
            <label>Status</label>
            <select name="status" required>
                <option value="">— Selecteer status —</option>
                <option value="open" @if (old('status', $zaak->status ?? '') == 'open') selected @endif>Open</option>
                <option value="in_behandeling" @if (old('status', $zaak->status ?? '') == 'in_behandeling') selected @endif>In behandeling</option>
                <option value="gesloten" @if (old('status', $zaak->status ?? '') == 'gesloten') selected @endif>Gesloten</option>
            </select>
        </div>

        <div class="form-group">
            <label>Omschrijving</label>
            <textarea name="omschrijving" required>{{ old('omschrijving', $zaak->omschrijving ?? '') }}</textarea>
        </div>

        <div class="form-group">
            <label>Misdaad type</label>
            <input type="text" name="misdaad_type" value="{{ old('misdaad_type', $zaak->misdaad_type ?? '') }}">
        </div>
    </div>

    @if (isset($zaak) && $zaak->id)
        <div class="form-section">
            <span class="form-section-title">Beheergegevens</span>

            <div class="form-group-row">
                <div class="form-group">
                    <label>Aangemaakt</label>
                    <input type="date" value="{{ $zaak->datum_aangemaakt?->format('Y-m-d') }}" disabled>
                </div>
                <div class="form-group">
                    <label>Gesloten</label>
                    <input type="date" value="{{ $zaak->datum_gesloten?->format('Y-m-d') ?? '' }}" disabled>
                </div>
            </div>

            <div class="form-group">
                <label>Aangemaakt door</label>
                <input type="text" value="{{ $zaak->aangemaaktDoor?->name ?? 'Onbekend' }}" disabled>
            </div>
        </div>
    @endif

    <div class="form-section">
        <span class="form-section-title">Opmerkingen</span>

        <div class="form-group">
            <label>Opmerkingen</label>
            <textarea name="opmerkingen">{{ old('opmerkingen', $zaak->opmerkingen ?? '') }}</textarea>
        </div>
    </div>
</div>
