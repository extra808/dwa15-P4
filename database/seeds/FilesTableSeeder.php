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
        $numRows = 50;

        // create Faker object
        $faker = Faker::create(); 

        for ($i = 0; $i < $numRows; $i++) {
            // create model object
            $file = new \ATC\File();
            $file->name = $faker->lastName .' '. 
                          $faker->sentence(5) .
                          $faker->randomElement(['docx', 'pptx', 'pdf', 'html', 'tex']);

            $file->path = md5($file->name);

            $destinationPath = storage_path() .'/files/'. $file->path;

            // create directory, recursively
            mkdir($destinationPath, 0755, true);

            // write random image file data to file
            // file contents won't match filename extension
            file_put_contents($destinationPath .'/'. $file->name, 
                fopen($faker->imageUrl(320, 240, 'cats'), 'r'));

            // get filename extension from created file
            $file->type = pathinfo($destinationPath .'/'. $file->name, 
                PATHINFO_EXTENSION);
            $file->save(); // insert new file in table
        }
    }
}
