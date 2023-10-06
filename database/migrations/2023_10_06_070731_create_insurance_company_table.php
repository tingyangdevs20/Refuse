<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsuranceCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insurance_company', function (Blueprint $table) {
            $table->id();
            $table->integer('contact_id');
            $table->string("insurance_company_name")->nullable();
            $table->string("insurance_company_phone")->nullable();
            $table->string("insurance_company_agent")->nullable();
            $table->string("insurance_company_agent_phone")->nullable();
            $table->string("insurance_account_number")->nullable();
            $table->string("insurance_online_link")->nullable();
            $table->string("insurance_online_user")->nullable();
            $table->string("insurance_online_password")->nullable();

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
        Schema::dropIfExists('insurance_company');
    }
}
