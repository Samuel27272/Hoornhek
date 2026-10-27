@extends('layouts.hekkensluiter')

@section('content')
    <h2 style="margin: 0 0 16px 0; font-size: 16px">Beheermodule</h2>

    <div style="display: flex; gap: 12px; flex-wrap: wrap">
        @if (auth()->user()->hasPermission('users.view'))
            <a
                href="{{ route('admin.users.index') }}"
                style="
                    background: #007bff;
                    color: white;
                    padding: 12px 20px;
                    border-radius: 3px;
                    text-decoration: none;
                    font-size: 13px;
                "
            >
                Gebruikersbeheer
            </a>
        @endif
        @if (auth()->user()->hasPermission('roles.view'))
            <a
                href="{{ route('admin.roles.index') }}"
                style="
                    background: #007bff;
                    color: white;
                    padding: 12px 20px;
                    border-radius: 3px;
                    text-decoration: none;
                    font-size: 13px;
                "
            >
                Rollenbeheer
            </a>
        @endif
        @if (auth()->user()->hasPermission('logs.view'))
            <a
                href="{{ route('admin.login-logs.index') }}"
                style="
                    background: #007bff;
                    color: white;
                    padding: 12px 20px;
                    border-radius: 3px;
                    text-decoration: none;
                    font-size: 13px;
                "
            >
                Login logs
            </a>
        @endif
    </div>
@endsection
