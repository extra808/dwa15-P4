<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // get ids of all the students
        $student_ids = \ATC\Student::lists('id');
        
        $coursesPerStudent = 4;

        // create Faker object
        $faker = Faker::create(); 

        foreach ($student_ids as $student_id) {
            for ($i = 0; $i < $coursesPerStudent; $i++) {
                // create model object
                $course = new \ATC\Course();

                $course->name = $faker->regexify('[A-Z][A-Z][A-Z][A-Z]') .' '.
                                $faker->numberBetween(100, 1999);

                $course->year = Carbon\Carbon::now()->year;
                $course->term_id = 1;
                $course->student_id = $student_id;
                $course->save(); // insert new course in table
            }
        }
    }
}
