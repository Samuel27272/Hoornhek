@extends('layouts.hekkensluiter')

@section('content')

<h2 style="margin:0 0 16px 0; font-size:16px;">Bezoeker wijzigen</h2>

@if ($errors->any())
    <div style="color:#d32f2f; background:#ffebee; padding:8px 12px; margin-bottom:12px; border-radius:3px; border-left:4px solid #d32f2f; font-size:13px;">
        <strong>Validatiefouten:</strong>
        <ul style="margin:6px 0 0 20px; padding:0;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('bezoekers.update', ['bezoeker' => $bezoeker->id]) }}" method="POST">
    @csrf
    @method('PUT')
    @include('bezoekers._form')
    <div style="margin-top:16px; display:flex; gap:8px; justify-content:center;">
        <button type="submit" style="background:#007bff; color:white; border:none; padding:6px 12px; border-radius:3px; cursor:pointer; font-size:13px;">Opslaan</button>
        <a href="{{ route('bezoekers.index') }}" style="background:#666; color:white; border:none; padding:6px 12px; border-radius:3px; cursor:pointer; font-size:13px; text-decoration:none; display:inline-block;">Annuleren</a>
    </div>
</form>

@endsection
