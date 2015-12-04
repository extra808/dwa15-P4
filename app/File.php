<?php

namespace ATC;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    // many to many relationship with courses
    public function courses() {
        return $this->belongsToMany('\App\Course')->withTimestamps();;
    }
}
