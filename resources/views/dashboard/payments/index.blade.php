{{-- filepath: /c:/xampp/htdocs/chokidar-app/resources/views/dashboard/payments/index.blade.php --}}
@extends('layouts.page', ['data' => 2])

@section('content')
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-4">Payments</h1>
        <a href="{{ route('payments.create') }}" class="btn btn-primary mb-4">Add New Payment</a>
        <table class="table w-full">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Society ID</th>
                    <th>Amount</th>
                    <th>Transaction ID</th>
                    <th>Status</th>
                    <th>Payment Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($payments as $payment)
                    <tr>
                        <td>{{ $payment->id }}</td>
                        <td>{{ $payment->society_id }}</td>
                        <td>{{ $payment->amount }}</td>
                        <td>{{ $payment->transaction_id }}</td>
                        <td>{{ $payment->status }}</td>
                        <td>{{ $payment->payment_date }}</td>
                        <td>
                            <a href="{{ route('payments.show', $payment->id) }}" class="btn btn-info">View</a>
                            <a href="{{ route('payments.edit', $payment->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('payments.destroy', $payment->id) }}" method="POST" class="inline">
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
