@extends('layouts.master')

@section('title')
{{ $title or '404' }}
@endsection

@section('content')
    <h1>
    @if(\Session::has('flash_message') )
        {{ \Session::get('flash_message') }}
    @else
        Page Not Found
    @endif
    </h1>

@stop