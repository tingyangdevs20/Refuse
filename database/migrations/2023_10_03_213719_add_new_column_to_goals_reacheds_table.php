<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnToGoalsReachedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('goals_reacheds', function (Blueprint $table) {
            $table->string("signed_agreements")->nullable();
            $table->string("escrow_closure")->nullable();
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
            $table->dropColumn(['signed_agreements', 'escrow_closure']);
        });
    }
}
