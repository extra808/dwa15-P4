<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ConnectCoursesAndStudents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // add one to many relationship between courses and students
        Schema::table('courses', function (Blueprint $table) {
            $table->integer('student_id')->unsigned();
            $table->foreign('student_id')->references('id')->on('students');
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
            $table->dropForeign('courses_student_id_foreign');
            $table->dropColumn('student_id');
        });
    }
}
