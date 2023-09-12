<?php

use Illuminate\Database\Seeder;
// use \App\Models\Reply;

class QuickReplySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Model\Reply::factory(50)->create();
    }
}
