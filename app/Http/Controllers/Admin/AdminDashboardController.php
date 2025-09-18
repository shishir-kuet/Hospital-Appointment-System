<?php
// File: app/Http/Controllers/Admin/AdminDashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Department;
use App\Models\Appointment;
use App\Models\Bill;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_patients' => User::where('role', 'patient')->count(),
            'total_doctors' => Doctor::count(),
            'total_appointments' => Appointment::count(),
            'pending_appointments' => Appointment::where('status', 'scheduled')->count(),
            'today_appointments' => Appointment::whereDate('appointment_date', today())->count(),
            'total_revenue' => Bill::where('payment_status', 'paid')->sum('total_amount'),
            'pending_payments' => Bill::where('payment_status', 'pending')->sum('total_amount'),
            'total_departments' => Department::count(),
        ];

        $recentAppointments = Appointment::with(['patient', 'doctor.user'])
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentAppointments'));
    }
}