<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGoogleCalendarEventIdToSchedulerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('scheduler', function (Blueprint $table) {
            $table->string("google_calendar_event_id", 255)->nullable()->default(null)->comment("This column will store the ID of google calendar event.");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('scheduler', function (Blueprint $table) {
            //
        });
    }
}
