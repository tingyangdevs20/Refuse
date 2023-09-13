<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(UserSeeder::class);
         $this->call(LeadCategorySeeder::class);
         $this->call(SettingSeeder::class);
         $this->call(RolePermissionSeeder::class);
//        factory(\App\Model\Template::class, 20)->create();
//        factory(\App\Model\QuickResponse::class, 10)->create();
//        factory(\App\Model\DNC::class, 10)->create();
    }
}
