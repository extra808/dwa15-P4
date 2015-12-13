<?php

namespace ATC\Http\Controllers;

use Illuminate\Http\Request;
use Session;

use ATC\Http\Requests;
use ATC\Http\Controllers\Controller;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  int  $studentId
     * @return \Illuminate\Http\Response
     */
    public function index($studentId)
    {
        // get the student
        $student = $this->getStudentOrFail($studentId);

        $title = 'List '. $student->initials .' Courses';

        // get courses
        $courses = \ATC\Course::where('student_id', $studentId) ->orderBy('name', 'ASC') ->get();

        return view('course.index') ->withTitle($title) ->withCourses($courses);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  int  $studentId
     * @return \Illuminate\Http\Response
     */
    public function create($studentId)
    {
        // check the student
        $this->getStudentOrFail($studentId);

        $title = 'Add Course';
 
        $terms = \ATC\Term::all();

        return view('course.create') ->withTitle($title) ->withTerms($terms)
            ->withStudent($studentId);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  int  $studentId
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($studentId, Request $request)
    {
        // check the student
        $this->getStudentOrFail($studentId);

        // store new course
        $course = new \ATC\Course();

        // save updates
        if ($this->saveCourse($request, $course, $studentId) ) {
            return redirect()->action('CourseController@show', [$studentId, $course]);
        }
        else {
            return back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $studentId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($studentId, $id)
    {
        // check the student
        $this->getStudentOrFail($studentId);

        $course = $this->getCourseWithOrFail($id);

        $title = 'Show '. $course->name;

        return view('course.show') ->withTitle($title) ->withCourse($course);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $studentId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($studentId, $id)
    {
        // check the student
        $this->getStudentOrFail($studentId);

        $course = $this->getCourseWithOrFail($id);

        $title = 'Edit '. $course->name;

        $terms = \ATC\Term::all();

        return view('course.edit') ->withTitle($title) ->withCourse($course)
             ->withTerms($terms);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $studentId
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($studentId, Request $request, $id)
    {
        // check the student
        $this->getStudentOrFail($studentId);

        $course = $this->getCourseWithOrFail($id);

        // save updates
        if ($this->saveCourse($request, $course, $studentId) ) {
            return redirect()->action('CourseController@show', [$studentId, $course]);
        }
        else {
            return back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $studentId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // check the student
        $this->getStudentOrFail($studentId);

    }

    /**
     * Get sepecified resource or fail with HTTP 404
     *
     * @param  int  $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    private function getStudentOrFail($id) {
        // in case student is not found
        Session::flash('flash_message','Student not found.');

        // get the student
        $student = \ATC\Student::findOrFail($id);

        // student found
        Session::remove('flash_message');

        return $student;
    }

    /**
     * Get sepecified resource or fail with HTTP 404
     *
     * @param  int  $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    private function getCourseWithOrFail($id) {
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
     * @param \Illuminate\Database\Eloquent\Model $course
     * @param  int  $studentId
     * @return boolean
     */
    private function saveCourse(Request $request, $course, $studentId) {
        // attempt validation
        if ($course->validate($request) ) {
            $course->year = $request->year;
            $course->term_id = $request->term;
            $course->name = $request->name;
            $course->student_id = $studentId;
            $course->save(); // update course in table

            return true;
//            return redirect()->action('CourseController@show', [$studentId, $course]);
        }
        else {
            $errors = $course->getErrors();
            Session::flash('flash_message', $errors);
            return false;
//            return back()->withInput();
        }
    }
}
