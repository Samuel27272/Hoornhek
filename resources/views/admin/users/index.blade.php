@extends('layouts.hekkensluiter')

@section('content')
    <div style="margin-bottom: 8px; display: flex; justify-content: space-between; align-items: center">
        <h2 style="margin: 0; font-size: 16px">Gebruikers</h2>
        @if (auth()->user()->hasPermission('users.create'))
            <a
                href="{{ route('admin.users.create') }}"
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
    @if (session('error'))
        <div
            style="
                color: #c62828;
                background: #ffebee;
                padding: 6px 8px;
                margin-bottom: 8px;
                border-radius: 3px;
                font-size: 13px;
            "
        >
            {{ session('error') }}
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th style="width: 25%">Naam</th>
                <th style="width: 30%">Email</th>
                <th style="width: 20%">Rol</th>
                <th style="width: 25%"></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role?->display_name ?? '—' }}</td>
                    <td class="hs-actions-cell">
                        @if (auth()->user()->hasPermission('users.edit'))
                            <a href="{{ route('admin.users.edit', $user) }}" class="hs-icon-btn" title="Bewerk">✎</a>
                        @endif
                        @if (auth()->user()->hasPermission('users.delete') && $user->id !== auth()->id())
                            <form
                                action="{{ route('admin.users.destroy', $user) }}"
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
                    <td colspan="4" style="text-align: center; padding: 20px; color: #999">
                        Geen gebruikers gevonden.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 10px; text-align: center; font-size: 12px">{{ $users->links() }}</div>
@endsection
