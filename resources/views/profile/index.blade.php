@extends('layouts.app')

@push('style')
    @vite(['resources/scss/profile.scss'])
@endpush

@push('script')
    @vite(['resources/js/profile.js'])
@endpush

@php
    $user = auth()->user();
    $photo = $user->photo;
@endphp
@section('content')
    <div class="profile-page container">
        <div class="main">
            <div class="card photo">
                <img src="{{ $photo ? Storage::url('users/'.$photo->path) : $SITE_NOPHOTO }}" class="card-img-top">
                <div class="card-body">
                    <form action="{{ route('profile.setPhoto') }}" class="update-photo" method="POST" enctype="multipart/form-data">

                        @csrf

                        <label class="form-label">{{ __('crud.users.fields.photo') }}</label>
                        <input type="file" name="photo" class="btn btn-primary" value="{{ __('Изменить фото') }}">
                        @if ($errors->has('photo'))
                            @foreach ($errors->get('photo') as $item)
                                <p class="error">{{ $item  }}</p>
                            @endforeach
                        @endif

                        <button type="submit" class="btn btn-success">{{ __('Изменить фото') }}</button>
                    </form>
                </div>
            </div>
            <form action="{{ route('profile.update') }}" class="info" method="POST" enctype="multipart/form-data">

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