<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call(UserTableSeeder::class);
        $this->call(TermsTableSeeder::class);
        $this->call(StudentsTableSeeder::class);
        $this->call(StaffTableSeeder::class);
        $this->call(FilesTableSeeder::class);
        $this->call(CoursesTableSeeder::class);

        Model::reguard();
    }
}
