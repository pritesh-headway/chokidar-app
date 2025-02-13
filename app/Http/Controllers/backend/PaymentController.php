<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::all();
        return view('dashboard.payments.index', compact('payments'));
    }

    // public function create()
    // {
    //     return view('payments.create');
    // }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'society_id' => 'required|exists:societies,id',
            'amount' => 'required|numeric|min:0',
            'transaction_id' => 'required|string|unique:payments,transaction_id',
            'status' => 'required|in:pending,success,failed,refunded',
            'payment_date' => 'required|date_format:Y-m-d\TH:i',
        ]);

        Payment::create($validated);
        return redirect()->route('payments.index');
    }

    public function show($id)
    {
        $payment = Payment::findOrFail($id);
        return view('dashboard.payments.show', compact('payment'));
    }

    public function edit($id)
    {
        $payment = Payment::findOrFail($id);
        return view('dashboard.payments.edit', compact('payment'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'society_id' => 'sometimes|required|exists:societies,id',
            'amount' => 'sometimes|required|numeric|min:0',
            'transaction_id' => 'sometimes|required|string|unique:payments,transaction_id,' . $id,
            'status' => 'sometimes|required|in:pending,success,failed,refunded',
            'payment_date' => 'sometimes|required|date_format:Y-m-d\TH:i',
        ]);

        $payment = Payment::findOrFail($id);
        $payment->update($validated);
        return redirect()->route('payments.index');
    }

    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->delete();
        return redirect()->route('payments.index');
    }
}
