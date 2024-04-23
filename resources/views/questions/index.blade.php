@extends('layouts.app')

@section('content')
    <div class="container">
        @foreach ($questions as $question)
            <div class="block">
                <a href="{{ route('question.detail', $question->code) }}">{{ $question->title }}</a>
                <img src="{{ Storage::url('questions/'.$question->file?->path); }}" alt="">
            </div>
        @endforeach
    </div>
@endsection