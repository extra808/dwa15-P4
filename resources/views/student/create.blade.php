@extends('layouts.master')

@section('title')
{{ $title or '' }}
@endsection

@section('content')
    <h1>{{ $title or '' }}</h1>

    <form action="/students" method="POST">
        <input type='hidden' value='{{ csrf_token() }}' name='_token'>

        <div class="row">
            <div class="input-group col-md-1">
                <label class="input-group-addon" for="initials">Initials</label>
                <input class="form-control" type="text" name="initials" id="initials"
                value="{{ old('initials', '') }}">
            </div>
        </div>

        <div class="row">
            <div class="input-group col-md-1">
                <label class="input-group-addon" for="external_id">ID</label>
                <input class="form-control" type="text" name="external_id" id="external_id" value="{{ old('external_id', '') }}">
            </div>
        </div>

        <input class="btn btn-submit" type="submit" name="add" value="Add Student">
    </form>

@stop