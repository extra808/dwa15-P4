<?php

namespace ATC;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    private $rules;

    private $errors;

    function __construct() {
        $this->rules = array(
              'uploaded_file' => 'required'
            );
    }
    // many to many relationship with courses
    public function courses() {
        return $this->belongsToMany('\ATC\Course')->withTimestamps();
    }

    public function getErrors() {
        return $this->errors;
    }

    public function validate($data) {
        // make a new validator object
        $v = \Validator::make($data->all(), $this->rules);

        // check for failure
        if ($v->fails()) {
            // set errors and return false
            $this->errors = $v->errors();
            return false;
        }

        // validation pass
        return true;
    }
}
