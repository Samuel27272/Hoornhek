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
</style>

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
                <input type="text" name="achternaam" value="{{ old('achternaam', $bezoeker->achternaam ?? '') }}" required>
            </div>
        </div>

        <div class="form-group-row">
            <div class="form-group">
                <label>Telefoonnummer</label>
                <input type="text" name="telefoonnummer" value="{{ old('telefoonnummer', $bezoeker->telefoonnummer ?? '') }}">
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
            <input type="datetime-local" name="start_bezoek" value="{{ old('start_bezoek', isset($bezoeker) && $bezoeker->start_bezoek ? $bezoeker->start_bezoek->format('Y-m-d\TH:i') : '') }}">
        </div>

        <div class="form-group">
            <label>Status</label>
            <select name="status" required>
                <option value="">— Selecteer status —</option>
                <option value="op_bezoek" @if(old('status', $bezoeker->status ?? '') == 'op_bezoek') selected @endif>Op bezoek</option>
                <option value="inactief" @if(old('status', $bezoeker->status ?? '') == 'inactief') selected @endif>Inactief</option>
            </select>
        </div>
    </div>
</div>
