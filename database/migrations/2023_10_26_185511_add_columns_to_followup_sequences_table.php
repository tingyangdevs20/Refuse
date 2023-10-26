<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToFollowupSequencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('followup_sequences', function (Blueprint $table) {
            $table->text('reminder_text')->nullable();
            $table->unsignedBigInteger('assigner_id')->nullable();
            $table->foreign('assigner_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('followup_sequences', function (Blueprint $table) {
            $table->dropForeign(['assigner_id']);
            $table->dropColumn('assigner_id');
            $table->dropColumn('reminder_text');
        });
    }
}
