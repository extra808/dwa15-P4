@extends('layouts.master')

@section('title')
{{ $title or '' }}
@endsection

@section('content')
    <h1>{{ $title or '' }}</h1>

    <form action="/students/{{ $student }}/courses" method="POST">
        <input type='hidden' value='{{ csrf_token() }}' name='_token'>

@include('course.input')

        <input class="btn btn-submit" type="submit" name="add" value="Add Course">
    </form>

@stop