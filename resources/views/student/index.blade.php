@extends('layouts.master')

@section('title')
{{ $title or '' }}
@endsection

@section('content')
    <h1>{{ $title or '' }}</h1>

    <div class="row">
        <p class="instructions">Click <a href="/students/create">Add Student</a> to add a new student. Click a student's initials to show and add courses or to edit or delete the student. Each course is unique to each student. Click a course name to show and add files or to edit or delete the student's course.
        </p>

        <ul class="lists students">
        @foreach($students as $student)
                <li><a href="{{ '/students/'. $student->id }}">
                    {{ $student->initials }}</a>
        @endforeach
        </ul>
    </div>

@stop