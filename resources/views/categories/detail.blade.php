@extends('layouts.app')

@push('style')
    @vite(['resources/scss/categories.scss'])
@endpush

@php
    $parents = $category->getParents();

    $title = $category->title; 
    $lastElem = end($parents);
@endphp

@section('content')
    <div class="category-detail container">
        @if ($category->file)
            <div class="category-img">
                {{-- todo dual img with opacity --}}
                <img src="{{ Storage::url('categories/'. $category->file?->path ) }}" alt="">
            </div>
        @endif

        <h1>{{ $title }}</h1>

        <div class="parents fw-light mt-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">
                        <a href="{{ route("categories.index") }}">{{ __('Категории') }}</a>
                    </li>

                    @if (!empty($parents))
                        @foreach ($parents as $item)
                            <li class="breadcrumb-item active" aria-current="page">
                                <a href="{{ route("categories.detail", $item->code) }}">{{ $item->title }}</a>
                            </li>
                        @endforeach
                   @endif
                </ol>
            </nav>
        </div>

        @if (!empty($childs))

            <div class="daughters mt-4">
                <h4>Подразделы</h4>

                <x-category-slider :childs="$childs"></x-category-slider>
            </div>

        @endif

        @if (!empty($questions))
            <div class="questions_block">
                <h4>{{ __('Вопросы') }}</h4>
                <div class="list-group">
                    @foreach($questions as $question)
                        <li class="list-group-item @if($question->right_comment_id) list-group-item-success @endif">
                            <a href="{{ route('questions.detail', $question->code) }}">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">{{ $question->title }}</h5>
                                    <small>{{ $question->created_at }}</small>
                                </div>
                            </a>
                            <span class="badge rounded-pill {{ $question->comments > 0 ? 'text-bg-primary' : 'text-bg-secondary' }}">{{ $question->comments ?? 0 }}</span>
                        </li>
                    @endforeach
                </div>
                <div class="pagination">

                </div>
            </div>
        @endif
    </div>
@endsection