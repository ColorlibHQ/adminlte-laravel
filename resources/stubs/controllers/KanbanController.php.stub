<?php

namespace App\Http\Controllers\AdminLte;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Requests\AdminLte\StoreKanbanCardRequest;
use App\Models\KanbanBoard;
use App\Models\KanbanCard;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KanbanController extends Controller
{
    use AuthorizesRequests;

    public function index(): View
    {
        $board = KanbanBoard::with('lanes.cards.assignees')
            ->where('user_id', Auth::id())
            ->first();

        return view('adminlte.kanban.index', compact('board'));
    }

    public function storeCard(StoreKanbanCardRequest $request): JsonResponse
    {
        $data = $request->validated();

        $card = KanbanCard::create([
            'lane_id' => $data['lane_id'],
            'title' => $data['title'],
            'color' => $data['color'] ?? 'primary',
            'position' => KanbanCard::where('lane_id', $data['lane_id'])->max('position') + 1,
        ]);

        return response()->json($card);
    }

    /**
     * Persist drag-to-reorder changes from SortableJS.
     */
    public function reorder(Request $request): JsonResponse
    {
        $data = $request->validate([
            'cards' => ['required', 'array'],
            'cards.*.id' => ['required', 'exists:adminlte_kanban_cards,id'],
            'cards.*.lane_id' => ['required', 'exists:adminlte_kanban_lanes,id'],
            'cards.*.position' => ['required', 'integer'],
        ]);

        foreach ($data['cards'] as $card) {
            KanbanCard::where('id', $card['id'])->update([
                'lane_id' => $card['lane_id'],
                'position' => $card['position'],
            ]);
        }

        return response()->json(['status' => 'ok']);
    }
}
