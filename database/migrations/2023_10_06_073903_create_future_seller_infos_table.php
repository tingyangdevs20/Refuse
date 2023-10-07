<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFutureSellerInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('future_seller_infos', function (Blueprint $table) {
            $table->id();
            $table->integer('contact_id');
            $table->string("seller1_address")->nullable();
            $table->string("seller1_city")->nullable();
            $table->string("seller1_state")->nullable();
            $table->string("seller1_zip")->nullable();
            $table->string("seller1_nearest_address")->nullable();
            $table->string("seller1_nearest_city")->nullable();
            $table->string("seller1_nearest_state")->nullable();
            $table->string("seller1_nearest_zip")->nullable();
            $table->string("seller1_nearest_phone")->nullable();

            $table->string("seller2_address")->nullable();
            $table->string("seller2_city")->nullable();
            $table->string("seller2_state")->nullable();
            $table->string("seller2_zip")->nullable();
            $table->string("seller2_nearest_address")->nullable();
            $table->string("seller2_nearest_city")->nullable();
            $table->string("seller2_nearest_state")->nullable();
            $table->string("seller2_nearest_zip")->nullable();
            $table->string("seller2_nearest_phone")->nullable();

            $table->string("seller3_address")->nullable();
            $table->string("seller3_city")->nullable();
            $table->string("seller3_state")->nullable();
            $table->string("seller3_zip")->nullable();
            $table->string("seller3_nearest_address")->nullable();
            $table->string("seller3_nearest_city")->nullable();
            $table->string("seller3_nearest_state")->nullable();
            $table->string("seller3_nearest_zip")->nullable();
            $table->string("seller3_nearest_phone")->nullable();
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
        Schema::dropIfExists('future_seller_infos');
    }
}
