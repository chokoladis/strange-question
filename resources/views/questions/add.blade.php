@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="{{ route('question.store') }}" method="POST" enctype="multipart/form-data">

            @csrf

            <div class="mb-3">
                <label class="form-label">{{ __('crud.questions.fields.category') }}</label>
                <select name="category" class="form-select">
                    @foreach ($categories as $category)
                        <option value="{{ $category->code }}">{{ $category->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('crud.questions.fields.title') }}</label>
                <input type="text" name="title" class="form-control" placeholder="Почему цыгане моются, но все равно воняют?">
                @if ($errors->has('title'))
                    @foreach ($errors->get('title') as $item)
                        <p class="error">{{ $item  }}</p>
                    @endforeach
                @endif
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('crud.questions.fields.img') }}</label>
                <input type="file" name="img" class="form-control">
                @if ($errors->has('img'))
                    @foreach ($errors->get('img') as $item)
                        <p class="error">{{ $item  }}</p>
                    @endforeach
                @endif
            </div>
            
            <button type="submit" class="btn btn-primary mb-3">{{ __('system.add') }}</button>
            
        
        </form>
    </div>
@endsection