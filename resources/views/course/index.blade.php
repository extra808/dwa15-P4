@extends('layouts.master')

@section('title')
{{ $title or '' }}
@endsection

@section('content')
    <h1>{{ $title or '' }}</h1>

    <h2>Courses</h2>

    <ul class="lists">
    @foreach($courses as $course)
        <li><a href="{{ $_SERVER['REQUEST_URI'] .'/courses/'. $course->id }}">
            {{ $course->name }}, {{ $course->term->name }} {{ $course->year }}</a>
        </li>
    @endforeach
    </ul>

@stop
