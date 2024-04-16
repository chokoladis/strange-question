@extends('layouts.app')

@section('content')
    <div class="container">
        <div id="banner" class="banner banner-centred banner-1">
            <img src="/storage/banner_1.png" alt="" class="bg">
            <h1 class="title">{{ __('Задай свой странный вопрос') }}</h1>
            <p>{{ __('и ты получишь странный ответ (:') }}</p>
            <a href="{{ route('question.add') }}" class="btn btn-purple">{{ __('*чпонк') }}</a>
        </div>
    </div>
@endsection