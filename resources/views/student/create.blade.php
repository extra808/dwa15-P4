@extends('layouts.master')

@section('title')
{{ $title or '' }}
@endsection

@section('content')
    <h1>{{ $title or '' }}</h1>

    <form action="/students" method="POST">
        <input type='hidden' value='{{ csrf_token() }}' name='_token'>

@include('student.input')

        <input class="btn btn-submit" type="submit" name="add" value="Add Student">
    </form>

@stop