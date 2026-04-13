@extends('layouts.hekkensluiter')

@section('content')
    <div style="margin-bottom:16px;">
        <a href="{{ route('zaken.index') }}" style="text-decoration:none; color:#007bff;">← Terug naar zaken</a>
    </div>

    <h2 style="margin:0 0 16px 0; font-size:16px;">Zaak: {{ $zaak->zaaknummer }}</h2>

    <div style="background:#f9f9f9; padding:12px; border:1px solid #ddd; border-radius:3px; margin-bottom:16px;">
        <dl style="margin:0; font-size:13px;">
            <dt style="font-weight:bold; margin-top:8px;">Zaak nummer:</dt>
            <dd style="margin:0 0 8px 0;">{{ $zaak->zaaknummer }}</dd>

            <dt style="font-weight:bold; margin-top:8px;">Omschrijving:</dt>
            <dd style="margin:0 0 8px 0;">{{ $zaak->omschrijving }}</dd>

            <dt style="font-weight:bold; margin-top:8px;">Misdaad type:</dt>
            <dd style="margin:0 0 8px 0;">{{ $zaak->misdaad_type ?? '—' }}</dd>

            <dt style="font-weight:bold; margin-top:8px;">Status:</dt>
            <dd style="margin:0 0 8px 0;">{{ ucfirst(str_replace('_', ' ', $zaak->status)) }}</dd>

            <dt style="font-weight:bold; margin-top:8px;">Aangemaakt op:</dt>
            <dd style="margin:0 0 8px 0;">{{ $zaak->datum_aangemaakt->format('d-m-Y') }}</dd>

            <dt style="font-weight:bold; margin-top:8px;">Gesloten op:</dt>
            <dd style="margin:0 0 8px 0;">{{ $zaak->datum_gesloten ? $zaak->datum_gesloten->format('d-m-Y') : '—' }}</dd>

            <dt style="font-weight:bold; margin-top:8px;">Aangemaakt door:</dt>
            <dd style="margin:0 0 8px 0;">{{ $zaak->aangemaaktDoor?->name ?? '—' }}</dd>

            <dt style="font-weight:bold; margin-top:8px;">Opmerkingen:</dt>
            <dd style="margin:0 0 8px 0;">{{ $zaak->opmerkingen ?? '—' }}</dd>

            <dt style="font-weight:bold; margin-top:8px;">Aangekoppelde gedetineerden:</dt>
            <dd style="margin:0 0 8px 0;">{{ $zaak->gedetineerden->count() ?? 0 }}</dd>
        </dl>
    </div>

    <div style="display:flex; gap:8px; justify-content:center;">
        <a href="{{ route('zaken.edit', ['zaken' => $zaak->id]) }}"
            style="background:#007bff; color:white; border:none; padding:6px 12px; border-radius:3px; cursor:pointer; font-size:13px; text-decoration:none; display:inline-block;">Bewerk</a>
        <form action="{{ route('zaken.destroy', ['zaken' => $zaak->id]) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit"
                style="background:#dc3545; color:white; border:none; padding:6px 12px; border-radius:3px; cursor:pointer; font-size:13px;"
                onclick="return confirm('Verwijderen?')">Verwijder</button>
        </form>
    </div>
@endsection
