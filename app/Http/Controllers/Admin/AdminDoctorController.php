<?php
// File: app/Http/Controllers/Admin/AdminDoctorController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;

class AdminDoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::with(['user', 'department'])
            ->paginate(10);
        
        return view('admin.doctors.index', compact('doctors'));
    }

    public function create()
    {
        $users = User::where('role', 'doctor')
            ->whereDoesntHave('doctor')
            ->get();
        $departments = Department::where('is_active', true)->get();
        
        return view('admin.doctors.create', compact('users', 'departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id|unique:doctors,user_id',
            'department_id' => 'required|exists:departments,id',
            'license_number' => 'required|string|unique:doctors,license_number',
            'specialization' => 'required|string|max:255',
            'qualifications' => 'nullable|string',
            'experience_years' => 'required|integer|min:0',
            'consultation_fee' => 'required|numeric|min:0',
            'bio' => 'nullable|string',
            'available_days' => 'required|array|min:1',
            'available_days.*' => 'in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'slot_duration_minutes' => 'required|integer|min:15|max:120',
        ]);

        Doctor::create($validated);

        return redirect()->route('admin.doctors.index')
            ->with('success', 'Doctor profile created successfully!');
    }

    public function show(Doctor $doctor)
    {
        $doctor->load(['user', 'department', 'appointments.patient']);
        return view('admin.doctors.show', compact('doctor'));
    }

    public function edit(Doctor $doctor)
    {
        $departments = Department::where('is_active', true)->get();
        return view('admin.doctors.edit', compact('doctor', 'departments'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $validated = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'license_number' => 'required|string|unique:doctors,license_number,' . $doctor->id,
            'specialization' => 'required|string|max:255',
            'qualifications' => 'nullable|string',
            'experience_years' => 'required|integer|min:0',
            'consultation_fee' => 'required|numeric|min:0',
            'bio' => 'nullable|string',
            'available_days' => 'required|array|min:1',
            'available_days.*' => 'in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'slot_duration_minutes' => 'required|integer|min:15|max:120',
            'is_available' => 'boolean',
        ]);

        $doctor->update($validated);

        return redirect()->route('admin.doctors.index')
            ->with('success', 'Doctor profile updated successfully!');
    }
}