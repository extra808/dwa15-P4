@extends('layouts.master')

@section('title')
{{ $title or '' }}
@endsection

{{-- when viewed from student's home page, remove extra slash --}}
{{ ($_SERVER['REQUEST_URI'] == '/') ? $_SERVER['REQUEST_URI'] = '' : '' }}

@section('content')
    @if(Auth::check() && Auth::user()->role == 'staff')
        <h1>Student {{ $student->initials or '' }}</h1>

        <p>Last Modified: {{ $student->updated_at->timezone('America/New_York') 
                            ->format('g:i a M d') }}
        </p>

        <form action="{{ $_SERVER['REQUEST_URI'] }}" method="POST">
            <input type="hidden" name="_method" value="DELETE">
            <input type='hidden' value='{{ csrf_token() }}' name='_token'>

            <div class="btn-group" role="group">
                <a class="btn btn-primary" href="{{ 
                    $_SERVER['REQUEST_URI'] }}/courses/create">Add Course</a>
                <a class="btn btn-warning" href="{{ 
                    $_SERVER['REQUEST_URI'] }}/edit">Edit Student</a>

                <button class="btn btn-danger" type="submit" name="delete {{ 
                    $student->name }}">
                    Delete Student <span class="sr-only">{{ $student->name }}</span>
                </button>
            </div>

        </form>
    @else
        <h1>{{ Auth::user()->name }}</h1>
    @endif

    <h2>Courses</h2>
    <ul>
    @foreach($courses as $course)
            <li><a href="{{ $_SERVER['REQUEST_URI'] .'/courses/'. $course->id }}">
                {{ $course->name }}</a>
    @endforeach
    </ul>

@stop