@extends('layouts.page', ['data' => 2])

@section('content')
    <div class="container mx-auto">
        <div class="flex flex-wrap">
            <!-- Main content -->
            <main class="w-full px-4">
                <div class="flex justify-between items-center py-3 border-b">
                    <h1 class="text-2xl font-semibold">All Societies</h1>

                    <a href="{{ route('societyregister') }}" class="btn btn-primary">Register Society</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="border px-4 py-2">ID</th>
                                <th class="border px-4 py-2">Name</th>
                                <th class="border px-4 py-2">Address</th>
                                <th class="border px-4 py-2">City</th>
                                <th class="border px-4 py-2">State</th>
                                <th class="border px-4 py-2">Postal Code</th>
                                <th class="border px-4 py-2">Contact Number</th>
                                <th class="border px-4 py-2">Type</th>
                                <th class="border px-4 py-2">Plan</th>
                                <th class="border px-4 py-2">Status</th>
                                <th class="border px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($societies as $society)
                                <tr class="hover:bg-gray-100">
                                    <td class="border px-4 py-2">{{ $society->id }}</td>
                                    <td class="border px-4 py-2">{{ $society->society_name }}</td>
                                    <td class="border px-4 py-2">{{ $society->address }}</td>
                                    <td class="border px-4 py-2">{{ $society->city }}</td>
                                    <td class="border px-4 py-2">{{ $society->state }}</td>
                                    <td class="border px-4 py-2">{{ $society->postal_code }}</td>
                                    <td class="border px-4 py-2">{{ $society->contact_number }}</td>
                                    <td class="border px-4 py-2">{{ $society->type }}</td>
                                    <td class="border px-4 py-2">{{ $society->plan }}</td>
                                    <td class="border px-4 py-2">{{ $society->status }}</td>
                                    <td class="border px-4 py-2 flex space-x-2">
                                        <a href="{{ route('societies.show', $society->id) }}"
                                            class="btn btn-info btn-sm">View</a>
                                        <a href="{{ route('societies.edit', $society->id) }}"
                                            class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('societies.destroy', $society->id) }}" method="POST"
                                            class="inline">
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
