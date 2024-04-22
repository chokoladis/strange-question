@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="{{ route('category.store') }}" method="POST">

            @csrf

            <div class="mb-3">
                <label class="form-label">{{ __('crud.categories.fields.category_parent_id') }}</label>
                <select name="category_parent_id" class="form-select">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('crud.categories.fields.title') }}</label>
                <input type="text" name="title" class="form-control" placeholder="Название, например: Аниме">
                @if ($errors->has('title'))
                    @foreach ($errors->get('title') as $item)
                        <p class="error">{{ $item  }}</p>
                    @endforeach
                @endif
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('crud.categories.fields.sort') }}</label>
                <input type="number" name="sort" class="form-control" placeholder="100">
                @if ($errors->has('sort'))
                    @foreach ($errors->get('sort') as $item)
                        <p class="error">{{ $item  }}</p>                                
                    @endforeach
                @endif
            </div>
            
            <button type="submit" class="btn btn-primary mb-3">{{ __('system.add') }}</button>
            
        
        </form>
    </div>
@endsection