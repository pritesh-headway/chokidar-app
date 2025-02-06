@extends('layouts.page', ['data' => 2])

@section('content')
    <div class="container">
        <h1>Create Contact</h1>
        <form action="{{ route('contactus.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="society_name">Society Name</label>
                <input type="text" id="society_name" name="society_name" class="form-control">
            </div>
            <div class="form-group">
                <label for="country">Country</label>
                <input type="text" id="country" name="country" class="form-control">
            </div>
            <div class="form-group">
                <label for="city">City</label>
                <input type="text" id="city" name="city" class="form-control">
            </div>
            <div class="form-group">
                <label for="full_name">Full Name</label>
                <input type="text" id="full_name" name="full_name" class="form-control">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control">
            </div>
            <div class="form-group">
                <label for="phone_number">Phone Number</label>
                <input type="text" id="phone_number" name="phone_number" class="form-control">
            </div>
            <div class="form-group">
                <label for="comments">Comments</label>
                <textarea id="comments" name="comments" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label for="created_at">Created At</label>
                <input type="text" id="created_at" name="created_at" class="form-control"
                    value="{{ now()->format('Y-m-d') }}" readonly>
            </div>
            <button type="submit" class="btn btn-primary">Create Contact</button>
        </form>
    </div>
@endsection
