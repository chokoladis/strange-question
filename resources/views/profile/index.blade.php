@extends('layouts.app')

@push('style')
    @vite(['resources/scss/profile.scss'])
@endpush

@push('script')
    @vite(['resources/js/question.js'])
@endpush

@php
    $user = auth()->user();
    $avatar = $user->avatar;
@endphp
@section('content')
    <div class="profile-page container">
        <div class="main">
            <div class="card avatar">
                <img src="{{ $avatar ? Storage::url('users/'.$avatar->path) : $SITE_NOPHOTO }}" class="card-img-top">
                <div class="card-body">
                    <a class="btn btn-primary">{{ __('Изменить фото') }}</a>
                </div>
            </div>
            <form class="info"  action="{{ route('questions.store') }}" method="POST" enctype="multipart/form-data">

                @csrf

                <div class="mb-3">
                    <label class="form-label">{{ __('crud.users.fields.name') }}</label>
                    <input type="text" name="name" class="form-control" value="{{$user->name}}">
                    @if ($errors->has('name'))
                        @foreach ($errors->get('name') as $item)
                            <p class="error">{{ $item  }}</p>
                        @endforeach
                    @endif
                </div>

                <button type="submit" class="btn btn-primary mb-3">{{ __('system.change') }}</button>
            </form>
        </div>
    </div>
@endsection