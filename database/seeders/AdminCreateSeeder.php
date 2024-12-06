<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminCreateSeeder extends Seeder
{
    public function run(): void
{
    $user = User::create([
        'name' => 'Web Admin',
        'email' => 'admin@email.com',
        'password' => bcrypt('12345678'),
    ]);

    $user->assignRole('Admin');
}

}
