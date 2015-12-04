<?php

namespace ATC;

use Illuminate\Database\Eloquent\Model;
use Hash;

class File extends Model
{
    // many to many relationship with courses
    public function courses() {
        return $this->belongsToMany('\App\Course')->withTimestamps();;
    }

    // mutator to create path based on file name
    public function setNameAttribute($value) {
        $this->attributes['name'] = $value;
        
        // salt added to prevent path guessing for known file names
        $salt = 'HAT';
        $this->attributes['path'] = md5($value . $salt);
    }

}
