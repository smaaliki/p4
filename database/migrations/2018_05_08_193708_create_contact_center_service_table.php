<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactCenterServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_center_service', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->integer('contact_center_id')->unsigned();
            $table->integer('service_id')->unsigned();

            # Make foreign keys
            $table->foreign('contact_center_id')->references('id')->on('contact_centers');
            $table->foreign('service_id')->references('id')->on('services');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contact_center_service');
    }
}
