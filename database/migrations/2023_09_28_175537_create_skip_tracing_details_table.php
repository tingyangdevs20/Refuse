<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkipTracingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skip_tracing_details', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('group_id')->nullable();
            $table->string('select_option')->nullable();
            $table->string('email_skip_trace_date')->nullable();
            $table->string('phone_skip_trace_date')->nullable();
            $table->string('name_skip_trace_date')->nullable();
            $table->string('email_verification_date')->nullable();
            $table->string('phone_scrub_date')->nullable();
            $table->string('verified_emails')->nullable();
            $table->string('verified_numbers')->nullable();
            $table->string('append_names')->nullable();
            $table->string('append_emails')->nullable();
            $table->string('scam_numbers')->nullable();
            $table->string('scam_emails')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('zip')->nullable();
            $table->string('matched')->nullable();
            $table->string('order_amount')->nullable();
            $table->string('token')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('skip_tracing_details');
    }
}
