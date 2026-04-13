@extends('layouts.hekkensluiter')

@section('content')
    <div style="margin-bottom:8px; display:flex; justify-content:space-between; align-items:center;">
        <h2 style="margin:0; font-size:16px;">Cellen</h2>
        <form method="GET" action="{{ route('cellen.index') }}" style="display:flex; gap:6px; align-items:center;">
            <input name="q" placeholder="Zoeken..." value="{{ $q ?? '' }}"
                style="padding:4px 8px; width:120px; border:1px solid #ccc; border-radius:3px; font-size:13px;">
            <button type="submit"
                style="background:none; border:1px solid #ccc; width:20px; height:24px; cursor:pointer; border-radius:3px; padding:0;">×</button>
            <a href="{{ route('cellen.create') }}"
                style="background:none; border:1px solid #ccc; width:20px; height:24px; display:flex; align-items:center; justify-content:center; cursor:pointer; border-radius:3px; text-decoration:none; color:#111; font-weight:bold;">+</a>
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
                <th style="width:15%;">Cel nummer</th>
                <th style="width:12%;">Capaciteit</th>
                <th style="width:20%;">Status</th>
                <th style="width:40%;">Opmerkingen</th>
                <th style="width:13%;"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($cellen as $c)
                <tr>
                    <td>{{ $c->cel_nummer }}</td>
                    <td>{{ $c->capaciteit }}</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $c->status)) }}</td>
                    <td>{{ substr($c->opmerkingen ?? '', 0, 60) }}</td>
                    <td class="hs-actions-cell">
                        <a href="{{ route('cellen.show', ['cellen' => $c->id]) }}" class="hs-icon-btn" title="Bekijk">👁</a>
                        <a href="{{ route('cellen.edit', ['cellen' => $c->id]) }}" class="hs-icon-btn" title="Bewerk">✎</a>
                        <form action="{{ route('cellen.destroy', ['cellen' => $c->id]) }}" method="POST"
                            style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="hs-icon-btn" title="Verwijder"
                                onclick="return confirm('Verwijderen?')">🗑</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align:center; padding:20px; color:#999;">Geen cellen gevonden.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top:10px; text-align:center; font-size:12px;">
        {{ $cellen->links() }}
    </div>
@endsection
