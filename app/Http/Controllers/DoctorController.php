<?php
// File: app/Http/Controllers/DoctorController.php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Department;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index(Request $request)
    {
        $doctors = Doctor::with(['user', 'department'])
            ->available()
            ->when($request->department_id, function ($query, $departmentId) {
                $query->where('department_id', $departmentId);
            })
            ->when($request->search, function ($query, $search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%");
                })->orWhere('specialization', 'like', "%{$search}%");
            })
            ->paginate(12);

        $departments = Department::where('is_active', true)->get();

        return view('doctors.index', compact('doctors', 'departments'));
    }

    public function show(Doctor $doctor)
    {
        $doctor->load(['user', 'department']);
        
        // Get available time slots for next 7 days
        $availableSlots = $this->getAvailableSlots($doctor, 7);

        return view('doctors.show', compact('doctor', 'availableSlots'));
    }

    private function getAvailableSlots(Doctor $doctor, int $days)
    {
        $slots = [];
        $startDate = now()->addDay();

        for ($i = 0; $i < $days; $i++) {
            $date = $startDate->copy()->addDays($i);
            $dayName = strtolower($date->format('l'));

            if (in_array($dayName, $doctor->available_days)) {
                $daySlots = [];
                $startTime = $date->copy()->setTimeFromTimeString($doctor->start_time);
                $endTime = $date->copy()->setTimeFromTimeString($doctor->end_time);

                while ($startTime < $endTime) {
                    $timeSlot = $startTime->format('H:i');
                    
                    // Check if slot is booked
                    $isBooked = $doctor->appointments()
                        ->where('appointment_date', $date->toDateString())
                        ->where('appointment_time', $timeSlot)
                        ->whereIn('status', ['scheduled', 'confirmed'])
                        ->exists();

                    if (!$isBooked) {
                        $daySlots[] = $timeSlot;
                    }

                    $startTime->addMinutes($doctor->slot_duration_minutes);
                }

                if (!empty($daySlots)) {
                    $slots[$date->format('Y-m-d')] = [
                        'date' => $date->format('M d, Y'),
                        'slots' => $daySlots
                    ];
                }
            }
        }

        return $slots;
    }
}