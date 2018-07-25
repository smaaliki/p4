<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ConnectPerspectivesAndFocusareas extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::table('focus_areas', function (Blueprint $table) {
            # Add a new INT field called `perspective_id` that has to be unsigned (i.e. positive)
            $table->integer('perspective_id')->unsigned();
            # This field `perspective_id` is a foreign key that connects to the `id` field in the `perspectives` table
            $table->foreign('perspective_id')->references('id')->on('perspectives');
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::table('focus_areas', function (Blueprint $table) {
            # ref: http://laravel.com/docs/migrations#dropping-indexes
            # combine tablename + fk field name + the word "foreign"
            $table->dropForeign('focus_areas_perspective_id_foreign');
            $table->dropColumn('perspective_id');
        });
    }
}
