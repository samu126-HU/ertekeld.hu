<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Admins;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class IsMod
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            abort(401, "Jelentkezz be a folytatáshoz.");
        }

        $adminLevel = auth()->user()->isAdmin();
        Log::info('User admin level: ' . $adminLevel);

        if ($adminLevel >= Admins::MODERATOR) {
            return $next($request);
        }

        abort(403, "Nincs jogosultságod az oldal megtekintéséhez.");
    }
}
