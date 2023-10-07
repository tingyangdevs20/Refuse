<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHoaInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hoa_info', function (Blueprint $table) {
            $table->id();
            $table->integer('contact_id');
            $table->string("hoa_name")->nullable();
            $table->string("hoa_contact_name")->nullable();
            $table->string("hoa_phone")->nullable();
            $table->string("hoa_email")->nullable();
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
        Schema::dropIfExists('hoa_info');
    }
}
