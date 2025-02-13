{{-- filepath: /c:/xampp/htdocs/chokidar-app/resources/views/dashboard/payments/show.blade.php --}}
@extends('layouts.page', ['data' => 2])

@section('content')
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-4">Payment Details</h1>
        <p><strong>ID:</strong> {{ $payment->id }}</p>
        <p><strong>Society ID:</strong> {{ $payment->society_id }}</p>
        <p><strong>Amount:</strong> {{ $payment->amount }}</p>
        <p><strong>Transaction ID:</strong> {{ $payment->transaction_id }}</p>
        <p><strong>Status:</strong> {{ $payment->status }}</p>
        <p><strong>Payment Date:</strong> {{ $payment->payment_date }}</p>
        <a href="{{ route('payments.index') }}" class="btn btn-secondary">Back to List</a>
    </div>
@endsection
