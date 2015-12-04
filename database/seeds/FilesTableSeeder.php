<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class FilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // number of records to create
        $numRows = 100;

        // create Faker object
        $faker = Faker::create(); 

        for ($i = 0; $i < $numRows; $i++) {
            // create model object
            $file = new \ATC\File();
            $file->name = $faker->lastName .' '. 
                          $faker->sentence(5) .
                          $faker->randomElement(['docx', 'pptx', 'pdf', 'html', 'tex']);

            $file->save(); // insert new student in table
        }
    }
}
