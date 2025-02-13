{{-- filepath: /c:/xampp/htdocs/chokidar-app/resources/views/subscription_plans/index.blade.php --}}
@extends('layouts.page', ['data' => 2])

@section('content')
    <div class="container">
        <h1>Subscription Plans</h1>
        <a href="{{ route('subscription_plans.create') }}" class="btn btn-primary">Add New Plan</a>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Duration</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($plans as $plan)
                    <tr>
                        <td>{{ $plan->name }}</td>
                        <td>{{ $plan->price }}</td>
                        <td>{{ $plan->duration }} months</td>
                        <td>{{ $plan->status }}</td>
                        <td>
                            <a href="{{ route('subscription_plans.show', $plan->id) }}" class="btn btn-info">View</a>
                            <a href="{{ route('subscription_plans.edit', $plan->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('subscription_plans.destroy', $plan->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
