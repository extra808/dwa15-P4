@extends('layouts.master')

@section('title')
{{ $title or '' }}
@endsection

@section('content')
    <p>Students: <a href="/google/authorize">Login with Google</a> to download course files
    </p>

@stop