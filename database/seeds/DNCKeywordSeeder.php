<?php

use Illuminate\Database\Seeder;
// use \App\Model\DNC;

class DNCKeywordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Model\DNC::factory(50)->create();
    }
}
