@extends('layouts.app')

@push('style')
    @vite(['resources/css/slick.css', 'resources/css/slick-theme.css'])
@endpush
@push('script')
    @vite(['resources/js/slick.min.js', 'resources/js/main.js'])
@endpush

@section('content')
    <div class="container">
        {{-- component - banner-slider --}}
        <x-main-slider/>
        <div id="banner" class="banner banner-centred banner-1">
            <img src="/storage/banner_1.png" alt="" class="bg">
            <h1 class="title">{{ __('Задай свой странный вопрос') }}</h1>
            <p>{{ __('и ты получишь странный ответ (:') }}</p>
            <a href="{{ route('questions.add') }}" class="btn btn-purple">{{ __('*чпонк') }}</a>
        </div>
    </div>
@endsection