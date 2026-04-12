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

        $rol = $request->user()->rol ?? null;

        $redirect = match($rol) {
            'portier'                    => route('bezoekers.index'),
            'maatschappelijk_werker' => route('gedetineerden.index'),
            'bewaker'                    => route('gedetineerden.index'),
            'developer'                  => route('gedetineerden.index'),
            default                      => '/dashboard',
        };

        return redirect()->intended($redirect);
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
