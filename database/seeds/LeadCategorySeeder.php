<?php

use Illuminate\Database\Seeder;

class LeadCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (DB::table('lead_categories')->count() == 0) {
            DB::table('lead_categories')->insert([

                [
                    'title' => 'Never Responded',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'title' => 'DNC',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'title' => 'Waiting Reply',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],

            ]);

        } else {
            echo "lead_categories is not empty, therefore NOT Seeding";
        }
    }
}
