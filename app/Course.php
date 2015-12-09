<?php

namespace ATC;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    private $year_min;
    private $year_max;
    private $rules;

    private $errors;

    function __construct() {
        $this->year_min = \Carbon\Carbon::now()->year - 1;
        $this->year_max = \Carbon\Carbon::now()->year + 1;

        $this->rules = array(
              'year' => 'required|integer|min:'. $this->year_min .'|max:'. $this->year_max
            , 'name' => 'required'
            );
    }

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
