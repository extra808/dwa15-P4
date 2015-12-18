<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class StaffTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $staff = new \ATC\Staff();
        $staff->name = 'Curtis Wilcox';
        $staff->external_id = 'cwilcox@cognize.org';
        $staff->save();

        $staff = new \ATC\Staff();
        $staff->name = 'Jill';
        $staff->external_id = 'jill@cognize.org';
        $staff->save();

        // number of records to create
        $numRows = 7;

        // create Faker object
        $faker = Faker::create(); 

        for ($i = 0; $i < $numRows; $i++) {
            // create model object
            $staff = new \ATC\Staff();
            $staff->name =  $faker->name;
            $staff->external_id= $faker->unique()->numberBetween(10000000,99999999);

            $staff->save(); // insert new staff member in table
        }
    }
}
