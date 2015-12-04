<?php

use Illuminate\Database\Seeder;

class TermsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = ['Fall','Spring','Summer','Winter','Research'];

        foreach($data as $termName) {
            $term = new \ATC\Term();
            $term->name = $termName;
            $term->save();
        }
    }
}
