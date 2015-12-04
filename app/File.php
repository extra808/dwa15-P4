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

    public function setNameAttribute($value) {
        $this->attributes['name'] = $value;
        $this->attributes['path'] = md5($value);
    }

}
