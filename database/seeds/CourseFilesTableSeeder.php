<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CourseFilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // get ids of all the courses
        $course_ids = \ATC\Course::lists('id');

        // get ids of all the files
        $file_ids = \ATC\File::lists('id');

        // create Faker object
        $faker = Faker::create(); 

        foreach ($course_ids as $course_id) {
            // vary the number of files per course
            $filesPerCourse = $faker->numberBetween(1, 50);

            // create array for each course to choose file_ids from
            $course_file_ids = $file_ids->all();
            // randomize so files will be unique for each course not for all courses
            shuffle($course_file_ids);

            for ($i = 0; $i < $filesPerCourse; $i++) {
                DB::table('course_file')->insert([
                'created_at' => Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
                'course_id' => $course_id,
                'file_id' => array_pop($course_file_ids)
                ]);
            }
        }
    }
}
