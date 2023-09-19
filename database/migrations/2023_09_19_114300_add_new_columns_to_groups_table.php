@@ -1,37 +0,0 @@
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnsToGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('groups', function (Blueprint $table) {
            $table->string('email_skip_trace_date')->nullable();
            $table->string('phone_skip_trace_date')->nullable();
            $table->string('name_skip_trace_date')->nullable();
            $table->string('email_verification_date')->nullable();
            $table->string('phone_scrub_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('groups', function (Blueprint $table) {
            $table->dropColumn(['email_skip_trace_date', 'phone_skip_trace_date'
            , 'name_skip_trace_date', 'email_verification_date', 'phone_scrub_date']);
        });
    }
}
