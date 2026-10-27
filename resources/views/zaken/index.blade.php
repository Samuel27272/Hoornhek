@extends('layouts.hekkensluiter')

@section('content')
    <div style="margin-bottom: 8px; display: flex; justify-content: space-between; align-items: center">
        <h2 style="margin: 0; font-size: 16px">Zaken</h2>
        <form method="GET" action="{{ route('zaken.index') }}" style="display: flex; gap: 6px; align-items: center">
            <input
                name="q"
                placeholder="Zoeken..."
                value="{{ $q ?? '' }}"
                style="padding: 4px 8px; width: 120px; border: 1px solid #ccc; border-radius: 3px; font-size: 13px"
            />
            <button
                type="submit"
                style="
                    background: none;
                    border: 1px solid #ccc;
                    width: 20px;
                    height: 24px;
                    cursor: pointer;
                    border-radius: 3px;
                    padding: 0;
                "
            >
                ×
            </button>
            @if (auth()->user()->hasPermission('zaken.create'))
                <a
                    href="{{ route('zaken.create') }}"
                    style="
                        background: none;
                        border: 1px solid #ccc;
                        width: 20px;
                        height: 24px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        cursor: pointer;
                        border-radius: 3px;
                        text-decoration: none;
                        color: #111;
                        font-weight: bold;
                    "
                >+</a>
            @endif
        </form>
    </div>

    @if (session('success'))
        <div
            style="
                color: #0a7d0a;
                background: #e8f5e9;
                padding: 6px 8px;
                margin-bottom: 8px;
                border-radius: 3px;
                font-size: 13px;
            "
        >
            {{ session('success') }}
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th style="width: 15%">Zaak nummer</th>
                <th style="width: 25%">Omschrijving</th>
                <th style="width: 15%">Misdaad type</th>
                <th style="width: 12%">Status</th>
                <th style="width: 15%">Aangemaakt</th>
                <th style="width: 18%"></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($zaken as $z)
                <tr>
                    <td>{{ $z->zaaknummer }}</td>
                    <td>{{ $z->omschrijving }}</td>
                    <td>{{ $z->misdaad_type ?? '—' }}</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $z->status)) }}</td>
                    <td>{{ $z->datum_aangemaakt->format('d-m-Y') }}</td>
                    <td class="hs-actions-cell">
                        <a href="{{ route('zaken.show', ['zaak' => $z->id]) }}" class="hs-icon-btn" title="Bekijk">👁</a>
                        @if (auth()->user()->hasPermission('zaken.edit'))
                            <a href="{{ route('zaken.edit', ['zaak' => $z->id]) }}" class="hs-icon-btn" title="Bewerk"
                                >✎</a>
                        @endif
                        @if (auth()->user()->hasPermission('zaken.delete'))
                            <form
                                action="{{ route('zaken.destroy', ['zaak' => $z->id]) }}"
                                method="POST"
                                style="display: inline"
                            >
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    class="hs-icon-btn"
                                    title="Verwijder"
                                    onclick="return confirm('Verwijderen?');"
                                >
                                    🗑
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 20px; color: #999">Geen zaken gevonden.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 10px; text-align: center; font-size: 12px">{{ $zaken->links() }}</div>
@endsection
