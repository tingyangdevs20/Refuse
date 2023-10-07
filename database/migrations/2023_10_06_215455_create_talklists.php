<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTalklists extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasklists', function (Blueprint $table) {
            $table->id();
            $table->string('tast');
            $table->string('user_id')->nullable();
            $table->string('checked')->nullable();
            $table->string('status')->nullable();
            $table->string('tasklist_id')->nullable();
            $table->string('position')->nullable();
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
        Schema::dropIfExists('talklists');
    }
}
