@extends('layouts.master')

@section('title')
{{ $title or '' }}
@endsection

@section('content')
    <h1>{{ $title or '' }}</h1>

    <form action="/students/{{ $student }}/courses/{{ $course }}/files" method="POST" enctype="multipart/form-data">
        <input type='hidden' value='{{ csrf_token() }}' name='_token'>

        <div class="row">
            <div class="input-group">
                <label class="input-group-addon" for="uploaded_file">File</label>
                <input class="form-control" type="file" name="uploaded_file" id="uploaded_file">
            </div>

        </div>

        <input class="btn btn-submit" type="submit" name="add" value="Upload File">
    </form>

@stop