<?php
// File: app/Http/Controllers/BillController.php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BillController extends Controller
{
    public function index()
    {
        $bills = Bill::with(['appointment.doctor.user', 'patient'])
            ->when(Auth::user()->role === 'patient', function ($query) {
                $query->where('patient_id', Auth::id());
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('bills.index', compact('bills'));
    }

    public function show(Bill $bill)
    {
        $bill->load(['appointment.doctor.user', 'patient', 'billItems']);
        
        return view('bills.show', compact('bill'));
    }

    public function updatePayment(Request $request, Bill $bill)
    {
        $validated = $request->validate([
            'payment_status' => 'required|in:paid,partially_paid,cancelled',
            'payment_method' => 'required|in:cash,card,bank_transfer,insurance,online',
            'notes' => 'nullable|string|max:500',
        ]);

        $bill->update([
            ...$validated,
            'payment_date' => now(),
        ]);

        return back()->with('success', 'Payment status updated successfully!');
    }
}