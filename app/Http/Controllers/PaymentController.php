<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'society_id' => 'required|exists:societies,id',
            'amount' => 'required|numeric|min:0',
            'transaction_id' => 'required|string|unique:payments,transaction_id',
            'status' => 'required|in:pending,success,failed,refunded',
            'payment_date' => 'required|date_format:Y-m-d H:i:s',
        ]);

        $payment = Payment::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Payment recorded successfully',
            'data' => $payment
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:payments,id',
            'status' => 'required|in:pending,success,failed,refunded',
        ]);

        $payment = Payment::find($request->id);
        $payment->update(['status' => $request->status]);

        return response()->json([
            'status' => true,
            'message' => 'Payment updated successfully',
            'data' => $payment
        ]);
    }

    public function show(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:payments,id',
        ]);

        $payment = Payment::find($request->id);

        return response()->json([
            'status' => true,
            'message' => 'Payment retrieved successfully',
            'data' => $payment
        ]);
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:payments,id',
        ]);

        $payment = Payment::find($request->id);
        $payment->delete();

        return response()->json([
            'status' => true,
            'message' => 'Payment deleted successfully'
        ]);
    }
}
