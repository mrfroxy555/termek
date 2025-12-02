<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckEditor
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || !Auth::user()->canEdit()) {
            return redirect()->route('termekek.index')
                ->with('error', 'Nincs jogosultságod módosítani vagy törölni az adatokat.');
        }

        return $next($request);
    }
}