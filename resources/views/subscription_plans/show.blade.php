{{-- filepath: /c:/xampp/htdocs/chokidar-app/resources/views/subscription_plans/show.blade.php --}}
@extends('layouts.page', ['data' => 2])

@section('content')
    <div class="container">
        <h1>Subscription Plan Details</h1>
        <p><strong>Name:</strong> {{ $plan->name }}</p>
        <p><strong>Price:</strong> {{ $plan->price }}</p>
        <p><strong>Duration:</strong> {{ $plan->duration }} months</p>
        <p><strong>Status:</strong> {{ $plan->status }}</p>
        <a href="{{ route('subscription_plans.index') }}" class="btn btn-secondary">Back to List</a>
    </div>
@endsection
