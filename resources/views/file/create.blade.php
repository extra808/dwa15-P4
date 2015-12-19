@extends('layouts.master')

@section('title')
{{ $title or '' }}
@endsection

@section('content')
    <h1>{{ $title or '' }}</h1>

    <p>Maximum File Size {{ ini_get('upload_max_filesize') }}
    </p>

    <form action="/files" method="POST" enctype="multipart/form-data">
        <input type='hidden' value='{{ csrf_token() }}' name='_token'>
        <div class="row">
            <div class="input-group col-md-3">
                <label class="input-group-addon" for="course">Course (Student)</label>
                <select class="form-control" name="course" id="course">
                    <option value=""></option>
                @foreach($courses as $course)
                    {{ $selected = ($course->id == old('course') ) ? 'selected' : '' }}
                    
                    <option value="{{ $course->id }}" {{ $selected }}>
                        {{ $course->name }} (Student {{ $course->student->initials }})
                    </option>
                @endforeach
                </select>
            </div>
        </div>
        <div class="row">
            <div class="panel input-group">
                <label class="input-group-addon" for="uploaded_file">File</label>
                <input class="form-control" type="file" name="uploaded_file" 
                    id="uploaded_file">
            </div>

        </div>

        <div class="row">
            <input class="btn btn-primary" type="submit" name="add" value="Upload File">
            <a class="btn btn-default" href="..">Cancel</a>
       </div>
    </form>

@stop
