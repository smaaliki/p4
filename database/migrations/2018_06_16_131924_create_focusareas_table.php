<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFocusareasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('focus_areas', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('fa_id');
            $table->string('name');
            $table->string('weight');
            $table->float('achieved')->nullable();
            $table->float('result')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('focus_areas');
    }
}
