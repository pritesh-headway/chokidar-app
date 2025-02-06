@extends('layouts.page', ['data' => 2])

@section('content')
    <div class="container mt-5 small-text">
        <h2>Contact Us Entries</h2>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-sm">
                <thead class="thead-dark">
                    <tr>
                        <th>Society Name</th>
                        <th>Country</th>
                        <th>City</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Comments</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($contacts as $contact)
                        <tr>
                            <td>{{ $contact->society_name }}</td>
                            <td>{{ $contact->country }}</td>
                            <td>{{ $contact->city }}</td>
                            <td>{{ $contact->full_name }}</td>
                            <td>{{ $contact->email }}</td>
                            <td>{{ $contact->phone_number }}</td>
                            <td>{{ $contact->comments }}</td>
                            <td>{{ $contact->created_at->format('Y-m-d') }}</td>
                            <td>
                                <a href="{{ route('contactus.show', $contact->id) }}" class="btn btn-info btn-sm">View</a>
                                <a href="{{ route('contactus.edit', $contact->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('contactus.destroy', $contact->id) }}" method="POST"
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
    .table-responsive {
        /* max-height: 400px; */
        overflow-y: auto;
    }

    .table-sm th,
    .table-sm td {
        padding: 0.3rem;
    }

    .small-text {
        font-size: 0.75rem !important;
        /* Adjusted font size */
    }
</style>
