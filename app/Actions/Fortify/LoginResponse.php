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
        $user = $request->user();

        if ($user->hasPermission('gedetineerden.view')) {
            return redirect()->intended(route('gedetineerden.index'));
        }

        if ($user->hasPermission('bezoekers.view')) {
            return redirect()->intended(route('bezoekers.index'));
        }

        return redirect()->intended('/dashboard');
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
