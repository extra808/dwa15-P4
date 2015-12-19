@extends('layouts.master')

@section('title')
{{ $title or '' }}
@endsection

@section('content')
    <h1>{{ $title or '' }}</h1>

    <table class="table download-file">
    <thead>
    <tr>
        <th>File</th> 
        <th>Uploaded</th> 
        <th>Edit / Delete</th>
    </tr>
    </thead>
    @foreach($files as $file)
        <tr>
            <td><a href="{{ $_SERVER['REQUEST_URI'] .'/files/'. $file->id }}">
                {{ $file->name }}</a></td>
            <td>{{ $file->updated_at->timezone('America/New_York') 
                    ->format('g:i a M d') }}</td>
            <td>
                <form action="{{ $_SERVER['REQUEST_URI'] .'/files/'. $file->id }}" 
                    method="POST">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type='hidden' value='{{ csrf_token() }}' name='_token'>

                    <div class="btn-group-sm" role="group">
                        <a class="btn btn-warning" href="{{ $_SERVER['REQUEST_URI'] 
                        .'/files/'. $file->id .'/edit' }}">
                        Edit <span class="sr-only">{{ $file->name }}</span></a>

                        <button class="btn btn-danger" type="submit" name="delete {{ 
                            $file->name }}">
                            Delete File <span class="sr-only">{{ $file->name }}</span>
                        </button>
                    </div>

                </form>
            </td>
        </tr>
    @endforeach
    </table>
@stop