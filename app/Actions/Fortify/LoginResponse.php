<?php

namespace App\Actions\Fortify;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     */
    public function toResponse($request)
    {
        $redirect = route_exists('gedetineerden.index') ? route('gedetineerden.index') : route('dashboard');

        return redirect()->intended($redirect ?: '/');
    }
}

function route_exists(string $name): bool
{
    try {
        return (bool) route($name, [], false);
    } catch (\Exception $e) {
        return false;
    }
}
