@extends('layouts.master')

@section('title')
{{ $title or '' }}
@endsection

@section('content')
<?php $staff = FALSE; ?>
@if(Auth::check() && Auth::user()->role == 'staff')
    <?php $staff = TRUE; ?>
@endif

    <h1>{{ $title or '' }}</h1>

    <p>Term: {{ $course->term->name }}<br>
    For student <a href="..">
    @if ($staff)
        {{ $course->student->initials }}
    @else
        {{ Auth::user()->name }}
    @endif
    </a><br>
    Last Modified: {{ $course->updated_at->timezone('America/New_York') 
                        ->format('g:i a M d') }}
    </p>

    @if ($staff)
        <form action="{{ $_SERVER['REQUEST_URI'] }}" method="POST">
            <input type="hidden" name="_method" value="DELETE">
            <input type='hidden' value='{{ csrf_token() }}' name='_token'>

            <div class="btn-group" role="group">
                <a class="btn btn-primary" 
                    href="{{ $_SERVER['REQUEST_URI'] }}/files/create">Add File</a>
                <a class="btn btn-warning" 
                    href="{{ $_SERVER['REQUEST_URI'] }}/edit">Edit Course</a>

                <button class="btn btn-danger" type="submit" 
                    name="delete {{ $course->name }}">
                    Delete Course <span class="sr-only">{{ $course->name }}</span>
                </button>
            </div>

        </form>
    @endif

    <table class="table download-file">
    <thead>
    <tr>
        <th>File</th> 
        <th>Uploaded</th> 
        @if($staff)
            <th>Edit / Delete</th>
        @endif
    </tr>
    </thead>
    @foreach($course->files as $file)
        <tr>
            <td><a href="{{ $_SERVER['REQUEST_URI'] .'/files/'. $file->id }}">
                {{ $file->name }}</a></td>
            <td>{{ $file->updated_at->timezone('America/New_York') 
                    ->format('g:i a M d') }}</td>
            @if($staff)
            <td>
                <form action="{{ $_SERVER['REQUEST_URI'] .'/files/'. $file->id }}" 
                    method="POST">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type='hidden' value='{{ csrf_token() }}' name='_token'>

                    <div class="btn-group-sm" role="group">
                        <a class="btn btn-warning" 
                            href="{{ $_SERVER['REQUEST_URI'] .'/files/'. $file->id 
                            .'/edit' }}">
                            Edit <span class="sr-only">{{ $file->name }}</span></a>

                        <button class="btn btn-danger" type="submit" name="remove">
                            Remove from Course <span class="sr-only">{{ 
                            $file->name }}</span>
                        </button>

                        <button class="btn btn-danger" type="submit" name="delete {{ 
                            $file->name }}">
                            Delete File <span class="sr-only">{{ $file->name }}</span>
                        </button>
                    </div>

                </form>
            </td>
            @endif
        </tr>
    @endforeach
    </table>
@stop