@extends('layouts.app')

@php
    $parents = $category->getParents();
    $title = $category->title; 
    // class text-truncate
@endphp

@section('content')
    <div class="container">
        <h1>{{ $title }}</h1>
        @if ($parents)
            <div class="subcategories fw-light mt-4">
                <mark>{{ __('Является подразделом след. разделов:') }}</mark>
                <p class="m-0">{!! $parents !!}</p>
            </div>
        @endif
    </div>
@endsection