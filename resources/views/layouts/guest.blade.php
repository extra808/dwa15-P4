@extends('layouts.master')

@section('title')
{{ $title or '' }}
@endsection

@section('content')
    <h1>ATC Delivery</h1>

    <p>This site is for the delivery of materials produced for the student clients of the Assistive Technology Center.
    </p>

    <p>Students: <a href="/google/authorize">Login with Google</a> to download course files
    </p>

@stop