<?php

namespace App\Http\Controllers\AdminLte;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Requests\AdminLte\StoreEventRequest;
use App\Http\Requests\AdminLte\UpdateEventRequest;
use App\Models\Event;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    use AuthorizesRequests;

    public function index(): View
    {
        $this->authorize('viewAny', \App\Models\Event::class);

        return view('adminlte.calendar.index');
    }

    /**
     * JSON feed consumed by FullCalendar.
     */
    public function feed(Request $request): JsonResponse
    {
        $events = Event::where('user_id', Auth::id())
            ->when($request->filled('start'), fn ($q) => $q->where('start_at', '>=', $request->date('start')))
            ->when($request->filled('end'), fn ($q) => $q->where('start_at', '<=', $request->date('end')))
            ->get()
            ->map->toCalendarArray();

        return response()->json($events);
    }

    public function store(StoreEventRequest $request): JsonResponse
    {
        $data = $request->validated();

        $event = Event::create([
            ...$data,
            'user_id' => Auth::id(),
            'color' => $data['color'] ?? '#0d6efd',
        ]);

        return response()->json($event->toCalendarArray());
    }

    public function update(UpdateEventRequest $request, Event $event): JsonResponse
    {
        $this->authorize('update', $event);

        $event->update($request->validated());

        return response()->json($event->toCalendarArray());
    }

    public function destroy(Event $event): JsonResponse
    {
        $this->authorize('delete', $event);

        $event->delete();

        return response()->json(['status' => 'ok']);
    }
}
