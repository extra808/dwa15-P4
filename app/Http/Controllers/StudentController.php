<?php

namespace ATC\Http\Controllers;

use Illuminate\Http\Request;
use \Session;

use ATC\Http\Requests;
use ATC\Http\Controllers\Controller;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'List Students';
        // get students
        $students = \ATC\Student::orderBy('initials','ASC')->get();

        return view('student.index') ->withTitle($title) ->withStudents($students);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Add Student';
        return view('student.create') ->withTitle($title);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // store new student
        $student = new \ATC\Student();

        // attempt validation
        if ($student->validate($request) ) {
            $student->initials = $request->initials;
            $student->external_id = $request->external_id;
            $student->save(); // insert new student in table

            return redirect()->action('StudentController@show', [$student]);
        }
        else {
            $errors = $student->getErrors();
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
    public function show($id)
    {
        $title = 'Show Student';

        // in case it's not found
        Session::flash('flash_message','Student not found.');

        // get a student
        $student = \ATC\Student::findOrFail($id);

        // student found
        Session::remove('flash_message');

        $courses = \ATC\Course::where('student_id', $id) ->orderBy('name', 'ASC') ->get();

        return view('student.show') ->withTitle($title) ->withStudent($student) ->withCourses($courses);
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
