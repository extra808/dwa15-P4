@extends('layouts.master')

@section('title')
{{ $title or '' }}
@endsection

@section('content')
    <h1>{{ $title or '' }}</h1>

    @foreach($students as $student)
        <ul>
            <li><a href="{{ Route::getCurrentRoute()->getPath() .'/'. $student->id }}">
                {{ $student->initials }}</a>
        </ul>
    @endforeach

@stop