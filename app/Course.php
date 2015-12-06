<?php

namespace ATC;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    // many courses may belong to one student
    // inverse of one to many relationship
    public function student() {
        return $this->belongsTo('\ATC\Student');
    }

    // many courses may belong to one term
    // inverse of one to many relationship
    public function term() {
        return $this->belongsTo('\ATC\Term');
    }

    // many to many relationship with courses
    public function files() {
        return $this->belongsToMany('\ATC\File')->withTimestamps();
    }

}
