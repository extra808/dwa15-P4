@extends('layouts.master')

@section('title')
{{ $title or '401' }}
@endsection

@section('content')
    <h1>
    @if(\Session::has('flash_message') )
        {{ \Session::get('flash_message') }}
    @else
        Unauthorized
    @endif
    </h1>

@stop