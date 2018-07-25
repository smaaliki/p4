<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStandardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('standards', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('std_num');
            $table->string('name_en');
            $table->boolean('std_type'); //1=Standard, 0=Indicator
            $table->integer('target_type')->nullable(); //0=Absolute, 1=min, 2=range, 3=max
            $table->float('target_min')->nullable();
            $table->float('target_max')->nullable();
            $table->string('units')->nullable();
            $table->integer('std_ranking')->nullable();

            /*Todo: The following should be split into a different tables so that performance can be separated and reported on monthly */
            $table->float('weight')->nullable();
            $table->float('achieved')->nullable();
            $table->float('performance')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('standards');
    }
}
