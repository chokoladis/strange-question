@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $question->title }}</h1>
        @if ($question?->right_comment_id)
            <div class="answer">
                <div class="user">
                    <img src="{{ __('empty') }}" alt="">
                    <p>{{ $question?->answer?->user->name }}</p>
                </div>
                <b>{{ mb_strlen($question?->answer->text) > 60 ? mb_substr($question->answer->text, 0, 60) : $question?->answer->text }}</b>
            </div>
        @endif
        @if($question->comments)
            @foreach ($question->comments as $item)
                {{ dump($item) }}  
            @endforeach
        @endif

        {{-- <form action="{{ route('comments.store') }}" method="post">
            
        </form> --}}
    </div>
@endsection