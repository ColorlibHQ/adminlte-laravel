<?php

namespace App\Http\Controllers\AdminLte;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    /**
     * A real, data-driven dashboard. Every metric is guarded by table existence,
     * so it renders correctly whether you've scaffolded one section or all of
     * them — counts simply read 0 for sections you haven't installed yet.
     */
    public function index(): View
    {
        return view('adminlte.dashboard.index', [
            'stats' => [
                'users' => $this->count('users'),
                'projects' => $this->count('adminlte_projects'),
                'unread_messages' => $this->countWhere('adminlte_messages', 'is_read', false),
                'events' => $this->upcomingEvents(),
            ],
            'projectsByStatus' => $this->projectsByStatus(),
            'recentActivity' => $this->recentActivity(),
        ]);
    }

    protected function count(string $table): int
    {
        return Schema::hasTable($table) ? (int) DB::table($table)->count() : 0;
    }

    /**
     * @param  mixed  $value
     */
    protected function countWhere(string $table, string $column, $value): int
    {
        if (! Schema::hasTable($table) || ! Schema::hasColumn($table, $column)) {
            return 0;
        }

        return (int) DB::table($table)->where($column, $value)->count();
    }

    protected function upcomingEvents(): int
    {
        if (! Schema::hasTable('adminlte_events')) {
            return 0;
        }

        return (int) DB::table('adminlte_events')->where('start_at', '>=', now())->count();
    }

    /**
     * @return array<string, int>
     */
    protected function projectsByStatus(): array
    {
        if (! Schema::hasTable('adminlte_projects')) {
            return [];
        }

        return DB::table('adminlte_projects')
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->map(fn ($t) => (int) $t)
            ->all();
    }

    /**
     * @return array<int, object>
     */
    protected function recentActivity(): array
    {
        if (! Schema::hasTable('activity_log')) {
            return [];
        }

        return DB::table('activity_log')
            ->leftJoin('users', 'users.id', '=', 'activity_log.user_id')
            ->orderByDesc('activity_log.created_at')
            ->limit(8)
            ->get(['activity_log.event', 'activity_log.description', 'activity_log.created_at', 'users.name as user_name'])
            ->all();
    }
}
