@extends('layouts.master')

@section('title')
{{ $title or '' }}
@endsection

@section('content')
    <h1>{{ $title or '' }}</h1>

    <ul>
    @foreach($files as $file)
            <li><a download class="download-file" href="{{ $_SERVER['REQUEST_URI'] }}/{{ $file->name }}">{{ $file->name }}</a>
    @endforeach
    </ul>

@stop