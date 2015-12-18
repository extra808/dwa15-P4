@extends('layouts.master')

@section('title')
{{ $title or '' }}
@endsection

@section('content')
    <h1>{{ $title or '' }}</h1>

    <form action="/students/{{ $student->id }}" method="POST">
        <input type="hidden" name="_method" value="PUT">
        <input type='hidden' value='{{ csrf_token() }}' name='_token'>

        <div class="row">
            <div class="input-group col-md-2">
                <label class="input-group-addon" for="initials">Initials</label>
                <input class="form-control" type="text" name="initials" id="initials"
                value="{{ $student->initials }}">
            </div>
        </div>

        <div class="row">
            <div class="input-group col-md-3">
                <label class="input-group-addon" for="external_id">ID</label>
                <input class="form-control" type="text" name="external_id" id="external_id" value="{{ $student->external_id }}">
            </div>
        </div>

        <div class="row">
            <input class="btn btn-primary" type="submit" name="add" value="Save">
            <a class="btn btn-default" href=".">Cancel</a>
        </div>
    </form>

@stop