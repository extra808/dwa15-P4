<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class JoinCoursesAndFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // junction table creating many to many relationship between courses and files
        Schema::create('course_file', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('course_id')->unsigned();
            $table->integer('file_id')->unsigned();
            $table->timestamps();

            $table->foreign('course_id')
                  ->references('id')->on('courses')
                  ->onDelete('cascade');
            $table->foreign('file_id')
                  ->references('id')->on('files')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // destroy many to many relationship between courses and files
        Schema::drop('course_file');
    }
}
