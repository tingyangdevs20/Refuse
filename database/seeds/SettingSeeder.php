<?php

use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (DB::table('settings')->count() == 0) {
            DB::table('settings')->insert([
                'auto_reply' => 0,
                'auto_responder' => 0,
                'sms_rate' => 0.00075,
            ]);
        } else {
            echo "Settings Table is not empty, NOT Seeding";
        }
    }
}
