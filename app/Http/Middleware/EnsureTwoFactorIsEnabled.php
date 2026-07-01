<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureTwoFactorIsEnabled
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user && ! $user->two_factor_confirmed_at) {
            if (! $request->routeIs('two-factor.settings', 'logout')) {
                return redirect()->route('two-factor.settings')
                    ->with('error', 'Je moet eerst twee-factorauthenticatie instellen voordat je verder kunt.');
            }
        }

        return $next($request);
    }
}
