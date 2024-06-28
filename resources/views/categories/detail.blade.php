@push('style')
    @vite(['resources/scss/categories.scss'])
@endpush

@extends('layouts.app')

@php

    // $childs = $category->getCurrCategoryChilds();
    $parents = $category->getParentsCategories();

    dd($childs);
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
                @if (!empty($parents))
                    @php
                        foreach ($parents as $item){
                            $class = $lastElem == $item ? '' : 'me-3';

                            echo '-> <a href="'. route("category.detail", $item->code) .'" class="'. $class .'">'. $item->title .'</a>';
                        }
                    @endphp
                @endif
            </mark>
        </div>

        @if (!empty($daughters))
            <div class="daughters mt-4">
                <h4>Подразделы</h4>
                <div class="slider">
                    @foreach ($daughters as $item)
                    
                        
                        <div class="card" style="width: 18rem;">
                            <img src="{{ Storage::url('categories/'.$item->file?->path) }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">{{ $item->title }}</h5>
                                <a href="{{ route('category.detail', $item->code) }}" class="btn btn-primary">link</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection