<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUtilityDeparmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('utility_deparments', function (Blueprint $table) {
            $table->id();
            $table->integer('contact_id');
            $table->string("electricity_company_name")->nullable();
            $table->string("electricity_user_name")->nullable();
            $table->string("electricity_phone")->nullable();
            $table->string("electricity_link")->nullable();
            $table->string("electricity_password")->nullable();
            $table->boolean('electricity_service_active')->nullable();

            $table->string("water_company_name")->nullable();
            $table->string("water_user_name")->nullable();
            $table->string("water_phone")->nullable();
            $table->string("water_link")->nullable();
            $table->string("water_password")->nullable();
            $table->boolean('water_service_active')->nullable();

            $table->string("gas_company_name")->nullable();
            $table->string("gas_user_name")->nullable();
            $table->string("gas_phone")->nullable();
            $table->string("gas_link")->nullable();
            $table->string("gas_password")->nullable();
            $table->boolean('gas_service_active')->nullable();

            $table->string("propane_company_name")->nullable();
            $table->string("propane_user_name")->nullable();
            $table->string("propane_phone")->nullable();
            $table->string("propane_link")->nullable();
            $table->string("propane_password")->nullable();
            $table->boolean('propane_service_active')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('utility_deparments');
    }
}
