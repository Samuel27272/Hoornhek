@extends('layouts.hekkensluiter')

@section('content')
    <div style="margin-bottom:8px; display:flex; justify-content:space-between; align-items:center;">
        <h2 style="margin:0; font-size:16px;">Gedetineerden</h2>
        <form method="GET" action="{{ route('gedetineerden.index') }}" style="display:flex; gap:6px; align-items:center;">
            <input name="q" placeholder="Zoeken..." value="{{ $q ?? '' }}"
                style="padding:4px 8px; width:120px; border:1px solid #ccc; border-radius:3px; font-size:13px;">
            <button type="submit"
                style="background:none; border:1px solid #ccc; width:20px; height:24px; cursor:pointer; border-radius:3px; padding:0;">×</button>

            @if (in_array(auth()->user()->rol, ['bewaker', 'developer']))
                <a href="{{ route('gedetineerden.create') }}"
                    style="background:none; border:1px solid #ccc; width:20px; height:24px; display:flex; align-items:center; justify-content:center; cursor:pointer; border-radius:3px; text-decoration:none; color:#111; font-weight:bold;">+</a>
            @endif
        </form>
    </div>

    @if (session('success'))
        <div
            style="color:#0a7d0a; background:#e8f5e9; padding:6px 8px; margin-bottom:8px; border-radius:3px; font-size:13px;">
            {{ session('success') }}</div>
    @endif

    <table>
        <thead>
            <tr>
                <th style="width:12%;">BSN-nummer</th>
                <th style="width:18%;">Naam</th>
                <th style="width:12%;">Geboortedatum</th>
                <th style="width:30%;">Adres</th>
                <th style="width:10%;">Cel nummer</th>
                <th style="width:18%;"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($gedetineerden as $g)
                <tr>
                    <td>{{ $g->bsn_nummer }}</td>
                    <td>{{ $g->voornaam }} {{ $g->achternaam }}</td>
                    <td>{{ $g->geboortedatum ? $g->geboortedatum->format('d-m-Y') : '' }}</td>
                    <td>{{ $g->straatnaam }} {{ $g->huisnummer }}</td>
                    <td>{{ optional($g->cel)->cel_nummer }}</td>
                    <td class="hs-actions-cell">
                        <a href="{{ route('gedetineerden.show', ['gedetineerden' => $g->id]) }}" class="hs-icon-btn"
                            title="Bekijk">👁</a>

                        @if (in_array(auth()->user()->rol, ['bewaker', 'developer']))
                            <a href="{{ route('gedetineerden.edit', ['gedetineerden' => $g->id]) }}" class="hs-icon-btn"
                                title="Bewerk">✎</a>
                            <form action="{{ route('gedetineerden.destroy', ['gedetineerden' => $g->id]) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="hs-icon-btn" title="Verwijder"
                                    onclick="return confirm('Verwijderen?')">🗑</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center; padding:20px; color:#999;">Geen gedetineerden gevonden.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top:10px; text-align:center; font-size:12px;">
        {{ $gedetineerden->links() }}
    </div>
@endsection
