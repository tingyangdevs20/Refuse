<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnsToSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {

            $table->string("stripe_screct_key")->nullable();
            $table->string("strip_publishable_key")->nullable();
            $table->string("paypal_client_id")->nullable();
            $table->string("paypal_secret_key")->nullable();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['stripe_screct_key', 'strip_publishable_key'
            , 'paypal_client_id', 'paypal_secret_key']);
        });
    }
}
