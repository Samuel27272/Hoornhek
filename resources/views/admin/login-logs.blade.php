@extends('layouts.hekkensluiter')

@section('content')
    <h2 style="margin: 0 0 16px 0; font-size: 16px">In- en uitlog activiteiten</h2>

    <table>
        <thead>
            <tr>
                <th style="width: 25%">Datum/tijd</th>
                <th style="width: 25%">Gebruiker</th>
                <th style="width: 25%">Email</th>
                <th style="width: 25%">Gebeurtenis</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($logs as $log)
                <tr>
                    <td>{{ $log->created_at->format('d-m-Y H:i:s') }}</td>
                    <td>{{ $log->user->name ?? '—' }}</td>
                    <td>{{ $log->email }}</td>
                    <td>
                        @if ($log->event === 'login')
                            <span style="color: #0a7d0a; font-weight: 600">Ingelogd</span>
                        @elseif ($log->event === 'logout')
                            <span style="color: #555; font-weight: 600">Uitgelogd</span>
                        @else
                            <span style="color: #c62828; font-weight: 600">Mislukte poging</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center; padding: 20px; color: #999">Geen logs gevonden.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 10px; text-align: center; font-size: 12px">{{ $logs->links() }}</div>
@endsection
