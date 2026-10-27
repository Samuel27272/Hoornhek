<?php

namespace App\Actions\Fortify;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     */
    public function toResponse($request)
    {
        return redirect()->intended($request->user()->determineHomeRoute());
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
