<?php

namespace ATC;

use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    // term has one to many relationship to courses
    public function course() {
        return $this->hasMany('\ATC\Course');
    }
}
