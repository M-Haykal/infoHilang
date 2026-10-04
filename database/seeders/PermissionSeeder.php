<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Define roles
        $roles = ['admin', 'user', 'developer'];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role, 'guard_name' => 'web']);
        }

        // 2. Define all available permissions
        $permissions = [
            'detail animal', 'create animal', 'edit animal', 'delete animal',
            'detail stuff', 'create stuff', 'edit stuff', 'delete stuff',
            'detail person', 'create person', 'edit person', 'delete person',
            'detail blog', 'create blog', 'edit blog', 'delete blog',
            'create comment', 'edit comment', 'delete comment',
            'detail user', 'create user', 'edit user', 'delete user',
            'detail report hoax', 'create report hoax', 'edit report hoax', 'delete report hoax', 'approve report hoax',
            'view system logs', // Tambahan permission khusus developer
        ];

        // 3. Create all permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // 4. Assign permissions to roles
        
        // Admin: All permissions except 'view system logs'
        $adminRole = Role::findByName('admin');
        $adminRole->syncPermissions(array_filter($permissions, fn($p) => $p !== 'view system logs'));

        // Developer: All permissions + 'view system logs' (or specific developer permissions)
        $developerRole = Role::findByName('developer');
        $developerPermissions = [
            'detail animal', 'create animal', 'edit animal', 'delete animal',
            'detail stuff', 'create stuff', 'edit stuff', 'delete stuff',
            'detail person', 'create person', 'edit person', 'delete person',
            'detail blog', 'create blog', 'edit blog', 'delete blog',
            'create comment', 'edit comment', 'delete comment',
            'detail user', 'create user', 'edit user', 'delete user',
            'detail report hoax', 'create report hoax', 'edit report hoax', 'delete report hoax',
            'view system logs',
        ];
        $developerRole->syncPermissions($developerPermissions);

        // User: Basic permissions
        $userRole = Role::findByName('user');
        $userRole->syncPermissions([
            'detail animal', 'create animal', 'edit animal', 'delete animal',
            'detail stuff', 'create stuff', 'edit stuff', 'delete stuff',
            'detail person', 'create person', 'edit person', 'delete person',
            'detail blog', 'create blog', 'edit blog', 'delete blog',
            'detail report hoax', 'create report hoax', 'edit report hoax', 'delete report hoax',
        ]);
    }
}