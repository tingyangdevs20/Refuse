<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnsToGoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('goals_reacheds', function (Blueprint $table) {
            $table->string("money_per_month")->nullable();
            $table->string("gross_profit")->nullable();
            $table->string("contact_trun_into_lead")->nullable();
            $table->string("leads_into_phone")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('goals_reacheds', function (Blueprint $table) {
            $table->dropColumn(['money_per_month', 'gross_profit'
            , 'contact_trun_into_lead', 'leads_into_phone']);
        });
    }
}
