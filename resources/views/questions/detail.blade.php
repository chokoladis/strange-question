@extends('layouts.app')

@push('style')
    @vite(['resources/scss/questions.scss'])
@endpush

@section('content')
    <div class="detail-page container">
        <div class="title">
            <div class="actions">
                <div class="icon dislike"></div>
                <div class="icon like"></div>
            </div>
            <h1>{{ $question->title }}</h1>
        </div>
        <div class="comments">
            @if ($question?->right_comment_id)
                <div class="answer">
                    <div class="user">
                        <img src="{{ __('empty') }}" alt="">
                        <p>{{ $question?->answer?->user->name }}</p>
                    </div>
                    <b>{{ mb_strlen($question?->answer->text) > 60 ? mb_substr($question->answer->text, 0, 60) : $question?->answer->text }}</b>
                </div>
            @endif
            @if($question->question_comment)
                @foreach ($question->question_comment as $item)
                    <div class="comment {{ empty($item->comment) ? 'deleted' : '' }}">
                        <div class="actions">
                            <div class="icon dislike"></div>
                            <div class="icon like"></div>
                        </div>
                        <div class="main">
                            <div class="user">
                                <div class="icon"></div>
                                <b>{{ $item->comment->user_comments?->user->name }}</b>
                            </div>
                            <p>{{ empty($item->comment) ? 'Удаленный комментарий' : $item->comment->text }}</p>
                            <div class="under">
                                <div class="btn btn-mini btn-link reply" data-comment="{{ $item->comment->id }}">{{ __('system.reply') }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        
        @if (auth()->user())
            <form action="{{ route('comment.store') }}" method="post">

                <h4>Оставить комментарий</h4>

                @csrf

                <div class="mt-4 mb-2">
                    <label class="form-label">{{ __('crud.comments.fields.text') }}</label>
                    <input type="text" name="text" class="form-control" placeholder="Не правильно ебаные волки, широкую на широкую!">
                    @if ($errors->has('text'))
                        @foreach ($errors->get('text') as $item)
                            <p class="error">{{ $item  }}</p>
                        @endforeach
                    @endif
                </div>

                <div class="mb-2 d-none">
                    <label class="form-label">{{ __('crud.comments.fields.comment_reply') }}</label>
                    <input type="hidden" name="comment_reply" value="0">
                    @if ($errors->has('comment_reply'))
                        @foreach ($errors->get('comment_reply') as $item)
                            <p class="error">{{ $item  }}</p>
                        @endforeach
                    @endif
                </div>
                
                <button type="submit" class="btn btn-primary mb-3">{{ __('system.reply') }}</button>
            
            </form>
        @endif
    </div>
@endsection