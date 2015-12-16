@extends('layouts.master')

@section('title')
{{ $title or '403' }}
@endsection

@section('content')
    <h1>
    @if(\Session::has('flash_message') )
        {{ \Session::get('flash_message') }}
    @else
        403 Forbidden
    @endif
    </h1>

@stop