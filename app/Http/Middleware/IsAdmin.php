<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Admins;
use Log;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            abort(401, "Jelentkezz be a folytatáshoz.");
        }

        $adminLevel = auth()->user()->isAdmin();
        Log::info('User admin level: ' . $adminLevel);

        if ($adminLevel >= Admins::ADMIN) {
            return $next($request);
        }

        abort(403, "Nincs jogosultságod az oldal megtekintéséhez.");
    }
}
