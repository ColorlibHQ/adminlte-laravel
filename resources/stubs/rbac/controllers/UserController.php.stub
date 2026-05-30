<?php

namespace App\Http\Controllers\AdminLte;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index(): View
    {
        $this->authorizeManage();

        $users = User::with('roles')->latest()->paginate(15);

        return view('adminlte.users.index', compact('users'));
    }

    public function create(): View
    {
        $this->authorizeManage();

        $roles = Role::orderBy('name')->get();

        return view('adminlte.users.create', compact('roles'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorizeManage();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'roles' => ['nullable', 'array'],
            'roles.*' => ['integer', 'exists:adminlte_roles,id'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make(Str::random(32)),
        ]);

        $user->roles()->sync($data['roles'] ?? []);

        return redirect()->route('adminlte.users.index')
            ->with('status', __('adminlte.user_created'));
    }

    public function edit(User $user): View
    {
        $this->authorizeManage();

        $roles = Role::orderBy('name')->get();
        $user->load('roles');

        return view('adminlte.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $this->authorizeManage();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'roles' => ['nullable', 'array'],
            'roles.*' => ['integer', 'exists:adminlte_roles,id'],
        ]);

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

        $user->roles()->sync($data['roles'] ?? []);

        return redirect()->route('adminlte.users.index')
            ->with('status', __('adminlte.user_updated'));
    }

    public function destroy(User $user): RedirectResponse
    {
        $this->authorizeManage();

        $user->delete();

        return redirect()->route('adminlte.users.index')
            ->with('status', __('adminlte.user_deleted'));
    }

    private function authorizeManage(): void
    {
        abort_unless(auth()->user()?->hasPermission('manage-users'), 403);
    }
}
