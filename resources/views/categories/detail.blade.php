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
            <mark>
                <a href="{{ route("categories.index") }}">{{ __('Категории') }}</a>
                @php
                    if (!empty($parents)){
                        foreach ($parents as $item){
                            $class = $lastElem == $item ? '' : 'me-3';

                            echo '-> <a href="'. route("categories.detail", $item->code) .'" class="'. $class .'">'. $item->title .'</a>';
                        }
                    }                        
                @endphp
            </mark>
        </div>

        @if (!empty($childs))

            <div class="daughters mt-4">
                <h4>Подразделы</h4>

                <div class="category_slider">
                    @foreach ($childs as $item)
                        <div class="card" style="width: 18rem;">
                            <img src="{{ $item->file && $item->file->path ? Storage::url('categories/'.$item->file->path) : $SITE_NOPHOTO }}"
                                 class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">{{ $item->title }}</h5>
                                <a href="{{ route('categories.detail', $item->code) }}" class="btn btn-primary">link</a>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>

        @endif
    </div>
@endsection