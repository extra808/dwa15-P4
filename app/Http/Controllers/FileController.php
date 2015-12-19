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
    public function index()
    {
        $title = 'List All Files';

        // get courses
        $files = \ATC\File::all()->sortBy('name');

        return view('file.index') ->withTitle($title) ->withFiles($files);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $courses = \ATC\Course::with('student')->orderBy('name', 'asc')->get();

        $title = 'Add File';
 
        return view('file.create') ->withTitle($title) ->withCourses($courses);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // check the course
        $course = \ATC\Course::getCourseWithOrFail($request->course);

        // create new file or find existing file with same name and 
        // same path, i.e. uploaded in same session
        $file = \ATC\File::firstOrNew([
              'name' => $request->file('uploaded_file')->getClientOriginalName()
            , 'path' => Session::getId()
            ]);

        // save file
        if($file->saveFile($request, $course->id) ) {
            return redirect()->action('CourseController@show', 
                                        [$course->student->id, $course->id]);
        }
        else {
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
        // get a file
        $file = \ATC\File::getFileOrFail($id);

        // download file
        return response()->download($destinationPath = storage_path() .'/files/'. 
                                    $file->path .'/'. $file->name);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $courses = \ATC\Course::with('student')->orderBy('name', 'asc')->get();

        // get a file
        $file = \ATC\File::getFileOrFail($id);

        $title = 'Edit '. $file->name;

        return view('file.edit') ->withTitle($title) ->withFile($file)  
                ->withCourses($courses);
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
        $file = \ATC\File::getFileOrFail($id);

        // save file
        if($file->saveFile($request) ) {
            return redirect()->action('FileController@edit', [$file]);
        }
        else {
            return back()->withInput();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
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
            Session::flash('flash_message', $file->name 
                            .' <strong>NOT</strong> deleted');
        }

        // go to list view
        return redirect('/files');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addCourse($id)
    {
        $courses = \ATC\Course::with('student')->orderBy('name', 'asc')->get();

        // get a file
        $file = \ATC\File::getFileOrFail($id);

        $title = 'Add Course to '. $file->name;

        return view('file.add') ->withTitle($title) ->withFile($file)  
                ->withCourses($courses);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateCourse(Request $request, $id)
    {
        // check the course
        $course = \ATC\Course::getCourseWithOrFail($request->course);

        // get a file
        $file = \ATC\File::getFileOrFail($id);

        // save update
        if($file->saveFileCourse($course->id) ) {
            return redirect()->action('CourseController@show', 
                                        [$course->student->id, $course->id]);
        }
        else {
            return back()->withInput();
        }
    }

    /**
     * Display a listing of files with no courses.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexOrphans()
    {
        // get files with no relations to any courses
        $files = \ATC\File::has('courses', '<', 1)->orderBy('name', 'desc')->get();

        $title = 'List Orphan Files';

        return view('file.index') ->withTitle($title) ->withFiles($files);
    }
}
