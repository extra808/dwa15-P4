@extends('layouts.master')

@section('title')
{{ $title or '' }}
@endsection

@section('content')
    <h1><a download href="{{ $_SERVER['REQUEST_URI'] }}/{{ $file->name }}">{{ $file->name }}</a></h1>

    <p>Last Modified: {{ $file->updated_at }}<br>
    </p>

    <form action="{{ $_SERVER['REQUEST_URI'] }}" method="POST">
        <input type="hidden" name="_method" value="DELETE">
        <input type='hidden' value='{{ csrf_token() }}' name='_token'>

        <div class="btn-group" role="group">
            <a class="btn btn-default" href="{{ $_SERVER['REQUEST_URI'] }}/edit">Edit</a>

            <input class="btn btn-default" type="submit" name="delete" value="Delete File">
        </div>

    </form>

@stop