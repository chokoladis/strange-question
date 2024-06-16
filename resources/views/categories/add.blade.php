@extends('layouts.app')

@foreach ($categories as $category)
    @php
        $daughters = $category->getDaughtersCategories();
        foreach ($daughters as $items) {
            if (!empty($items)){
                if ($items->first()){
                    foreach ($items as $key => $value) {
                        # code...
                    }
                } else {
                    // echo $items->title;
                }
            }
        }
        $selected = old('category_parent_id') == $category->id ? 'selected' : '';
    @endphp
    
@endforeach

@section('content')
    <div class="container">
        <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">

            @csrf

            <div class="mb-3">
                <label class="form-label">{{ __('crud.categories.fields.category_parent_id') }}</label>
                <select name="category_parent_id" class="form-select">
                    <option value="0" selected>{{ __('Без категории') }}</option>
                    @foreach ($categories as $category)
                        @php
                            $daughters = $category->getDaughtersCategories();
                            foreach ($daughters as $items) {
                                dump($items);    
                            }
                            $selected = old('category_parent_id') == $category->id ? 'selected' : '';
                        @endphp
                        <option value="{{ $category->id }}" {{ $selected }}>{{ $category->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('crud.categories.fields.title') }}</label>
                <input type="text" name="title" class="form-control" 
                    placeholder="Название, например: Аниме" value="{{ old('title') }}">
                @if ($errors->has('title'))
                    @foreach ($errors->get('title') as $item)
                        <p class="error">{{ $item  }}</p>
                    @endforeach
                @endif
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('crud.categories.fields.img') }}</label>
                <input type="file" name="img" class="form-control">
                @if ($errors->has('img'))
                    @foreach ($errors->get('img') as $item)
                        <p class="error">{{ $item  }}</p>
                    @endforeach
                @endif
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('crud.categories.fields.sort') }}</label>
                <input type="number" name="sort" class="form-control" 
                    placeholder="100" value="{{ old('sort') }}">
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