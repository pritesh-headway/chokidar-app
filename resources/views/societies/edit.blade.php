{{-- @extends('layouts.app') --}}
@extends('layouts.page', ['data' => 2])

@section('content')
    <div class="container">
        <h1>Edit Society</h1>
        <form action="{{ route('societies.update', $society->id) }}" method="POST">
            @csrf
            @method('POST')

            <div class="form-group">
                <label for="name">Society Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $society->society_name }}"
                    required>
            </div>

            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" class="form-control" id="address" name="address" value="{{ $society->address }}"
                    required>
            </div>

            <div class="form-group">
                <label for="city">City</label>
                <input type="text" class="form-control" id="city" name="city" value="{{ $society->city }}"
                    required>
            </div>

            <div class="form-group">
                <label for="state">State</label>
                <input type="text" class="form-control" id="state" name="state" value="{{ $society->state }}"
                    required>
            </div>

            <div class="form-group">
                <label for="postal_code">Postal Code</label>
                <input type="text" class="form-control" id="postal_code" name="postal_code"
                    value="{{ $society->postal_code }}" required>
            </div>

            <div class="form-group">
                <label for="contact">Contact</label>
                <input type="text" class="form-control" id="contact" name="contact"
                    value="{{ $society->contact_number }}" required>
            </div>

            <div class="form-group">
                <label for="type">Type</label>
                <select class="form-control" id="type" name="type" required>
                    <option value="residential" {{ $society->type == 'residential' ? 'selected' : '' }}>Residential</option>
                    <option value="commercial" {{ $society->type == 'commercial' ? 'selected' : '' }}>Commercial</option>
                    <option value="mixed" {{ $society->type == 'mixed' ? 'selected' : '' }}>Mixed</option>
                </select>
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="active" {{ $society->status == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ $society->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update Society</button>
        </form>
    </div>
@endsection
