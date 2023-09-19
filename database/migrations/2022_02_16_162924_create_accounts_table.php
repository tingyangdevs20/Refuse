<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->text('account_id');
            $table->text('account_token');
            $table->text('account_copilot')->nullable();
            $table->string('account_name');
            $table->string('phone_cell_append_rate')->nullable();
            $table->string('email_append_rate')->nullable();
            $table->string('name_append_rate')->nullable();
            $table->string('email_verification_rate')->nullable();
            $table->string('phone_scrub_rate')->nullable();
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
        Schema::dropIfExists('accounts');
    }
}
