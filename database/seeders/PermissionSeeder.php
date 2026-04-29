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
        $roles = ['admin', 'user'];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role, 'guard_name' => 'web']);
        }

        $permissions = [
            'detail animal',
            'create animal',
            'edit animal',
            'delete animal',

            'detail stuff',
            'create stuff',
            'edit stuff',
            'delete stuff',

            'detail person',
            'create person',
            'edit person',
            'delete person',

            'detail blog',
            'create blog',
            'edit blog',
            'delete blog',

            'create comment',
            'edit comment',
            'delete comment',

            'detail user',
            'create user',
            'edit user',
            'delete user',

            'detail report hoax',
            'create report hoax',
            'edit report hoax',
            'delete report hoax',
            'approve report hoax',
        ];
        $user->assignRole('admin')->givePermissionTo($permissions);

        $user->assignRole('user')->givePermissionTo([
            'detail animal',
            'create animal',
            'edit animal',
            'delete animal',

            'detail stuff',
            'create stuff',
            'edit stuff',
            'delete stuff',

            'detail person',
            'create person',
            'edit person',
            'delete person',

            'detail blog',
            'create blog',
            'edit blog',
            'delete blog',

            'detail report hoax',
            'create report hoax',
            'edit report hoax',
            'delete report hoax',
        ]);

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }
    }
}