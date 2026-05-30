<?php

namespace App\Http\Controllers\AdminLte;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(): View
    {
        $this->authorizeManage();

        $roles = Role::withCount('permissions')->orderBy('name')->paginate(15);

        return view('adminlte.roles.index', compact('roles'));
    }

    public function create(): View
    {
        $this->authorizeManage();

        $permissions = Permission::orderBy('name')->get();

        return view('adminlte.roles.create', compact('permissions'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorizeManage();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:adminlte_roles,name'],
            'label' => ['nullable', 'string', 'max:255'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['integer', 'exists:adminlte_permissions,id'],
        ]);

        $role = Role::create([
            'name' => $data['name'],
            'label' => $data['label'] ?? null,
        ]);

        $role->permissions()->sync($data['permissions'] ?? []);

        return redirect()->route('adminlte.roles.index')
            ->with('status', __('adminlte.role_created'));
    }

    public function edit(Role $role): View
    {
        $this->authorizeManage();

        $permissions = Permission::orderBy('name')->get();
        $role->load('permissions');

        return view('adminlte.roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role): RedirectResponse
    {
        $this->authorizeManage();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:adminlte_roles,name,'.$role->id],
            'label' => ['nullable', 'string', 'max:255'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['integer', 'exists:adminlte_permissions,id'],
        ]);

        $role->update([
            'name' => $data['name'],
            'label' => $data['label'] ?? null,
        ]);

        $role->permissions()->sync($data['permissions'] ?? []);

        return redirect()->route('adminlte.roles.index')
            ->with('status', __('adminlte.role_updated'));
    }

    public function destroy(Role $role): RedirectResponse
    {
        $this->authorizeManage();

        $role->delete();

        return redirect()->route('adminlte.roles.index')
            ->with('status', __('adminlte.role_deleted'));
    }

    private function authorizeManage(): void
    {
        abort_unless(auth()->user()?->hasPermission('manage-roles'), 403);
    }
}
