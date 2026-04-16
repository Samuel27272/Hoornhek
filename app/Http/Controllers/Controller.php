<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

abstract class Controller
{
    /**
     * Return a friendly response for database write failures.
     */
    protected function databaseError(Request $request): RedirectResponse|JsonResponse
    {
        $message = 'De gegevens konden niet worden opgeslagen. Controleer de invoer en probeer het opnieuw.';

        if ($request->expectsJson()) {
            return response()->json([
                'message' => $message,
            ], 500);
        }

        return back()
            ->withInput()
            ->withErrors([
                'database' => $message,
            ]);
    }
}
