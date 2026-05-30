<?php

namespace App\Models\Concerns;

use App\Models\Role;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Adds role and permission helpers to the User model.
 */
trait HasRoles
{
    /**
     * Roles assigned to the user.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'adminlte_role_user');
    }

    /**
     * Determine whether the user has any of the given role(s).
     *
     * @param  string|array<int, string>  $role
     */
    public function hasRole(string|array $role): bool
    {
        $roles = (array) $role;

        return $this->roles()->whereIn('name', $roles)->exists();
    }

    /**
     * Determine whether any of the user's roles grants the given permission.
     */
    public function hasPermission(string $permission): bool
    {
        return $this->roles()
            ->whereHas('permissions', fn ($query) => $query->where('name', $permission))
            ->exists();
    }

    /**
     * Assign a role to the user by name without detaching existing roles.
     */
    public function assignRole(string $role): void
    {
        $model = Role::where('name', $role)->first();

        if ($model !== null) {
            $this->roles()->syncWithoutDetaching($model);
        }
    }

    /**
     * Determine whether the user has the "admin" role.
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }
}
