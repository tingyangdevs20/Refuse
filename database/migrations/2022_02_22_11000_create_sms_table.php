<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lead_category_id')->default(1);
            $table->string('client_number');
            $table->string('twilio_number');
            $table->longText('message');
            $table->text('media');
            $table->integer('status');
            $table->boolean('is_received')->nullable()->default(0);
            $table->boolean('is_unread')->nullable()->default(1);
            $table->foreign('lead_category_id')->references('id')->on('lead_categories')->onDelete('cascade');
            $table->softDeletes();
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
        Schema::dropIfExists('sms');
    }
}
