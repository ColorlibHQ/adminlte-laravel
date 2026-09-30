<?php

namespace App\Http\Controllers\AdminLte;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ActivityController extends Controller
{
    /**
     * The activity log viewer. It lists every user's sign-ins, IP addresses and
     * recorded changes, so it requires the `view-activity` ability: with RBAC,
     * admins and roles holding the `view-activity` permission; without RBAC, any
     * signed-in user (define your own `view-activity` gate to change that). Gate
     * the sidebar menu item with 'can' => 'view-activity' as well.
     */
    public function index(Request $request): View
    {
        Gate::authorize('view-activity');

        $activities = Activity::with('user')
            ->latest('created_at')
            ->paginate(30);

        return view('adminlte.activity.index', compact('activities'));
    }
}
