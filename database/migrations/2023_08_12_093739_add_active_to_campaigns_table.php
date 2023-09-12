<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddActiveToCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->boolean('active')->default(true); // Default to active
        });
    }
    
    public function down()
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->dropColumn('active');
        });
    }

}
