<?php

namespace ColorlibHQ\AdminLte\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Renders the bundled demo pages with the full user-menu chrome.
 *
 * The `usermenu_*` keys all ship `false`, so a fresh install gets the plain
 * dropdown and opts in to the rest. The demo pages exist to mirror the
 * AdminLTE showcase, which has the coloured header block and the 90px avatar —
 * so they turn those on for themselves. Demo requests only; the consuming
 * app's own pages keep whatever its config says.
 *
 * `usermenu_profile_url` is deliberately left alone: there is no profile page
 * to link to until the app runs `adminlte:scaffold profile`, and pointing the
 * showcase at a 404 is what this stopped doing.
 */
class DemoUserMenu
{
    /**
     * @param  Closure(Request): Response  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        config([
            'adminlte.usermenu_header' => true,
            'adminlte.usermenu_image' => true,
            'adminlte.usermenu_desc' => true,
        ]);

        return $next($request);
    }
}
