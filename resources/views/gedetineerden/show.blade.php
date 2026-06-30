@extends('layouts.hekkensluiter')

@section('buiten_panel')
    @if ($gedetineerde->foto_pad)
        <div style="margin-bottom:8px;">
            <img src="{{ Storage::url($gedetineerde->foto_pad) }}"
                style="width:150px; height:150px; object-fit:cover; border-radius:6px; border:1px solid #d1d5db;">
        </div>
    @endif
@endsection

@section('content')

    <div style="margin-bottom:16px;">
        <a href="{{ route('gedetineerden.index') }}" style="text-decoration:none; color:#007bff;">← Terug naar
            gedetineerden</a>
    </div>

    <h2 style="margin:0 0 16px 0; font-size:16px;">Gedetineerde: {{ $gedetineerde->voornaam }}
        {{ $gedetineerde->achternaam }}</h2>

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
            <dd style="margin:0 0 8px 0;">{{ $gedetineerde->straatnaam }} {{ $gedetineerde->huisnummer }},
                {{ $gedetineerde->postcode }} {{ $gedetineerde->woonplaats }}</dd>

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

    <h3
        style="margin: 24px 0 12px 0; font-size: 14px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #374151;">
        Gekoppelde zaken</h3>

    <div style="background:#f9f9f9; padding:12px; border:1px solid #ddd; border-radius:3px; margin-bottom:16px;">
        @if ($gedetineerde->zaken->isEmpty())
            <p style="font-size:13px; color:#6b7280; margin:0;">Geen zaken gekoppeld.</p>
        @else
            <table style="width:100%; border-collapse:collapse; font-size:13px;">
                <thead>
                    <tr style="border-bottom:1px solid #ddd;">
                        <th style="text-align:left; padding:6px 8px; font-weight:600;">Zaaknummer</th>
                        <th style="text-align:left; padding:6px 8px; font-weight:600;">Omschrijving</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($gedetineerde->zaken as $zaak)
                        <tr style="border-bottom:1px solid #f0f0f0;">
                            <td style="padding:6px 8px;">{{ $zaak->zaaknummer }}</td>
                            <td style="padding:6px 8px;">{{ $zaak->omschrijving }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <h3
        style="margin: 24px 0 12px 0; font-size: 14px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #374151;">
        Historie</h3>

    <div style="background:#f9f9f9; padding:12px; border:1px solid #ddd; border-radius:3px; margin-bottom:16px;">
        @if ($gedetineerde->historie->isEmpty())
            <p style="font-size:13px; color:#6b7280; margin:0;">Geen historie beschikbaar.</p>
        @else
            <table style="width:100%; border-collapse:collapse; font-size:13px;">
                <thead>
                    <tr style="border-bottom:1px solid #ddd;">
                        <th style="text-align:left; padding:6px 8px; font-weight:600;">Datum</th>
                        <th style="text-align:left; padding:6px 8px; font-weight:600;">Gebeurtenis</th>
                        <th style="text-align:left; padding:6px 8px; font-weight:600;">Oud</th>
                        <th style="text-align:left; padding:6px 8px; font-weight:600;">Nieuw</th>
                        <th style="text-align:left; padding:6px 8px; font-weight:600;">Uitgevoerd door</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($gedetineerde->historie as $record)
                        <tr style="border-bottom:1px solid #f0f0f0;">
                            <td style="padding:6px 8px;">{{ \Carbon\Carbon::parse($record->datum)->format('d-m-Y H:i') }}
                            </td>
                            <td style="padding:6px 8px;">{{ $record->gebeurtenis }}</td>
                            <td style="padding:6px 8px;">{{ $record->celOud->cel_nummer ?? '—' }}</td>
                            <td style="padding:6px 8px;">{{ $record->celNieuw->cel_nummer ?? '—' }}</td>
                            <td style="padding:6px 8px;">{{ $record->uitgevoerdDoor->name ?? '—' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <h3
        style="margin: 24px 0 12px 0; font-size: 14px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #374151;">
        Documenten</h3>

    {{-- Bestaande documenten --}}
    <div style="background:#f9f9f9; padding:12px; border:1px solid #ddd; border-radius:3px; margin-bottom:16px;">
        @if ($gedetineerde->documenten->isEmpty())
            <p style="font-size:13px; color:#6b7280; margin:0;">Geen documenten geüpload.</p>
        @else
            <table style="width:100%; border-collapse:collapse; font-size:13px;">
                <thead>
                    <tr style="border-bottom:1px solid #ddd;">
                        <th style="text-align:left; padding:6px 8px; font-weight:600;">Bestandsnaam</th>
                        <th style="text-align:left; padding:6px 8px; font-weight:600;">Type</th>
                        <th style="text-align:left; padding:6px 8px; font-weight:600;">Omschrijving</th>
                        <th style="text-align:left; padding:6px 8px; font-weight:600;">Geüpload door</th>
                        <th style="text-align:left; padding:6px 8px; font-weight:600;">Datum</th>
                        <th style="text-align:left; padding:6px 8px; font-weight:600;">Actie</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($gedetineerde->documenten as $document)
                        <tr style="border-bottom:1px solid #f0f0f0;">
                            <td style="padding:6px 8px;">
                                <a href="{{ Storage::url($document->bestand_pad) }}"
                                    target="_blank">{{ $document->bestandsnaam }}</a>
                            </td>
                            <td style="padding:6px 8px;">{{ ucfirst(str_replace('_', ' ', $document->type)) }}</td>
                            <td style="padding:6px 8px;">{{ $document->omschrijving ?? '—' }}</td>
                            <td style="padding:6px 8px;">{{ $document->geuploadDoor->name ?? '—' }}</td>
                            <td style="padding:6px 8px;">{{ $document->created_at->format('d-m-Y H:i') }}</td>
                            <td style="padding:6px 8px;">
                                @if (auth()->user()->hasPermission('documenten.delete'))
                                    <form
                                        action="{{ route('gedetineerden.documenten.destroy', [$gedetineerde, $document]) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Verwijderen?')"
                                            style="background:#dc3545; color:white; border:none; padding:4px 8px; border-radius:3px; cursor:pointer; font-size:12px;">Verwijder</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    {{-- Upload formulier --}}
    @if (auth()->user()->hasPermission('documenten.upload'))
        <div style="background:#f9f9f9; padding:12px; border:1px solid #ddd; border-radius:3px; margin-bottom:16px;">
            <span style="font-size:13px; font-weight:700; display:block; margin-bottom:12px;">Document uploaden</span>
            @if ($errors->any())
                <div
                    style="background:#fee2e2; border:1px solid #fca5a5; border-radius:3px; padding:10px 12px; margin-bottom:12px;">
                    @foreach ($errors->all() as $error)
                        <p style="font-size:13px; color:#dc2626; margin:0;">{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            <form action="{{ route('gedetineerden.documenten.store', $gedetineerde) }}" method="POST"
                enctype="multipart/form-data">
                @csrf

                <div style="margin-bottom:12px;">
                    <label style="font-size:13px; font-weight:600; display:block; margin-bottom:4px;">Type</label>
                    <select name="type"
                        style="padding:8px 12px; border:1px solid #d1d5db; border-radius:6px; font-size:13px; width:100%; cursor:pointer;">
                        @if (auth()->user()->hasPermission('documenten.upload'))
                            <option value="gespreksverslag">Gespreksverslag</option>
                        @endif
                        @if (auth()->user()->hasPermission('gedetineerden.edit'))
                            <option value="bewijs_document">Bewijs document</option>
                            <option value="bewijs_foto">Bewijs foto</option>
                            <option value="bewijs_video">Bewijs video</option>
                            <option value="overig">Overig</option>
                        @endif
                    </select>
                </div>

                <div style="margin-bottom:12px;">
                    <label style="font-size:13px; font-weight:600; display:block; margin-bottom:4px;">Bestand</label>
                    <label for="bestand"
                        style="display:inline-block; padding:6px 12px; background:#6c757d; color:white; border-radius:3px; cursor:pointer; font-size:13px;">Bestand
                        kiezen</label>
                    <input type="file" name="bestand" id="bestand" style="display:none;" required
                        onchange="document.getElementById('bestandsnaam').textContent = this.files[0]?.name ?? 'Geen bestand gekozen'">
                    <span id="bestandsnaam" style="font-size:13px; color:#6b7280; margin-left:8px;">Geen bestand
                        gekozen</span>
                </div>

                <div style="margin-bottom:12px;">
                    <label style="font-size:13px; font-weight:600; display:block; margin-bottom:4px;">Omschrijving</label>
                    <textarea name="omschrijving"
                        style="padding:8px 12px; border:1px solid #d1d5db; border-radius:6px; font-size:13px; width:100%; min-height:80px; resize:vertical;"></textarea>
                </div>

                <button type="submit"
                    style="background:#007bff; color:white; border:none; padding:6px 12px; border-radius:3px; cursor:pointer; font-size:13px;">Uploaden</button>
            </form>
        </div>
    @endif

    <div style="display:flex; gap:8px; justify-content:center;">
        @if (auth()->user()->hasPermission('gedetineerden.edit'))
            <a href="{{ route('gedetineerden.edit', ['gedetineerden' => $gedetineerde->id]) }}"
                style="background:#007bff; color:white; border:none; padding:6px 12px; border-radius:3px; cursor:pointer; font-size:13px; text-decoration:none; display:inline-block;">Bewerk</a>
        @endif

        @if (auth()->user()->hasPermission('gedetineerden.ontslaan'))
            @if ($gedetineerde->status === 'actief')
                <form action="{{ route('gedetineerden.ontslaan', $gedetineerde) }}" method="POST"
                    style="display:inline;">
                    @csrf
                    @method('PATCH')
                    <button type="submit" onclick="return confirm('Gedetineerde ontslaan?')"
                        style="background:#fd7e14; color:white; border:none; padding:6px 12px; border-radius:3px; cursor:pointer; font-size:13px;">Ontslaan</button>
                </form>
            @else
                <form action="{{ route('gedetineerden.herplaatsen', $gedetineerde) }}" method="POST"
                    style="display:inline;">
                    @csrf
                    @method('PATCH')
                    <button type="submit" onclick="return confirm('Gedetineerde opnieuw activeren?')"
                        style="background:#28a745; color:white; border:none; padding:6px 12px; border-radius:3px; cursor:pointer; font-size:13px;">Activeren</button>
                </form>
            @endif
        @endif

        @if (auth()->user()->hasPermission('gedetineerden.delete'))
            <form action="{{ route('gedetineerden.destroy', ['gedetineerden' => $gedetineerde->id]) }}" method="POST"
                style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit"
                    style="background:#dc3545; color:white; border:none; padding:6px 12px; border-radius:3px; cursor:pointer; font-size:13px;"
                    onclick="return confirm('Verwijderen?')">Verwijder</button>
            </form>
        @endif
    </div>

@endsection
