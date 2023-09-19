@@ -1,37 +0,0 @@
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkipTracingPaymentRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skip_tracing_payment_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->text('skip_trace_option_id')->nullable();
            $table->text('stripe_token')->nullable();
            $table->unsignedBigInteger('group_id')->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->boolean('is_paid')->default(false)->nullable();
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
        Schema::dropIfExists('skip_tracing_payment_records');
    }
}
