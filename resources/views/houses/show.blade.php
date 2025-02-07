@extends('layouts.page', ['data' => 2])

@section('content')
    <div class="container">
        <h1 class="small-text">House Details</h1>
        <div class="card">
            <div class="card-header small-text">
                House No: {{ $house->house_no }}
            </div>
            <div class="card-body small-text">
                <p><strong>Block:</strong> {{ $house->block }}</p>
                <p><strong>Floor:</strong> {{ $house->floor }}</p>
                <p><strong>Society ID:</strong> {{ $house->society_id }}</p>
                {{-- <p><strong>User ID:</strong> {{ $house->user_id }}</p> --}}
                <p><strong>Status:</strong> {{ $house->status }}</p>
                <p><strong>Created At:</strong> {{ $house->created_at->format('Y-m-d') }}</p>
                <p><strong>Updated At:</strong> {{ $house->updated_at->format('Y-m-d') }}</p>
            </div>
        </div>
        <a href="{{ route('houses.index', [($society_id = session('society_id'))]) }}"
            class="btn btn-primary mt-3 small-text">Back to
            House List</a>
    </div>
@endsection

<style>
    .small-text {
        font-size: 0.875rem;
    }
</style>
