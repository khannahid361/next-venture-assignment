<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        $permissions = ['create-posts', 'edit-posts', 'delete-posts', 'view-posts'];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $admin = Role::create(['name' => 'Admin']);
        $editor = Role::create(['name' => 'Editor']);
        $blogReader = Role::create(['name' => 'Blog Reader']);

        $admin->permissions()->attach(Permission::all());
        $editor->permissions()->attach(Permission::whereIn('name', ['create-posts', 'edit-posts', 'view-posts'])->get());
        $blogReader->permissions()->attach(Permission::where('name', 'view-posts')->first());
    }
}
