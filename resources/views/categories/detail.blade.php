@push('style')
    @vite(['resources/scss/categories.scss'])
@endpush

@extends('layouts.app')

@php
    $parents = $category->getParents($category);
    $title = $category->title; 
    $lastElem = end($parents);
@endphp

@section('content')
    <div class="category-detail container">
        @if ($category->file)
            <div class="category-img">
                {{-- todo dual img with opacity --}}
                <img src="{{ Storage::url('categories/'. $category->file->path ) }}" alt="">
            </div>
        @endif

        <h1>{{ $title }}</h1>

        @if (!empty($parents))
            <div class="subcategories fw-light mt-4">
                <mark>{{ __('Является подразделом след. разделов:') }}</mark>
                @php
                    foreach ($parents as $item){
                        $class = $lastElem == $item ? '' : 'me-3';

                        echo '<a href="'. route("category.detail", $item->code) .'" class="'. $class .'">'. $item->title .'</a>';
                    }
                @endphp
            </div>
        @endif
    </div>
@endsection