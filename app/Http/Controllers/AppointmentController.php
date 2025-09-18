<?php
// File: app/Http/Controllers/AppointmentController.php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Bill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with(['patient', 'doctor.user', 'doctor.department'])
            ->when(Auth::user()->role === 'patient', function ($query) {
                $query->where('patient_id', Auth::id());
            })
            ->when(Auth::user()->role === 'doctor', function ($query) {
                $query->whereHas('doctor', function ($q) {
                    $q->where('user_id', Auth::id());
                });
            })
            ->orderBy('appointment_date', 'desc')
            ->paginate(10);

        return view('appointments.index', compact('appointments'));
    }

    public function create()
    {
        $doctors = Doctor::with(['user', 'department'])
            ->available()
            ->get();
        
        return view('appointments.create', compact('doctors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|after:today',
            'appointment_time' => 'required|date_format:H:i',
            'reason_for_visit' => 'required|string|max:500',
        ]);

        // Check for conflicts
        $conflict = Appointment::where('doctor_id', $validated['doctor_id'])
            ->where('appointment_date', $validated['appointment_date'])
            ->where('appointment_time', $validated['appointment_time'])
            ->whereIn('status', ['scheduled', 'confirmed'])
            ->exists();

        if ($conflict) {
            return back()->withErrors(['appointment_time' => 'This time slot is not available.']);
        }

        $appointment = Appointment::create([
            ...$validated,
            'patient_id' => Auth::id(),
            'status' => 'scheduled',
        ]);

        // Auto-generate bill
        $doctor = Doctor::find($validated['doctor_id']);
        Bill::create([
            'appointment_id' => $appointment->id,
            'patient_id' => Auth::id(),
            'consultation_fee' => $doctor->consultation_fee,
            'tax_amount' => $doctor->consultation_fee * 0.1, // 10% tax
            'total_amount' => $doctor->consultation_fee * 1.1,
            'payment_status' => 'pending',
        ]);

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment booked successfully!');
    }

    public function show(Appointment $appointment)
    {
        $appointment->load(['patient', 'doctor.user', 'doctor.department', 'bill']);
        
        return view('appointments.show', compact('appointment'));
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'status' => 'required|in:confirmed,in_progress,completed,cancelled,no_show',
            'notes' => 'nullable|string|max:1000',
            'diagnosis' => 'nullable|string|max:1000',
            'prescription' => 'nullable|string|max:1000',
            'cancellation_reason' => 'nullable|string|max:500',
        ]);

        $appointment->update([
            ...$validated,
            'cancelled_at' => $validated['status'] === 'cancelled' ? now() : null,
        ]);

        return back()->with('success', 'Appointment status updated successfully!');
    }
}