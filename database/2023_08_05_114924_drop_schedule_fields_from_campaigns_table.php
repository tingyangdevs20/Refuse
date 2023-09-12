<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropScheduleFieldsFromCampaignsTable extends Migration
{
    public function up()
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->dropColumn('schedule');
            $table->dropColumn('schedule_date');
            $table->dropColumn('schedule_time');
        });
    }

    public function down()
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->timestamp('schedule')->nullable();
            $table->date('schedule_date')->nullable();
            $table->time('schedule_time')->nullable();
        });
    }
}