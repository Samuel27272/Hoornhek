<?php

namespace App\Actions\Fortify;

use Laravel\Fortify\Contracts\TwoFactorLoginResponse as TwoFactorLoginResponseContract;

class TwoFactorLoginResponse implements TwoFactorLoginResponseContract
{
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
