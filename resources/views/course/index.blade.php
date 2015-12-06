@extends('layouts.master')

@section('title')
{{ $title or '' }}
@endsection

@section('content')
    <h1>{{ $title or '' }}</h1>

    <ul>
    @foreach($courses as $course)
            <li><a href="{{ $_SERVER['REQUEST_URI'] .'/'. $course->id }}">
                {{ $course->name }}</a>
    @endforeach
    </ul>

@stop
