<?php

namespace App\Actions\Fortify;

use Laravel\Fortify\Contracts\TwoFactorLoginResponse as TwoFactorLoginResponseContract;

class TwoFactorLoginResponse implements TwoFactorLoginResponseContract
{
    public function toResponse($request)
    {
        return redirect()->intended($request->user()->determineHomeRoute());
    }
}
