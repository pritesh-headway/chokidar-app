{{-- filepath: /c:/xampp/htdocs/chokidar-app/resources/views/subscription_plans/edit.blade.php --}}
@extends('layouts.page', ['data' => 2])

@section('content')
    <div class="container">
        <h1>Edit Subscription Plan</h1>
        <form action="{{ route('subscription_plans.update', $plan->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" value="{{ $plan->name }}" required>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" name="price" class="form-control" value="{{ $plan->price }}" required>
            </div>
            <div class="form-group">
                <label for="duration">Duration (months)</label>
                <input type="number" name="duration" class="form-control" value="{{ $plan->duration }}" required>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" class="form-control" required>
                    <option value="active" {{ $plan->status == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ $plan->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Plan</button>
        </form>
    </div>
@endsection
