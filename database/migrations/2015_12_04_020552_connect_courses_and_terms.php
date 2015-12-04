<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ConnectCoursesAndTerms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // add one to many relationship between courses and terms
        Schema::table('courses', function (Blueprint $table) {
            $table->integer('term_id')->unsigned();
            $table->foreign('term_id')->references('id')->on('terms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // destroy one to many relationship between courses and terms
        Schema::table('courses', function (Blueprint $table) {
            // first break relationship
            // http://laravel.com/docs/5.1/migrations#foreign-key-constraints
            $table->dropForeign('courses_term_id_foreign');
            $table->dropColumn('term_id');
        });
    }
}
