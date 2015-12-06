<?php

namespace ATC;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    private $rules = array(
        'initials' => 'required|alpha|min:2',
        'external_id'  => 'required',
    );

    private $errors;

    // student has one to many relationship to courses
    public function course() {
        return $this->hasMany('\App\Course');
    }

    public function getErrors() {
        return $this->errors;
    }

    public function validate($data) {
        // make a new validator object
        $v = \Validator::make($data->all(), $this->rules);
        // return the result
        return $v->passes();

        // check for failure
        if ($v->fails()) {
            // set errors and return false
            $this->errors = $v->errors;
            return false;
        }

        // validation pass
        return true;
    }
}
