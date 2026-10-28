<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, string ...$rollen): mixed
    {
        if (! Auth::check() || ! in_array(Auth::user()->role, $rollen)) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->with('error', 'Je hebt geen toegang tot deze pagina.');
        }

        return $next($request);
    }
}
