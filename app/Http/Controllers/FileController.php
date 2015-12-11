<?php

namespace ATC\Http\Controllers;

use Illuminate\Http\Request;
use Session;

use ATC\Http\Requests;
use ATC\Http\Controllers\Controller;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($studentId, $courseId)
    {
        // in case course is not found
        Session::flash('flash_message','Course not found.');

        // get the course
        $course = \ATC\Course::with('files') ->findOrFail($courseId);

        // course found
        Session::remove('flash_message');

        $title = 'List '. $course->name .' Files';

        // get courses
        $files = $course ->files() ->orderBy('updated_at', 'ASC') ->get();

        return view('file.index') ->withTitle($title) ->withFiles($files);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($studentId, $courseId)
    {
        $title = 'Add File';
 
        return view('file.create') ->withTitle($title) ->withStudent($studentId) 
            ->withCourse($courseId);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($studentId, $courseId, Request $request)
    {
        // store new file
        $file = new \ATC\File();

        // attempt validation
        if ($file->validate($request) ) {
            $file->name = $request->file('uploaded_file')->getClientOriginalName();
            $file->type = $request->file('uploaded_file')->getClientOriginalExtension();
            $file->path = Session::getId();
            $file->save(); // insert new file in table

            // save association between file and course
            $file->courses()->sync(array($courseId) );

            // move uploaded file to permanent location
            // path is uploader's session id so if they upload a file with the same name
            // in the same session it will be overwritten but users in other sessions
            // can upload files with the same name without uploading
            $destinationPath = storage_path() .'/files/'. $file->path;
            $request->file('uploaded_file')->move($destinationPath, $file->name );

            return redirect()->action('FileController@show', 
                [$studentId, $courseId, $file]);
        }
        else {
            $errors = $file->getErrors();
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
    public function show($studentId, $courseId, $id)
    {
        $title = 'Show File';

        // in case it's not found
        Session::flash('flash_message','File not found.');

        // get a student
        $file = \ATC\File::findOrFail($id);

        // student found
        Session::remove('flash_message');

        return view('file.show') ->withTitle($title) ->withFile($file);
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
