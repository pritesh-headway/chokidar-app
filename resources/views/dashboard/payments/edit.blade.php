{{-- filepath: /c:/xampp/htdocs/chokidar-app/resources/views/dashboard/payments/edit.blade.php --}}
@extends('layouts.page', ['data' => 2])

@section('content')
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-4">Edit Payment</h1>
        <form action="{{ route('payments.update', $payment->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group mb-4">
                <label for="society_id" class="block text-sm font-medium text-gray-700">Society ID</label>
                <input type="number" name="society_id" class="input input-bordered w-full" value="{{ $payment->society_id }}"
                    required>
            </div>
            <div class="form-group mb-4">
                <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                <input type="number" name="amount" class="input input-bordered w-full" value="{{ $payment->amount }}"
                    required>
            </div>
            <div class="form-group mb-4">
                <label for="transaction_id" class="block text-sm font-medium text-gray-700">Transaction ID</label>
                <input type="text" name="transaction_id" class="input input-bordered w-full"
                    value="{{ $payment->transaction_id }}" required>
            </div>
            <div class="form-group mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" class="select select-bordered w-full" required>
                    <option value="pending" {{ $payment->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="success" {{ $payment->status == 'success' ? 'selected' : '' }}>Success</option>
                    <option value="failed" {{ $payment->status == 'failed' ? 'selected' : '' }}>Failed</option>
                    <option value="refunded" {{ $payment->status == 'refunded' ? 'selected' : '' }}>Refunded</option>
                </select>
            </div>
            <div class="form-group mb-4">
                <label for="payment_date" class="block text-sm font-medium text-gray-700">Payment Date</label>
                <input type="datetime-local" name="payment_date" class="input input-bordered w-full"
                    value="{{ $payment->payment_date }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Payment</button>
        </form>
    </div>
@endsection
