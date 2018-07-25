<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactCenterTouchpointTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_center_touchpoint', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->integer('contact_center_id')->unsigned();
            $table->integer('touchpoint_id')->unsigned();

            # Make foreign keys
            $table->foreign('contact_center_id')->references('id')->on('contact_centers');
            $table->foreign('touchpoint_id')->references('id')->on('touchpoints');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contact_center_touchpoint');
    }
}
