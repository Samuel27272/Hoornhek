@extends('layouts.hekkensluiter')

@section('content')

<div style="margin-bottom:16px;">
    <a href="{{ route('gedetineerden.index') }}" style="text-decoration:none; color:#007bff;">← Terug naar gedetineerden</a>
</div>

<h2 style="margin:0 0 16px 0; font-size:16px;">Gedetineerde: {{ $gedetineerde->voornaam }} {{ $gedetineerde->achternaam }}</h2>

<div style="background:#f9f9f9; padding:12px; border:1px solid #ddd; border-radius:3px; margin-bottom:16px;">
    <dl style="margin:0; font-size:13px;">
        <dt style="font-weight:bold; margin-top:8px;">BSN-nummer:</dt>
        <dd style="margin:0 0 8px 0;">{{ $gedetineerde->bsn_nummer }}</dd>

        <dt style="font-weight:bold; margin-top:8px;">Voornaam:</dt>
        <dd style="margin:0 0 8px 0;">{{ $gedetineerde->voornaam }}</dd>

        <dt style="font-weight:bold; margin-top:8px;">Achternaam:</dt>
        <dd style="margin:0 0 8px 0;">{{ $gedetineerde->achternaam }}</dd>

        <dt style="font-weight:bold; margin-top:8px;">Geboortedatum:</dt>
        <dd style="margin:0 0 8px 0;">{{ $gedetineerde->geboortedatum?->format('d-m-Y') }}</dd>

        <dt style="font-weight:bold; margin-top:8px;">Adres:</dt>
        <dd style="margin:0 0 8px 0;">{{ $gedetineerde->straatnaam }} {{ $gedetineerde->huisnummer }}, {{ $gedetineerde->postcode }} {{ $gedetineerde->woonplaats }}</dd>

        <dt style="font-weight:bold; margin-top:8px;">Telefoonnummer:</dt>
        <dd style="margin:0 0 8px 0;">{{ $gedetineerde->telefoonnummer ?? '—' }}</dd>

        <dt style="font-weight:bold; margin-top:8px;">Email:</dt>
        <dd style="margin:0 0 8px 0;">{{ $gedetineerde->email ?? '—' }}</dd>

        <dt style="font-weight:bold; margin-top:8px;">Aanhoudingsdatum:</dt>
        <dd style="margin:0 0 8px 0;">{{ $gedetineerde->aanhoudingsdatum?->format('d-m-Y') }}</dd>

        <dt style="font-weight:bold; margin-top:8px;">Schorsing datum:</dt>
        <dd style="margin:0 0 8px 0;">{{ $gedetineerde->datum_schorsing?->format('d-m-Y') ?? '—' }}</dd>

        <dt style="font-weight:bold; margin-top:8px;">Status:</dt>
        <dd style="margin:0 0 8px 0;">{{ ucfirst($gedetineerde->status) }}</dd>

        <dt style="font-weight:bold; margin-top:8px;">Cel:</dt>
        <dd style="margin:0 0 8px 0;">{{ optional($gedetineerde->cel)->cel_nummer ?? '—' }}</dd>

        <dt style="font-weight:bold; margin-top:8px;">Opmerkingen:</dt>
        <dd style="margin:0 0 8px 0;">{{ $gedetineerde->opmerkingen ?? '—' }}</dd>
    </dl>
</div>

<div style="display:flex; gap:8px;">
    <a href="{{ route('gedetineerden.edit', ['gedetineerden' => $gedetineerde->id]) }}" style="background:#007bff; color:white; border:none; padding:6px 12px; border-radius:3px; cursor:pointer; font-size:13px; text-decoration:none; display:inline-block;">Bewerk</a>
    <form action="{{ route('gedetineerden.destroy', ['gedetineerden' => $gedetineerde->id]) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" style="background:#dc3545; color:white; border:none; padding:6px 12px; border-radius:3px; cursor:pointer; font-size:13px;" onclick="return confirm('Verwijderen?')">Verwijder</button>
    </form>
</div>

@endsection
