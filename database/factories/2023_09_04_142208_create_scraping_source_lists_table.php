<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScrapingSourceListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scraping_source_lists', function (Blueprint $table) {
            $table->id();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('price_range')->nullable();
            $table->string('listing_type')->nullable();
            $table->string('property_type')->nullable();
            $table->string('no_of_bedrooms')->nullable();
            $table->string('no_of_bathrooms')->nullable();
            $table->string('filters')->nullable();
            $table->string('job_name')->nullable();
            $table->string('file')->nullable();
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
        Schema::dropIfExists('scraping_source_lists');
    }
}
