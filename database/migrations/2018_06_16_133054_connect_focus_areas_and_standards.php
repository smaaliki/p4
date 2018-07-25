<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ConnectFocusAreasAndStandards extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::table('standards', function (Blueprint $table) {
            # Add a new INT field called `focus_area_id` that has to be unsigned (i.e. positive)
            $table->integer('focus_area_id')->unsigned();

            # This field `focus_area_id` is a foreign key that connects to the `id` field in the `focusareas` table
            $table->foreign('focus_area_id')->references('id')->on('focus_areas');
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::table('standards', function (Blueprint $table) {
            # ref: http://laravel.com/docs/migrations#dropping-indexes
            # combine tablename + fk field name + the word "foreign"
            $table->dropForeign('standards_focus_area_id_foreign');

            $table->dropColumn('focus_area_id');
        });
    }
}
