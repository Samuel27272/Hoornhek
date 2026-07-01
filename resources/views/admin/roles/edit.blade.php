@extends('layouts.hekkensluiter')

@section('content')
    <h2 style="margin:0 0 16px 0; font-size:16px;">Rechten bewerken: {{ $role->display_name }}</h2>

    @if (session('success'))
        <div
            style="color:#0a7d0a; background:#e8f5e9; padding:6px 8px; margin-bottom:8px; border-radius:3px; font-size:13px;">
            {{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.roles.update', $role) }}" style="max-width:600px; margin:0 auto;">
        @csrf
        @method('PUT')
        <link rel="stylesheet" href="{{ asset('css/_form.css') }}">
        <div class="form-container">
            @foreach ($permissionsPerGroep as $groep => $permissions)
                <div class="form-section">
                    <span class="form-section-title">{{ $groep }}</span>
                    @foreach ($permissions as $permission)
                        <div style="display:flex; align-items:center; gap:8px; margin-bottom:8px;">
                            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                id="perm_{{ $permission->id }}"
                                {{ $role->permissions->contains($permission->id) ? 'checked' : '' }}>
                            <label for="perm_{{ $permission->id }}"
                                style="margin-bottom:0; font-weight:400; font-size:13px;">
                                {{ $permission->display_name }}
                            </label>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>

        <div style="margin-top:16px; display:flex; gap:8px; justify-content:center;">
            <button type="submit"
                style="background:#007bff; color:white; border:none; padding:6px 12px; border-radius:3px; cursor:pointer; font-size:13px;">Opslaan</button>
            <a href="{{ route('admin.roles.index') }}"
                style="background:#666; color:white; border:none; padding:6px 12px; border-radius:3px; cursor:pointer; font-size:13px; text-decoration:none; display:inline-block;">Annuleren</a>
        </div>
    </form>
@endsection
