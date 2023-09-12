<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (DB::table('users')->count() == 0) {
            DB::table('users')->insert([
                'name' => "Ovais Tariq",
                'email' => "a@a.com",
                'password' => Hash::make('12345678'),
            ]);
        } else {
            echo "User Table is not empty, NOT Seeding";
        }
    }
}
