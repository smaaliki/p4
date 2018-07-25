<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ConnectPillarsAndPerspectives extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::table('perspectives', function (Blueprint $table) {
            # Add a new INT field called `pillar_id` that has to be unsigned (i.e. positive)
            $table->integer('pillar_id')->unsigned();
            # This field `pillar_id` is a foreign key that connects to the `id` field in the `authors` table
            $table->foreign('pillar_id')->references('id')->on('pillars');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::table('perspectives', function (Blueprint $table) {
            # ref: http://laravel.com/docs/migrations#dropping-indexes
            # combine tablename + fk field name + the word "foreign"
            $table->dropForeign('perspectives_pillar_id_foreign');
            $table->dropColumn('pillar_id');
        });
    }
}
