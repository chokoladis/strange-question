@extends('layouts.app')

@push('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.23.0/dist/css/uikit.min.css" />
    @vite(['resources/scss/questions.scss'])
@endpush
@push('script')
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.23.0/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.23.0/dist/js/uikit-icons.min.js"></script>
    @vite(['resources/js/question.js'])
@endpush

@section('content')
    <div class="question-page container">
        @if($error)
            <div class="title error">
                <div class="description">
                    <img src="{{ Storage::url('404.gif') }}">
                    <div class="shadow"></div>
                    <h1>{{ $error }}</h1>
                </div>
            </div>
        @else
            <div class="title">
                <div class="actions">
                    @if(auth()->id())
                        <input type="hidden" id="question_id" value="{{ $question->id }}">
                        <div class="icon like btn {{ $questionUserStatus['status'] === 'like' ? 'btn-success' : 'btn-outline-success' }}" data-action="like">
                            <span class="uk-icon" uk-icon="chevron-up"></span>
                            <b>{{ $arStatuses['likes'] ?? 0 }}</b>
                        </div>
                        <div class="icon dislike btn {{ $questionUserStatus['status'] === 'dislike' ? 'btn-danger' : 'btn-outline-danger' }}" data-action="dislike">
                            <span class="uk-icon" uk-icon="chevron-down"></span>
                            <b>{{ $arStatuses['dislikes'] ?? 0 }}</b>
                        </div>
                    @else
                        <div class="icon like btn btn-success">
                            <span class="uk-icon" uk-icon="chevron-up"></span>
                            <b>{{ $arStatuses['likes'] ?? 0 }}</b>
                        </div>
                        <div class="icon dislike btn btn-danger">
                            <span class="uk-icon" uk-icon="chevron-down"></span>
                            <b>{{ $arStatuses['dislikes'] ?? 0 }}</b>
                        </div>
                    @endif
{{--                    текущий юзер -статус --}}

                </div>
                <div class="description">
                    <img src="{{ $question->file && $question->file->path ? Storage::url('questions/'.$question->file->path) : $SITE_NOPHOTO }}"
                         alt="...">
                    {{--во весь экран --}}
                    <div class="shadow"></div>
                    <h1>{{ $question->title }}</h1>
                </div>
            </div>
            <div class="comments">
                @if ($question->right_comment_id)
                    <div class="answer">
                        <div class="user">
                            <img src="{{ $question->right_comment->user->avatar ? Storage::url('users/'.$question->right_comment->user->avatar) : $SITE_NOPHOTO }}"
                                 alt="...">
                            <p>{{ $question->answer->user->name }}</p>
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
                                    <div class="icon">
                                        <img src="{{ $item->comment->user_comment->user->avatar ? Storage::url('users/'.$item->comment->user_comment->user->avatar->path) : $SITE_NOPHOTO }}" alt="">
                                    </div>
                                    <b>{{ $item->comment->user_comment->user->name }}</b>
                                </div>
                                <p><i class="comment_id text-info">{{ '#'.$item->comment->id }}</i>{{ empty($item->comment) ? 'Удаленный комментарий' : $item->comment->text }}</p>
                                <div class="under">
                                    <div class="btn btn-mini btn-link reply" data-comment="{{ $item->comment->id }}">{{ __('system.reply') }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            @if (auth()->user())
                <form action="{{ route('comments.store') }}" method="post" enctype="multipart/form-data">

                    <h4>Оставить комментарий</h4>

                    @csrf

                    <div class="mt-4 mb-2">
                        <input type="text" name="text" class="form-control" placeholder="Не правильно ебаные волки, широкую на широкую!">
                        @if ($errors->has('text'))
                            @foreach ($errors->get('text') as $item)
                                <p class="error">{{ $item  }}</p>
                            @endforeach
                        @endif
                    </div>

                    <div class="input-reply mb-2">

                        <div class="description badge bg-secondary">
                            <label class="form-label">{{ __('crud.comments.fields.comment_reply') }}</label>
                            <p><i class="comment_id text-info"></i><b></b></p>
                        </div>

                        <input type="hidden" name="comment_reply_id" value="">
                        @if ($errors->has('comment_reply_id'))
                            @foreach ($errors->get('comment_reply_id') as $item)
                                <p class="error">{{ $item  }}</p>
                            @endforeach
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary mb-3">{{ __('system.reply') }}</button>
                </form>
            @endif
        @endif
        <div class="category">
            <a href="{{route('categories.detail', $question->category->code)}}" class="btn btn-outline-primary">Все категории {{$question->category->title}}</a>
        </div>
    </div>
@endsection