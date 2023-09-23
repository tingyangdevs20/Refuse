<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_replies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('email_id')->index();
            $table->foreign('email_id')->references('id')->on('emails');
            $table->string('to');
            $table->string('from');
            $table->longText('reply')->nullable();
            $table->boolean('system_reply')->default(0);
            $table->boolean('is_unread')->nullable()->default(1);
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
        Schema::dropIfExists('email_replies');
    }
}
