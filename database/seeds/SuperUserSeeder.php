<?php

use Illuminate\Database\Seeder;
use App\User;
use Spatie\Permission\Models\Role;

class SuperUserSeeder extends Seeder
{
    public function run()
    {
        // Create a superuser
        $user = User::create([
            'name' => 'Super User',
            'email' => 'superuser@gmail.com',
            'password' => bcrypt('Password@123'),
            'time_zone' => '(GMT-09:00) Alaska => America/Anchorage', // Set your default timezone here
        ]);

        // Assign all available roles to the superuser
        $roles = Role::all();
        $user->syncRoles($roles);
    }
}
