<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureProfileIsComplete
{
    /**
     * The one route a flagged member must still be able to reach: the
     * complete-profile page itself. (Logout is a Livewire action, not a
     * route, so it's already covered by the livewire/* passthrough below.)
     */
    protected const ALLOWED_ROUTE_NAMES = [
        'profile.complete',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Let a still-pending forced password change resolve first.
        if (! $user || $user->must_change_password) {
            return $next($request);
        }

        $member = $user->member;

        if (! $member || $member->hasCompleteProfile()) {
            return $next($request);
        }

        if (in_array($request->route()?->getName(), self::ALLOWED_ROUTE_NAMES, true)) {
            return $next($request);
        }

        if ($request->is('livewire/*')) {
            return $next($request);
        }

        return redirect()->route('profile.complete');
    }
}
