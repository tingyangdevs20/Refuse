<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalendarSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calendar_settings', function (Blueprint $table) {
            $table->id();
            $table->string('calendar_type')->nullable()->default("appointments");
            $table->string('timezone');
            $table->integer('period_duration')->default(60);
            $table->boolean('monday_close')->default(false);
            $table->time('monday_start_time')->nullable();
            $table->time('monday_end_time')->nullable();
            $table->boolean('tuesday_close')->default(false);
            $table->time('tuesday_start_time')->nullable();
            $table->time('tuesday_end_time')->nullable();
            $table->boolean('wednesday_close')->default(false);
            $table->time('wednesday_start_time')->nullable();
            $table->time('wednesday_end_time')->nullable();
            $table->boolean('thursday_close')->default(false);
            $table->time('thursday_start_time')->nullable();
            $table->time('thursday_end_time')->nullable();
            $table->boolean('friday_close')->default(false);
            $table->time('friday_start_time')->nullable();
            $table->time('friday_end_time')->nullable();
            $table->boolean('saturday_close')->default(false);
            $table->time('saturday_start_time')->nullable();
            $table->time('saturday_end_time')->nullable();
            $table->boolean('sunday_close')->default(false);
            $table->time('sunday_start_time')->nullable();
            $table->time('sunday_end_time')->nullable();
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
        Schema::dropIfExists('calendar_settings');
    }
}
