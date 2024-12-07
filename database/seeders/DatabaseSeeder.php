<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $permissions = ['create-posts', 'edit-posts', 'delete-posts', 'view-posts','create-user', 'edit-user', 'delete-user', 'view-user', 'view-user-list', 'view-role', 'view-role-list','view-permission', 'view-permission-list'];

        //Adding permissions
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        //Adding Roles
        $admin = Role::create(['name' => 'Admin']);
        $editor = Role::create(['name' => 'Editor']);
        $blogReader = Role::create(['name' => 'Blog Reader']);

        //Assigning Permissions
        $admin->permissions()->attach(Permission::all());
        $editor->permissions()->attach(Permission::whereIn('name', ['create-posts', 'edit-posts', 'view-posts'])->get());
        $blogReader->permissions()->attach(Permission::where('name', 'view-posts')->first());

        //Creating User
        $user = User::create([
            'name' => 'Web Admin',
            'email' => 'admin@email.com',
            'password' => bcrypt('12345678'),
        ]);
    
        //Assigning Role
        $user->assignRole('Admin');
    }
}
