    @extends('layouts.page', ['data' => 2])

    @section('content')
        <div class="container mt-5">
            <div class="card">
                <div class="card-header">
                    <h1>{{ $society->society_name }}</h1>
                </div>
                <div class="card-body">
                    <p><strong>Address:</strong> {{ $society->address }}</p>
                    <p><strong>City:</strong> {{ $society->city }}</p>
                    <p><strong>State:</strong> {{ $society->state }}</p>
                    <p><strong>Postal Code:</strong> {{ $society->postal_code }}</p>
                    <p><strong>Contact Number:</strong> {{ $society->contact_number }}</p>
                    <p><strong>Type:</strong> {{ $society->type }}</p>
                    <p><strong>Status:</strong> {{ $society->status }}</p>
                </div>
                <div class="card-footer">
                    <a href="{{ route('societies.index') }}" class="btn btn-primary">Back to All Societies</a>
                    <a href="{{ route('houses.index') }}" class="btn btn-secondary">View Houses</a>
                </div>
            </div>
        </div>
    @endsection
