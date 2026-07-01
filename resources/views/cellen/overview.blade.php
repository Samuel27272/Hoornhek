@extends('layouts.hekkensluiter')

@section('content')
    <div style="margin-bottom:16px; display:flex; justify-content:space-between; align-items:center;">
        <h2 style="margin:0; font-size:16px;">Celbezetting</h2>
        <a href="{{ route('cellen.index') }}" style="text-decoration:none; color:#007bff; font-size:13px;">← Terug naar
            lijst</a>
    </div>

    <div style="display:flex; gap:16px; margin-bottom:20px; font-size:13px;">
        <div style="display:flex; align-items:center; gap:6px;">
            <span style="width:14px; height:14px; background:#28a745; border-radius:3px; display:inline-block;"></span> Vrij
        </div>
        <div style="display:flex; align-items:center; gap:6px;">
            <span style="width:14px; height:14px; background:#dc3545; border-radius:3px; display:inline-block;"></span> Bezet
        </div>
        <div style="display:flex; align-items:center; gap:6px;">
            <span style="width:14px; height:14px; background:#6c757d; border-radius:3px; display:inline-block;"></span>
            Buiten gebruik
        </div>
    </div>

    @foreach ($cellen as $block => $cellenInBlock)
        <div style="margin-bottom:24px;">
            <h3
                style="font-size:14px; font-weight:700; text-transform:uppercase; letter-spacing:0.5px; color:#374151; margin-bottom:10px;">
                Blok {{ $block }}
            </h3>

            <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(110px, 1fr)); gap:12px;">
                @foreach ($cellenInBlock as $cel)
                    @php
                        $color = match ($cel->status) {
                            'beschikbaar' => '#28a745',
                            'bezet' => '#dc3545',
                            'buiten_gebruik' => '#6c757d',
                            default => '#ccc',
                        };
                    @endphp
                    <a href="{{ route('cellen.show', $cel) }}" style="text-decoration:none; color:inherit;">
                        <div style="background:{{ $color }}; color:white; border-radius:6px; padding:12px; text-align:center; transition:opacity 0.15s;"
                            onmouseover="this.style.opacity=0.85" onmouseout="this.style.opacity=1">
                            <div style="font-weight:700; font-size:14px;">{{ $cel->cel_nummer }}</div>
                            <div style="font-size:11px; margin-top:4px;">
                                {{ $cel->gedetineerden_count }}/{{ $cel->capaciteit }}
                            </div>
                            <div style="font-size:11px; margin-top:2px; text-transform:capitalize;">
                                {{ str_replace('_', ' ', $cel->status) }}
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endforeach
@endsection
