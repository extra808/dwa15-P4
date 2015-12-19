@extends('layouts.master')

@section('title')
{{ $title or '' }}
@endsection

@section('content')
    <h1>{{ $title or '' }}</h1>

    <p>
    for Student <a href="/students/{{ $course->student_id }}">{{ 
                $course->student->initials }}</a>
    </p>

    <form action="/students/{{ $course->student_id }}/courses/{{ $course->id }}" 
        method="POST">
        <input type="hidden" name="_method" value="PUT">
        <input type='hidden' value='{{ csrf_token() }}' name='_token'>

        <div class="row">
            <div class="input-group col-md-2">
                <label class="input-group-addon" for="year">Year</label>
                <input class="form-control" type="text" name="year" id="year" 
                    value="{{ $course->year }}">
            </div>

        </div>

        <div class="row">
            <div class="input-group col-md-3">
                <label class="input-group-addon" for="term">Term</label>
                <select class="form-control" name="term" id="term">
                @foreach($terms as $term_key => $term_value)
                    {{ $selected = ($term_value->id == old('term') ) ? 'selected' : '' }}
                    
                    <option value="{{ $term_value->id }}" {{ $selected }}>
                        {{ $term_value->name }}
                    </option>
                @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="input-group col-md-3">
                <label class="input-group-addon" for="name">Name</label>
                <input class="form-control" type="text" name="name" id="name"
                value="{{ $course->name }}">
            </div>
        </div>

        <div class="row">
            <input class="btn btn-primary" type="submit" name="add" value="Save">
            <a class="btn btn-default" href=".">Cancel</a>
        </div>
    </form>

@stop