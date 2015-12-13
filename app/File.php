<?php

namespace ATC;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Session;

class File extends Model
{
    private $rules;

    private $errors;

    function __construct() {
        $this->rules = array(
              'uploaded_file' => 'required'
            );
    }
    // many to many relationship with courses
    public function courses() {
        return $this->belongsToMany('\ATC\Course')->withTimestamps();
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

    public static function getFileOrFail($id) {
        // in case it's not found
        Session::flash('flash_message','File not found.');

        // get a file
        $file = \ATC\File::findOrFail($id);

        // file found
        Session::remove('flash_message');

        return $file;
    }

    /**
     * Save sepecified resource or set errors
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $studentId
     * @param  int  $courseId
     * @return boolean
     */
    public function saveFile(Request $request, $studentId, $courseId) {
        // attempt validation
        if ($this->validate($request) ) {
            $uploadName = $request->file('uploaded_file')->getClientOriginalName();

            $this->path = Session::getId();
            $destinationPath = storage_path() .'/files/'. $this->path;

            // totally new file?
            if($this->name == NULL) {
                // set file name in record
                $this->name = $uploadName;
            }
            // does new file have a different name?
            elseif($this->name != $uploadName) {
                // delete old file
                unlink($destinationPath .'/'. $this->name);
                // change file name in record
                $this->name = $uploadName;
            }

            $this->type = $request->file('uploaded_file')->getClientOriginalExtension();
            $this->save(); // insert file in table

            // save association between file and course
            $this->courses()->sync(array($courseId) );

            // move uploaded file to permanent location
            // path is uploader's session id so if they upload a file with the same name
            // in the same session it will be overwritten but users in other sessions
            // can upload files with the same name without uploading
            $request->file('uploaded_file')->move($destinationPath, $this->name );

            return true;

            return redirect()->action('FileController@show', 
                [$studentId, $courseId, $file]);
        }
        else {
            $errors = $this->getErrors();
            Session::flash('flash_message', $errors);

            return false;

            return back()->withInput();
        }
    }

}
