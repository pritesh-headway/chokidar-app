@extends('layouts.page', ['data' => 2])

@section('content')
    <div class="container mt-5 small-text">
        <h2>House Listings</h2>
        <a href="{{ url()->previous() }}" class="btn btn-secondary mb-3">Back</a>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-sm">
                <thead class="thead-dark">
                    <tr>
                        <th>House No</th>
                        <th>Block</th>
                        <th>Floor</th>
                        <th>Society ID</th>
                        <th>User ID</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($houses as $house)
                        <tr>
                            <td>{{ $house->house_no }}</td>
                            <td>{{ $house->block }}</td>
                            <td>{{ $house->floor }}</td>
                            <td>{{ $house->society_id }}</td>
                            <td>{{ $house->user_id }}</td>
                            <td>{{ $house->status }}</td>
                            <td>{{ $house->created_at->format('Y-m-d') }}</td>
                            <td>{{ $house->updated_at->format('Y-m-d') }}</td>
                            <td>
                                <a href="{{ route('houses.show', $house->id) }}" class="btn btn-info btn-sm">View</a>
                                <a href="{{ route('houses.edit', $house->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('houses.destroy', $house->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

<style>
    .small-text {
        font-size: 0.875rem;
    }
</style>
