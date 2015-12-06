@extends('layouts.master')

@section('title')
{{ $title or '' }}
@endsection

@section('content')
    <h1>{{ $title or '' }}</h1>

    <ul>
    @foreach($students as $student)
            <li><a href="{{ $_SERVER['REQUEST_URI'] .'/'. $student->id }}">
                {{ $student->initials }}</a>
    @endforeach
    </ul>

@stop