@extends('layouts.master')

@section('title')
{{ $title or '403' }}
@endsection

@section('content')
    <h1>
    @if(\Session::has('http_status') )
        {{ \Session::get('http_status') }}
    @else
        403 Forbidden
    @endif
    </h1>

@stop