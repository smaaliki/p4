<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ConnectCcsAndEmployees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {

            # Remove the field associated with the old way we were storing authors
            # Can do this here, or update the original migration that creates the `employee` table
            # $table->dropColumn('cc');

            # Add a new INT field called `cc_id` that has to be unsigned (i.e. positive)
            $table->integer('contact_center_id')->unsigned();

            # This field `cc_id` is a foreign key that connects to the `id` field in the `ccs` table
            $table->foreign('contact_center_id')->references('id')->on('contact_centers');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {

            # ref: http://laravel.com/docs/migrations#dropping-indexes
            # combine tablename + fk field name + the word "foreign"
            $table->dropForeign('employees_contact_center_id_foreign');

            $table->dropColumn('contact_center_id');
        });
    }
}
