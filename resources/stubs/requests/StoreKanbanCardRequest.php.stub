<?php

namespace App\Http\Requests\AdminLte;

use Illuminate\Foundation\Http\FormRequest;

class StoreKanbanCardRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'lane_id' => ['required', 'exists:adminlte_kanban_lanes,id'],
            'title' => ['required', 'string', 'max:255'],
            'color' => ['nullable', 'string'],
        ];
    }
}
