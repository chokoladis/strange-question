@php use Illuminate\Support\Str; @endphp

@push('style')
    @vite(['resources/scss/categories.scss'])
@endpush

@extends('layouts.app')

@section('content')
    <div class="categories-list container">

        @if ($categories->isEmpty())
            <p>{{ __('Нэт категорий') }}</p>
        @else
            <div class="row">

                @foreach ($categories as $item)

                    <div class="col-sm-6 col-md-3 mb-3 mb-sm-0">
                        <div class="card">
                            <a href="{{ route('categories.detail', $item->code ) }}">
                                <img src="{{ $item->file ? Storage::url('categories/'.$item->file->path) : $SITE_NOPHOTO }}"
                                     alt="Картинка категории не найдена">
                                <div class="card-body">
                                    {{ $item->title }}
                                </div>
                            </a>
                        </div>
                    </div>

                @endforeach

            </div>            
        @endif

    </div>
@endsection