<?php

use Illuminate\Database\Seeder;
use \App\Model\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Model\Category::factory(50)->create();
    }
}
