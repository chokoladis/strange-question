@extends('layouts.app')

@section('content')
    <div class="page-questions container">
        @foreach ($questions as $question)

            @php
                if ($question->right_comment_id){
                    $mainClass = 'border-success';
                } else {
                    $mainClass = '';
                }
            @endphp

            <div class="item card mb-3 {{ $mainClass }} ">
                <a href="{{ route('question.detail', $question->code) }}" class="row g-0">
                    <div class="col-sm-4 col-md-3">
                        <img src="{{ Storage::url('questions/'.$question->file?->path); }}" alt="" class="img-fluid rounded-start" style="object-fit: contain; height: 100%;">
                    </div>
                    <div class="col-sm-8 col-md-9">
                        <div class="card-body">
                            <h5 class="card-title">{{ $question->title }}</h5>

                            @if ($question->right_comment_id)
                                <div class="answer card-text">
                                    <div class="user">
                                        <img src="{{ __('empty') }}" alt="">
                                        <p>{{ $question?->answer?->user->name }}</p>
                                    </div>
                                    <b class="text-success">{{ mb_strlen($question?->answer->text) > 60 ? mb_substr($question->answer->text, 0, 60) : $question?->answer->text }}</b>
                                    <p class="card-text"><small class="text-body-secondary">{{ $question->answer->created_at->diffForHumans() }}</small></p>
                                </div>
                            @endif
                            @if ($currentComment = $question->getCurrentUserComment())
                                <div class="current-user-comment alert alert-success" role="alert">
                                    <h5 class="alert-heading">{{ $currentComment->comment->user_comments->user->name }}</h4>
                                    <p class="mb-0">{{ $currentComment->comment->text }}</p>
                                </div>  
                            @endif
                            @if ($popularComment = $question->getPopularComment())
                                <div class="popular-answer alert alert-info" role="alert">
                                    <b class="alert-heading">{{ __('Самый популярный ответ') }}</b>
                                    <hr>
                                    <h5>{{ $popularComment->user_comments->user->name }}</h5>
                                    <p class="mb-0">{{ $popularComment->text }}</p>
                                </div>
                            @endif
                            

                            
                                <p class="card-text"><small class="text-body-secondary">{{ $question->created_at->diffForHumans() }}</small></p>
                                @if ($question->created_at != $question->updated_at)
                                    <p class="card-text"><small class="text-body-secondary">{{ __('Изменен ') . $question->updated_at->diffForHumans() }}</small></p>
                                @endif
                            
                        </div>
                    </div>
                </a>
            </div>
        @endforeach

        @if ($questions->isEmpty())
            <p>Вопросов пока никто не задавал -_-</p>
        @endif
    </div>
@endsection