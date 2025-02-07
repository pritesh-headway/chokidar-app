@extends('layouts.page', ['data' => 2])

@section('content')
    <div class="container">
        <h1 class="small-text">Edit House</h1>
        <form action="{{ route('houses.update', $house->id) }}" method="POST" class="small-text">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="house_no">House No</label>
                <input type="text" id="house_no" name="house_no" class="form-control" value="{{ $house->house_no }}">
            </div>
            <div class="form-group">
                <label for="block">Block</label>
                <input type="text" id="block" name="block" class="form-control" value="{{ $house->block }}">
            </div>
            <div class="form-group">
                <label for="floor">Floor</label>
                <input type="text" id="floor" name="floor" class="form-control" value="{{ $house->floor }}">
            </div>
            <div class="form-group">
                <label for="society_id">Society ID</label>
                <input type="text" id="society_id" name="society_id" class="form-control"
                    value="{{ $house->society_id }}">
            </div>
            {{-- <div class="form-group">
                <label for="user_id">User ID</label>
                <input type="text" id="user_id" name="user_id" class="form-control" value="{{ $house->user_id }}">
            </div> --}}
            <div class="form-group">
                <label for="status">Status</label>
                <input type="text" id="status" name="status" class="form-control" value="{{ $house->status }}">
            </div>
            <button type="submit" class="btn btn-primary">Update House</button>
        </form>
    </div>
@endsection

<style>
    .small-text {
        font-size: 0.875rem;
    }
</style>
