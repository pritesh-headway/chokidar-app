@extends('layouts.page', ['data' => 2])

@section('content')
    <div class="container">
        <h1 class="small-text">Contact Us</h1>
        <div class="card">
            <div class="card-header small-text">
                Contact Details
            </div>
            <div class="card-body small-text">
                <p><strong>Society Name:</strong> {{ $contact->society_name }}</p>
                <p><strong>Country:</strong> {{ $contact->country }}</p>
                <p><strong>City:</strong> {{ $contact->city }}</p>
                <p><strong>Full Name:</strong> {{ $contact->full_name }}</p>
                <p><strong>Email:</strong> {{ $contact->email }}</p>
                <p><strong>Phone Number:</strong> {{ $contact->phone_number }}</p>
                <p><strong>Comments:</strong> {{ $contact->comments }}</p>
                <p><strong>Created At:</strong> {{ $contact->created_at->format('Y-m-d') }}</p>
            </div>
        </div>
        <a href="{{ route('contactus.index') }}" class="btn btn-primary mt-3 small-text">Back to Contact List</a>
    </div>
@endsection

<style>
    .small-text {
        font-size: 0.875rem;
    }
</style>
