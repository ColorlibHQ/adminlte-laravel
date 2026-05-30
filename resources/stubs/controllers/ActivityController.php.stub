<?php

namespace App\Http\Controllers\AdminLte;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    /**
     * The activity log viewer. This is auth-only by default; restrict it further
     * by gating the route with `permission:view-activity` (RBAC) or a Gate, and
     * by gating its sidebar menu item with 'can' => 'view-activity'.
     */
    public function index(Request $request): View
    {
        $activities = Activity::with('user')
            ->latest('created_at')
            ->paginate(30);

        return view('adminlte.activity.index', compact('activities'));
    }
}
