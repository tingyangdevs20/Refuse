<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZoomMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zoom_meetings', function (Blueprint $table) {
            $table->id();
            $table->string('meeting_name')->nullable();
            $table->string('meeting_password')->nullable();
            $table->string('meeting_date')->nullable();
            $table->string('meeting_date_timezone')->nullable();
            $table->string('duration_minute')->nullable();
            $table->string('meeting_status')->nullable();
            $table->string('host_video')->nullable();
            $table->string('client_video')->nullable();
            $table->string('meeting_note')->nullable();
            $table->string('zoom_meeting_link')->nullable();
            $table->string('access_token')->nullable();
            $table->string('refresh_token')->nullable();
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
        Schema::dropIfExists('zoom_meetings');
    }
}