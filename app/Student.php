<?php

namespace ATC;

use Illuminate\Database\Eloquent\Model;
use Session;

class Student extends Model
{
    private $rules = array(
        'initials' => 'required|alpha|min:2'
        , 'external_id'  => 'required'
    );

    private $errors;

    // student has one to many relationship to courses
    public function course() {
        return $this->hasMany('\ATC\Course');
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

    /**
     * Get sepecified resource or fail with HTTP 404
     *
     * @param  int  $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function getStudentOrFail($id) {
        // in case student is not found
        Session::flash('flash_message','Student not found.');

        // get the student
        $student = \ATC\Student::findOrFail($id);

        // student found
        Session::remove('flash_message');

        return $student;
    }
}
