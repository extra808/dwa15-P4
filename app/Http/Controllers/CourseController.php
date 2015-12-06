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
     * @return \Illuminate\Http\Response
     */
    public function index($studentId)
    {
        // in case student is not found
        Session::flash('flash_message','Student not found.');

        // get the student
        $student = \ATC\Student::findOrFail($studentId);

        // student found
        Session::remove('flash_message');

        $title = 'List '. $student->initials .' Courses';

        // get courses
        $courses = \ATC\Course::where('student_id', $studentId) ->orderBy('name', 'ASC') ->get();

        return view('course.index') ->withTitle($title) ->withCourses($courses);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($studentId, $id)
    {
        // in case it's not found
        Session::flash('flash_message','Course not found.');

        // get course with its term and its files sorted newest to oldest
        $course = \ATC\Course::with(['term', 'files' => function ($query) {
                    $query->orderBy('updated_at', 'ASC');
                }])->findOrFail($id);

        // student found
        Session::remove('flash_message');

        $title = 'Show '. $course->name;

 //       $Course = \ATC\Course::where('course_id', $id) ->orderBy('name', 'ASC') ->get();

        return view('course.show') ->withTitle($title) ->withCourse($course);
//        return view('student.show') ->withTitle($title) ->withCourse($course) ->withFiles($files);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
