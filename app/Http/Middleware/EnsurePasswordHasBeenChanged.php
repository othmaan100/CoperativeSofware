<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsurePasswordHasBeenChanged
{
    /**
     * The one route a flagged user must still be able to reach: the
     * change-password page itself. (Logout is a Livewire action, not a
     * route, so it's already covered by the livewire/* passthrough below.)
     */
    protected const ALLOWED_ROUTE_NAMES = [
        'password.force-change',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (! $user || ! $user->must_change_password) {
            return $next($request);
        }

        if (in_array($request->route()?->getName(), self::ALLOWED_ROUTE_NAMES, true)) {
            return $next($request);
        }

        if ($request->is('livewire/*')) {
            return $next($request);
        }

        return redirect()->route('password.force-change');
    }
}
