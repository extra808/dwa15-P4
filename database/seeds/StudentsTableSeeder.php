<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class StudentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // number of records to create
        $numRows = 20;

        // create Faker object
        $faker = Faker::create(); 

        for ($i = 0; $i < $numRows; $i++) {
            // create model object
            $student = new \ATC\Student();
            $student->initials = $faker->unique()->regexify('[A-Z][a-z][A-Z]');
            $student->external_id= $faker->unique()->numberBetween(10000000,99999999);

            $student->save(); // insert new student in table
        }
    }
}
