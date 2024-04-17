@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="{{ route('question.store') }}">

            <div class="mb-3">
                <label class="form-label">{{ __('crud.questions.fields.category') }}</label>
                <select name="category" class="form-select">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('crud.questions.fields.title') }}</label>
                <input type="text" name="title" class="form-control" placeholder="Почему цыгане моются, но все равно воняют?">
            </div>
            
            <button type="submit" class="btn btn-primary mb-3">{{ __('system.add') }}</button>
            
        
        </form>
    </div>
@endsection