@extends('layouts.master')

@section('title')
{{ $title or '' }}
@endsection

@section('content')
    <h1>{{ $title or '' }}</h1>

    <p>Last Modified: {{ $course->updated_at }}<br>
        Term:  {{ $course->term->name }}
    </p>

    @if(Auth::check() && Auth::user()->role == 'staff')
        <form action="{{ $_SERVER['REQUEST_URI'] }}" method="POST">
            <input type="hidden" name="_method" value="DELETE">
            <input type='hidden' value='{{ csrf_token() }}' name='_token'>

            <div class="btn-group" role="group">
                <a class="btn btn-default" href="{{ $_SERVER['REQUEST_URI'] }}/files/create">Add File</a>
                <a class="btn btn-default" href="{{ $_SERVER['REQUEST_URI'] }}/edit">Edit Course</a>

                <input class="btn btn-default" type="submit" name="delete" value="Delete">
            </div>

        </form>
    @endif

    <p><a href="{{ $_SERVER['REQUEST_URI'] .'/files' }}">Files</a>
    </p>
    <ul>

    @foreach($course->files as $file)
            <li><a href="{{ $_SERVER['REQUEST_URI'] .'/files/'. $file->id }}">
                {{ $file->name }}</a>
    @endforeach

    </ul>

@stop