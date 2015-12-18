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
     * @param  int  $studentId
     * @param  int  $courseId
     * @return \Illuminate\Http\Response
     */
    public function index($studentId, $courseId)
    {
        // check the student
        \ATC\Student::getStudentOrFail($studentId);

        // get the course
        $course = \ATC\Course::getCourseWithOrFail($courseId);

        $title = 'List '. $course->name .' Files';

        // get courses
        $files = $course ->files() ->orderBy('updated_at', 'ASC') ->get();

        return view('file.index') ->withTitle($title) ->withFiles($files);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  int  $studentId
     * @param  int  $courseId
     * @return \Illuminate\Http\Response
     */
    public function create($studentId, $courseId)
    {
        // check the student
        $student = \ATC\Student::getStudentOrFail($studentId);

        // check the course
        $course = \ATC\Course::getCourseWithOrFail($courseId);

        $title = 'Add File';
 
        return view('file.create') ->withTitle($title) ->withStudent($student)
            ->withCourse($course);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  int  $studentId
     * @param  int  $courseId
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($studentId, $courseId, Request $request)
    {
        // check the student
        \ATC\Student::getStudentOrFail($studentId);

        // check the course
        \ATC\Course::getCourseWithOrFail($courseId);

        // create new file or find existing file with same name and 
        // same path, i.e. uploaded in same session
        $file = \ATC\File::firstOrNew([
              'name' => $request->file('uploaded_file')->getClientOriginalName()
            , 'path' => Session::getId()
            ]);

        // save file
        if($file->saveFile($request, $studentId, $courseId) ) {
            return redirect()->action('FileController@edit', 
                [$studentId, $courseId, $file]);
        }
        else {
            return back()->withInput();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $studentId
     * @param  int  $courseId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($studentId, $courseId, $id)
    {
        // check the student
        \ATC\Student::getStudentOrFail($studentId);

        // check the course
        \ATC\Course::getCourseWithOrFail($courseId);

        // get a file
        $file = \ATC\File::getFileOrFail($id);

        // download file
        return response()->download($destinationPath = storage_path() .'/files/'. $file->path .'/'. $file->name);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $studentId
     * @param  int  $courseId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($studentId, $courseId, $id)
    {
        // check the student
        $student = \ATC\Student::getStudentOrFail($studentId);

        // check the course
        $course = \ATC\Course::getCourseWithOrFail($courseId);

        // get a file
        $file = \ATC\File::getFileOrFail($id);

        $title = 'Edit '. $file->name;

        return view('file.edit') ->withTitle($title) ->withStudent($student)
            ->withCourse($course) ->withFile($file);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $studentId
     * @param  int  $courseId
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($studentId, $courseId, Request $request, $id)
    {
        // check the student
        \ATC\Student::getStudentOrFail($studentId);

        // check the course
        \ATC\Course::getCourseWithOrFail($courseId);

        $file = \ATC\File::getFileOrFail($id);

        // save file
        if($file->saveFile($request, $studentId, $courseId) ) {
            return redirect()->action('FileController@edit', 
                [$studentId, $courseId, $file]);
        }
        else {
            return back()->withInput();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $studentId
     * @param  int  $courseId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($studentId, $courseId, $id)
    {
        // check the student
        \ATC\Student::getStudentOrFail($studentId);

        // check the course
        \ATC\Course::getCourseWithOrFail($courseId);

        $file = \ATC\File::getFileOrFail($id);

        $destinationPath = storage_path() .'/files/'. $file->path;
        // delete file from filesystem
        if(unlink($destinationPath .'/'. $file->name) ) {
            // check if file was the only one in  directory
            $numFilesInDir = count(scandir($destinationPath) );
            // are there any files? '.' '..' count as files to scandir
            if ($numFilesInDir <= 2) {
                rmdir($destinationPath);
            }

            // delete file, will cascade to delete relations to files
            $file->delete();

            Session::flash('flash_message', $file->name.' deleted');
        }
        else {
            Session::flash('flash_message', $file->name.' <strong>NOT</strong> deleted');
        }

        // go to list view
        return redirect()->action('CourseController@show', [$studentId, $courseId]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $courseId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showStudentCourseFile($courseId, $id)
    {
        // get id of logged in student
        $studentId = \ATC\Student::where('external_id', '=', \Auth::user()->email)->get() ->first() ->id;

        return $this->show($studentId, $courseId, $id);
    }
}
