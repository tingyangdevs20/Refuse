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
        if (DB::table('goal_attributes')->count() == 0) {
            DB::table('goal_attributes')->insert([
                'attribute' => "People Reached",
            ]);
            DB::table('goal_attributes')->insert([
                'attribute' => "Lead",
            ]);
            DB::table('goal_attributes')->insert([
                'attribute' => "Phone Appointment",
            ]);
            DB::table('goal_attributes')->insert([
                'attribute' => "Contarcts Out",
            ]);
            DB::table('goal_attributes')->insert([
                'attribute' => "Contarct Signed",
            ]);
            DB::table('goal_attributes')->insert([
                'attribute' => "Deal Closed",
            ]);
            DB::table('goal_attributes')->insert([
                'attribute' => "Money Expected",
            ]);
            DB::table('goal_attribute')->insert([
                'attribute' => "Money Collected",
            ]);
        } 

    }
}
