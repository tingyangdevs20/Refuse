<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnToAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->string('phone_cell_append_rate')->nullable();
            $table->string('email_append_rate')->nullable();
            $table->string('name_append_rate')->nullable();
            $table->string('email_verification_rate')->nullable();
            $table->string('phone_scrub_rate')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->dropColumn(['phone_cell_append_rate', 'email_append_rate'
            , 'name_append_rate', 'email_verification_rate', 'phone_scrub_rate']);
        });
    }
}
