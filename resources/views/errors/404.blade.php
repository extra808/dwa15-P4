@extends('layouts.master')

@section('title')
{{ $title or '404' }}
@endsection

@section('content')
    <h1>
    @if(\Session::has('http_status') )
        {{ \Session::get('http_status') }}
    @else
        Page Not Found
    @endif
    </h1>

@stop