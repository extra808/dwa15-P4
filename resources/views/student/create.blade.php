@extends('layouts.master')

@section('title')
{{ $title or '' }}
@endsection

@section('content')
    <h1>{{ $title or '' }}</h1>

    <form action="/students" method="POST">
        <input type='hidden' value='{{ csrf_token() }}' name='_token'>

@include('student.input')

        <div class="row">
            <input class="btn btn-primary" type="submit" name="add" value="Add Student">
             <a class="btn btn-default" href="/">Cancel</a>
       </div>
    </form>

@stop