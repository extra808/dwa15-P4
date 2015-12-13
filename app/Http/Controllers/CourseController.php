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
        $student = \ATC\Student::getStudentOrFail($studentId);

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
        \ATC\Student::getStudentOrFail($studentId);

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
        \ATC\Student::getStudentOrFail($studentId);

        // store new course
        $course = new \ATC\Course();

        // save updates
        if ($course->saveCourse($request, $course, $studentId) ) {
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
        \ATC\Student::getStudentOrFail($studentId);

        $course = \ATC\Course::getCourseWithOrFail($id);

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
        \ATC\Student::getStudentOrFail($studentId);

        $course = \ATC\Course::getCourseWithOrFail($id);

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
        \ATC\Student::getStudentOrFail($studentId);

        $course = \ATC\Course::getCourseWithOrFail($id);

        // save updates
        if ($course->saveCourse($request, $studentId) ) {
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
    public function destroy($studentId, $id)
    {
        // check the student
        \ATC\Student::getStudentOrFail($studentId);

        $course = \ATC\Course::getCourseWithOrFail($id);

        // delete course, will cascade to delete relations to files
        $course->delete();

        Session::flash('flash_message', $course->name.' deleted');

        // go to list view
        return redirect()->action('StudentController@show', [$studentId]);
    }

}
