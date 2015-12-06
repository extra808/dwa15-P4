@extends('layouts.master')

@section('title')
{{ $title or '' }}
@endsection

@section('content')
    <h1>{{ $student->initials or '' }}</h1>

    <p>Last Modified: {{ $student->updated_at }}<br>
    </p>

    <form action="{{ $_SERVER['REQUEST_URI'] }}" method="POST">
        <input type="hidden" name="_method" value="DELETE">
        <input type='hidden' value='{{ csrf_token() }}' name='_token'>

        <div class="btn-group" role="group">
            <a class="btn btn-default" href="/{{ $_SERVER['REQUEST_URI'] }}/create">Add Course</a>
            <a class="btn btn-default" href="/{{ $_SERVER['REQUEST_URI'] }}/edit">Edit</a>

            <input class="btn btn-default" type="submit" name="delete" value="Delete">
        </div>

    </form>

    <ul>
    @foreach($courses as $course)
            <li><a href="{{ $_SERVER['REQUEST_URI'] .'/'. $course->id }}">
                {{ $course->name }}</a>
    @endforeach
    </ul>

@stop