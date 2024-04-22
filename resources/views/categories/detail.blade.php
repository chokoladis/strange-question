@extends('layouts.app')

@section('content')
    <div class="container">
        detail
        @php
            dump($category);
            dump($category->categorytable);
        @endphp
    </div>
@endsection