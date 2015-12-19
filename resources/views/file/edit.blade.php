@extends('layouts.master')

@section('title')
{{ $title or '' }}
@endsection

@section('content')
    <h1>{{ $title or '' }}</h1>

    <form action="/files/{{ $file->id }}" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="_method" value="PUT">
        <input type='hidden' value='{{ csrf_token() }}' name='_token'>
        <div class="row">
            <div class="panel input-group">
                <label class="input-group-addon" for="uploaded_file">File</label>
                <input class="form-control" type="file" name="uploaded_file" 
                    id="uploaded_file">
            </div>

        </div>

        <div class="row">
            <input class="btn btn-primary" type="submit" name="add" value="Upload File">
            <a class="btn btn-default" href="../">Cancel</a>
        </div>
    </form>

@stop