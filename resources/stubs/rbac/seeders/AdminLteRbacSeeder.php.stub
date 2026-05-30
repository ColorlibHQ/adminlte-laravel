<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminLteRbacSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'view-dashboard' => 'View Dashboard',
            'manage-projects' => 'Manage Projects',
            'manage-users' => 'Manage Users',
            'manage-roles' => 'Manage Roles',
            'manage-mailbox' => 'Manage Mailbox',
            'manage-kanban' => 'Manage Kanban',
            'manage-calendar' => 'Manage Calendar',
            'manage-settings' => 'Manage Settings',
            'view-reports' => 'View Reports',
        ];

        foreach ($permissions as $name => $label) {
            Permission::firstOrCreate(['name' => $name], ['label' => $label]);
        }

        $roles = [
            'admin' => [
                'label' => 'Administrator',
                'permissions' => array_keys($permissions),
            ],
            'editor' => [
                'label' => 'Editor',
                'permissions' => [
                    'view-dashboard',
                    'manage-projects',
                    'manage-kanban',
                    'manage-calendar',
                    'manage-mailbox',
                ],
            ],
            'viewer' => [
                'label' => 'Viewer',
                'permissions' => [
                    'view-dashboard',
                ],
            ],
        ];

        foreach ($roles as $name => $definition) {
            $role = Role::firstOrCreate(['name' => $name], ['label' => $definition['label']]);

            $permissionIds = Permission::whereIn('name', $definition['permissions'])->pluck('id');
            $role->permissions()->syncWithoutDetaching($permissionIds);
        }

        $user = User::first();

        if ($user !== null) {
            $admin = Role::where('name', 'admin')->first();

            if ($admin !== null) {
                $user->roles()->syncWithoutDetaching($admin);
            }
        }
    }
}
