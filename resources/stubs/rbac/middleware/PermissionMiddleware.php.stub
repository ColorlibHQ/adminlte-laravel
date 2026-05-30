<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    /**
     * Ensure the authenticated user has the given permission.
     *
     * Usage: ->middleware('permission:manage-projects')
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $user = $request->user();

        abort_unless($user !== null && $user->hasPermission($permission), 403);

        return $next($request);
    }
}
