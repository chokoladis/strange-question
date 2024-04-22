@extends('layouts.app')

@section('content')
    <div class="container">
        @foreach ($questions as $question)
            <div class="block">
                <a href="{{ $question->code }}">{{ $question->title }}</a>
                <img src="{{ public_path(). $question->file?->path }}" alt="">
            </div>
        @endforeach
    </div>
@endsection