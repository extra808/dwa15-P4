<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $term = new \ATC\User();
        $term->name = 'Curtis Wilcox';
        $term->email = 'cwilcox@cognize.org';
        $term->role = 'staff';
        $term->save();

        $term = new \ATC\User();
        $term->name = 'Jill';
        $term->email = 'jill@cognize.org';
        $term->role = 'staff';
        $term->save();

        $term = new \ATC\User();
        $term->name = 'Jamal';
        $term->email = 'jamal@cognize.org';
        $term->role = 'student';
        $term->save();
    }
}
