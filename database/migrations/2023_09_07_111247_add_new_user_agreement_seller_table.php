<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewUserAgreementSellerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * @author Bhavesh Vyas
     */
    public function up()
    {
        Schema::create('user_agreement_seller', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_agreement_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->date('agreement_sign_date')->nullable();
            $table->string('signature_key')->nullable();
            $table->text('sign')->nullable();
            $table->enum('is_sign', ['0', '1', '2'])->default('0');
            $table->text('user_ip')->nullable();
            $table->enum('is_send_mail', ['1', '0'])->default("1");
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_agreement_id')
                ->references('id')
                ->on('user_agreements')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
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
        Schema::dropIfExists('user_agreement_seller');
    }
}
