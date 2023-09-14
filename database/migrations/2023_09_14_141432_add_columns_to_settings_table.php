<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->text('google_drive_client_id')->nullable();
            $table->text('google_drive_client_secret')->nullable();
            $table->text('google_drive_developer_key')->nullable();
            $table->text('zoom_account_id')->nullable();
            $table->text('zoom_client_id')->nullable();
            $table->text('zoom_client_secret')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['google_drive_client_id', 'google_drive_client_secret'
            , 'google_drive_developer_key', 'google_drive_developer_key', 'zoom_account_id'
            , 'zoom_client_id', 'zoom_client_secret']);
        });
    }
}
