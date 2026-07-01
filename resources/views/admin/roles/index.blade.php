@extends('layouts.hekkensluiter')

@section('content')
    <div style="margin-bottom:8px; display:flex; justify-content:space-between; align-items:center;">
        <h2 style="margin:0; font-size:16px;">Rollen</h2>
        <a href="{{ route('admin.roles.create') }}"
            style="background:none; border:1px solid #ccc; width:20px; height:24px; display:flex; align-items:center; justify-content:center; cursor:pointer; border-radius:3px; text-decoration:none; color:#111; font-weight:bold;">+</a>
    </div>

    @if (session('success'))
        <div
            style="color:#0a7d0a; background:#e8f5e9; padding:6px 8px; margin-bottom:8px; border-radius:3px; font-size:13px;">
            {{ session('success') }}</div>
    @endif

    <table>
        <thead>
            <tr>
                <th style="width:25%;">Naam</th>
                <th style="width:35%;">Weergavenaam</th>
                <th style="width:25%;">Aantal rechten</th>
                <th style="width:15%;"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($roles as $role)
                <tr>
                    <td>{{ $role->name }}</td>
                    <td>{{ $role->display_name }}</td>
                    <td>{{ $role->permissions->count() }}</td>
                    <td class="hs-actions-cell">
                        <a href="{{ route('admin.roles.edit', $role) }}" class="hs-icon-btn" title="Bewerk rechten">✎</a>
                        @if (auth()->user()->hasPermission('roles.delete'))
                            <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="hs-icon-btn" title="Verwijder"
                                    onclick="return confirm('Weet je zeker dat je deze rol wilt verwijderen?')">🗑</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align:center; padding:20px; color:#999;">Geen rollen gevonden.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
