<?php

namespace ATC;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    // student has one to many relationship to courses
    public function course() {
        return $this->hasMany('\App\Course');
    }
}
