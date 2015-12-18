<?php

namespace ATC;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Session;

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
        return $this->belongsToMany('\ATC\File')->orderBy('updated_at', 'desc')->withTimestamps();
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
    public static function getCourseWithOrFail($id) {
        // in case it's not found
        Session::flash('flash_message','Course not found.');

        // get course with its term and its files sorted newest to oldest
        $course = \ATC\Course::with(['term', 'files' => function ($query) {
                    $query->orderBy('updated_at', 'ASC');
                }])->findOrFail($id);

        // course found
        Session::remove('flash_message');

        return $course;
    }


    /**
     * Save sepecified resource or set errors
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $studentId
     * @return boolean
     */
    public function saveCourse(Request $request, $studentId) {
        // attempt validation
        if ($this->validate($request) ) {
            $this->year = $request->year;
            $this->term_id = $request->term;
            $this->name = $request->name;
            $this->student_id = $studentId;
            $this->save(); // update course in table

            return true;
        }
        else {
            $errors = $this->getErrors();
            Session::flash('flash_message', $errors);
            return false;
        }
    }
}
