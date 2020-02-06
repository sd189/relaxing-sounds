@extends('layouts.website')

@section('title', $data['category']['name'])

@section('content')
    <div class="row">
        @foreach ($data['songs']['data'] as $key => $song)
            <div class="col-md-6 col-12">
                <div class="card mb-4">
                    <div class="card-header">
                        {{$song['name']}}
                    </div>
                    <div class="card-body">
                        <audio controls>
                            <source src="{{$song['link']}}" type="audio/mpeg">
                            Your browser does not support the audio element.
                        </audio>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if($data['songs']['meta']['total'] == 0)
        <h2 class="mt-5">Thier is no sounds in this category</h2>
    @endif

    @if($data['songs']['meta']['lastPage'] > 1)
        <div class="row">
            <div class="col-12">
                @include('partials.pagination', ['pagination' => $data['categories']['meta']])
            </div>
        </div>
    @endif

@endsection
