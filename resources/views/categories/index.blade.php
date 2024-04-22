@php use Illuminate\Support\Str; @endphp
@extends('layouts.app')

@section('content')
    <div class="container">
        @foreach ($categories as $item)
            <a href="{{ route('category.detail', $item->code ) }}">{{ $item->title }}</a>
        @endforeach
    </div>
@endsection