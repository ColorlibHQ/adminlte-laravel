<?php

namespace App\Http\Controllers\AdminLte;

use App\Http\Controllers\Controller;
use App\Models\User;
use ColorlibHQ\AdminLte\Support\ActivityLogger;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class ImpersonationController extends Controller
{
    use AuthorizesRequests;

    /**
     * Begin impersonating another user. Authorized via the `impersonate` ability
     * — admins pass through the package's Gate::before, or grant an `impersonate`
     * permission to a role (see authorization docs).
     */
    public function start(Request $request, User $user): RedirectResponse
    {
        $this->authorize('impersonate');

        // Don't impersonate yourself or stack impersonations.
        if ($request->session()->has('impersonator_id') || $user->is($request->user())) {
            return redirect()->back();
        }

        $request->session()->put('impersonator_id', $request->user()->getAuthIdentifier());

        ActivityLogger::log('impersonate.start', 'Started impersonating '.$user->name, [
            'target_id' => $user->getKey(),
        ]);

        Auth::login($user);

        return redirect('/');
    }

    /**
     * Return to the original (impersonating) user.
     */
    public function stop(Request $request): RedirectResponse
    {
        $impersonatorId = $request->session()->pull('impersonator_id');

        if (! $impersonatorId) {
            return redirect('/');
        }

        $impersonator = User::find($impersonatorId);

        if ($impersonator) {
            Auth::login($impersonator);
            ActivityLogger::log('impersonate.stop', 'Stopped impersonating', [], null, (int) $impersonatorId);
        }

        return redirect()->to(Route::has('adminlte.users.index') ? route('adminlte.users.index') : '/');
    }
}
