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
    public function create($studentId)
    {
        $title = 'Add Course';
 
        $terms = \ATC\Term::all();

        return view('course.create') ->withTitle($title) ->withTerms($terms)
            ->withStudent($studentId);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($studentId, Request $request)
    {
        // store new course
        $course = new \ATC\Course();

        // attempt validation
        if ($course->validate($request) ) {
            $course->year = $request->year;
            $course->term_id = $request->term;
            $course->name = $request->name;
            $course->student_id = $studentId;
            $course->save(); // insert new course in table

            return redirect()->action('CourseController@show', [$studentId, $course]);
        }
        else {
            $errors = $course->getErrors();
            Session::flash('flash_message', $errors);
            return back()->withInput();
        }
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
    public function edit($studentId, $id)
    {
        // in case it's not found
        Session::flash('flash_message','Course not found.');

        // get course with its term and its files sorted newest to oldest
        $course = \ATC\Course::with(['term', 'files' => function ($query) {
                    $query->orderBy('updated_at', 'ASC');
                }])->findOrFail($id);

        // student found
        Session::remove('flash_message');

        $title = 'Edit '. $course->name;

        $terms = \ATC\Term::all();

        return view('course.edit') ->withTitle($title) ->withCourse($course)
             ->withTerms($terms);
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
