@extends('layouts.website')

@section('title', 'Library')

@section('content')
    <div class="row">
        @foreach ($data['categories']['data'] as $key => $category)
            <a href="{{route('category', $category['slug'])}}" class="col-md-6 col-12">
                <div class="card mb-4">
                    <img class="card-img-top" src="{{$category['image']}}" alt="{$category['name']}}">
                    <div class="card-body">
                        <p class="card-text">{{$category['name']}}</p>
                    </div>
                </div>
            </a>
        @endforeach
    </div>

    @if($data['categories']['meta']['lastPage'] > 1)
        <div class="row">
            <div class="col-12">
                @include('partials.pagination', ['pagination' => $data['categories']['meta']])
            </div>
        </div>
    @endif

@endsection
