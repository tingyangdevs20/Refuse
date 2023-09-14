<?php

use Illuminate\Database\Seeder;
use App\goal_attribute;
class GoalAttribute extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        if (DB::table('goal_attribute')->count() == 0) {
            DB::table('goal_attribute')->insert([
                'goal_attribute' => "People Reached",
            ]);
            DB::table('goal_attribute')->insert([
                'attribute' => "Lead",
            ]);
            DB::table('goal_attribute')->insert([
                'attribute' => "Phone Appointment",
            ]);
            DB::table('goal_attribute')->insert([
                'attribute' => "Contarcts Out",
            ]);
            DB::table('goal_attribute')->insert([
                'attribute' => "Contarct Signed",
            ]);
            DB::table('goal_attribute')->insert([
                'attribute' => "Deal Closed",
            ]);
            DB::table('goal_attribute')->insert([
                'attribute' => "Money Expected",
            ]);
            DB::table('goal_attribute')->insert([
                'attribute' => "Money Collected",
            ]);
        } 

    }
}
