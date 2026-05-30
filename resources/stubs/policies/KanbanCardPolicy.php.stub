<?php

namespace App\Policies;

use App\Models\KanbanCard;
use App\Models\User;

class KanbanCardPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, KanbanCard $card): bool
    {
        return $this->owns($user, $card);
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, KanbanCard $card): bool
    {
        return $this->owns($user, $card);
    }

    public function delete(User $user, KanbanCard $card): bool
    {
        return $this->owns($user, $card);
    }

    /**
     * A card belongs to the user that owns the board its lane sits on.
     */
    private function owns(User $user, KanbanCard $card): bool
    {
        return $card->lane?->board?->user_id === $user->id;
    }
}
