@extends('layouts.hekkensluiter')

@section('content')

<div style="margin-bottom:16px;">
    <a href="{{ route('bezoekers.index') }}" style="text-decoration:none; color:#007bff;">← Terug naar bezoekers</a>
</div>

<h2 style="margin:0 0 16px 0; font-size:16px;">Bezoeker: {{ $bezoeker->voornaam }} {{ $bezoeker->achternaam }}</h2>

<div style="background:#f9f9f9; padding:12px; border:1px solid #ddd; border-radius:3px; margin-bottom:16px;">
    <dl style="margin:0; font-size:13px;">
        <dt style="font-weight:bold; margin-top:8px;">Voornaam:</dt>
        <dd style="margin:0 0 8px 0;">{{ $bezoeker->voornaam }}</dd>

        <dt style="font-weight:bold; margin-top:8px;">Achternaam:</dt>
        <dd style="margin:0 0 8px 0;">{{ $bezoeker->achternaam }}</dd>

        <dt style="font-weight:bold; margin-top:8px;">Telefoonnummer:</dt>
        <dd style="margin:0 0 8px 0;">{{ $bezoeker->telefoonnummer ?? '—' }}</dd>

        <dt style="font-weight:bold; margin-top:8px;">Email:</dt>
        <dd style="margin:0 0 8px 0;">{{ $bezoeker->email ?? '—' }}</dd>

        <dt style="font-weight:bold; margin-top:8px;">Start bezoek:</dt>
        <dd style="margin:0 0 8px 0;">{{ $bezoeker->start_bezoek ? $bezoeker->start_bezoek->format('d-m-Y H:i') : '—' }}</dd>

        <dt style="font-weight:bold; margin-top:8px;">Status:</dt>
        <dd style="margin:0 0 8px 0;">{{ ucfirst(str_replace('_', ' ', $bezoeker->status)) }}</dd>
    </dl>
</div>

<div style="display:flex; gap:8px; justify-content:center;">
    <a href="{{ route('bezoekers.edit', ['bezoeker' => $bezoeker->id]) }}" style="background:#007bff; color:white; border:none; padding:6px 12px; border-radius:3px; cursor:pointer; font-size:13px; text-decoration:none; display:inline-block;">Bewerk</a>
    <form action="{{ route('bezoekers.destroy', ['bezoeker' => $bezoeker->id]) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" style="background:#dc3545; color:white; border:none; padding:6px 12px; border-radius:3px; cursor:pointer; font-size:13px;" onclick="return confirm('Verwijderen?')">Verwijder</button>
    </form>
</div>

@endsection
