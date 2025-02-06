{{-- @extends('layouts.app') --}}
@extends('layouts.page', ['data' => 2])

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            {{-- <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ route('dashboard') }}">
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('societies.index') }}">
                                Societies
                            </a>
                        </li>
                        <!-- Add more sidebar links as needed -->
                    </ul>
                </div>
            </nav> --}}

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-12 px-md-4">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">All Societies</h1>
                    <a href="{{ route('societyregister') }}" class="btn btn-primary mb-3">Register
                        Society</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>City</th>
                                <th>State</th>
                                <th>Postal Code</th>
                                <th>Contact Number</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($societies as $society)
                                <tr>
                                    <td>{{ $society->id }}</td>
                                    <td>{{ $society->society_name }}</td>
                                    <td>{{ $society->address }}</td>
                                    <td>{{ $society->city }}</td>
                                    <td>{{ $society->state }}</td>
                                    <td>{{ $society->postal_code }}</td>
                                    <td>{{ $society->contact_number }}</td>
                                    <td>{{ $society->type }}</td>
                                    <td>{{ $society->status }}</td>
                                    <td>
                                        <a href="{{ route('societies.show', $society->id) }}"
                                            class="btn btn-info btn-sm">View</a>
                                        <a href="{{ route('societies.edit', $society->id) }}"
                                            class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('societies.destroy', $society->id) }}" method="POST"
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
            </main>
        </div>
    </div>
@endsection
