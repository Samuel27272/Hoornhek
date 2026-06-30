@extends('layouts.hekkensluiter')

@section('content')
    <div style="margin-bottom:16px;">
        <a href="{{ route('cellen.index') }}" style="text-decoration:none; color:#007bff;">← Terug naar cellen</a>
    </div>

    <h2 style="margin:0 0 16px 0; font-size:16px;">Cel: {{ $cel->cel_nummer }}</h2>

    <div style="background:#f9f9f9; padding:12px; border:1px solid #ddd; border-radius:3px; margin-bottom:16px;">
        <dl style="margin:0; font-size:13px;">
            <dt style="font-weight:bold; margin-top:8px;">Cel nummer:</dt>
            <dd style="margin:0 0 8px 0;">{{ $cel->cel_nummer }}</dd>

            <dt style="font-weight:bold; margin-top:8px;">Capaciteit:</dt>
            <dd style="margin:0 0 8px 0;">{{ $cel->capaciteit }}</dd>

            <dt style="font-weight:bold; margin-top:8px;">Status:</dt>
            <dd style="margin:0 0 8px 0;">{{ ucfirst(str_replace('_', ' ', $cel->status)) }}</dd>

            <dt style="font-weight:bold; margin-top:8px;">Opmerkingen:</dt>
            <dd style="margin:0 0 8px 0;">{{ $cel->opmerkingen ?? '—' }}</dd>

            <dt style="font-weight:bold; margin-top:8px;">Aantal gedetineerden:</dt>
            <dd style="margin:0 0 8px 0;">{{ $cel->gedetineerden->count() ?? 0 }}</dd>
        </dl>
    </div>

    <div style="display:flex; gap:8px; justify-content:center;">
        <a href="{{ route('cellen.edit', ['cel' => $cel->id]) }}"
            style="background:#007bff; color:white; border:none; padding:6px 12px; border-radius:3px; cursor:pointer; font-size:13px; text-decoration:none; display:inline-block;">Bewerk</a>
        <form action="{{ route('cellen.destroy', ['cel' => $cel->id]) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit"
                style="background:#dc3545; color:white; border:none; padding:6px 12px; border-radius:3px; cursor:pointer; font-size:13px;"
                onclick="return confirm('Verwijderen?')">Verwijder</button>
        </form>
    </div>
@endsection
