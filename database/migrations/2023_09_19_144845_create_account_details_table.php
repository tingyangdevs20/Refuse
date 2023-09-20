<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_details', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id'); // Foreign key to associate the transaction with a user
            $table->string('transaction_id'); // Unique identifier for the transaction (Stripe Payment Intent ID)
            $table->string('payment_method'); // Payment method used (e.g., card, PayPal, etc.)
            $table->decimal('amount', 10, 2); // Amount of the transaction
            $table->string('currency', 3); // Currency used (e.g., USD, EUR)
            $table->timestamp('transaction_date')->nullable(); // Date and time of the transaction
            $table->string('status'); // Status of the transaction (e.g., succeeded, failed)
            $table->timestamps();

            // Define foreign key relationship with the users table
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_details');
    }
}
