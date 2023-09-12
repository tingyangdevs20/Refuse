<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewUserAgreementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * @author Bhavesh Vyas
     */
    public function up()
    {
        Schema::create('user_agreements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('template_id')->nullable();
            $table->date('agreement_date')->nullable();
            $table->longText('content')->nullable();
            $table->longText('agreement_template_content')->nullable();
            $table->longText('content_fields_data')->nullable();
            $table->enum('is_expired', ['0', '1'])->default('0');
            $table->enum('is_sign', ['0', '1', '2'])->default('0');
            $table->text('pdf_path')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     * @author Bhavesh Vyas
     */
    public function down()
    {
        Schema::dropIfExists('user_agreements');
    }
}
