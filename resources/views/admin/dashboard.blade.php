{{-- File: resources/views/admin/dashboard.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-2">Admin Dashboard</h1>
    <p class="text-gray-600">Hospital Management System Overview</p>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="flex items-center">
            <div class="p-3 bg-blue-100 rounded-full">
                <i class="fas fa-users text-blue-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-500">Total Patients</h3>
                <p class="text-2xl font-bold text-blue-600">{{ $stats['total_patients'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="flex items-center">
            <div class="p-3 bg-green-100 rounded-full">
                <i class="fas fa-user-md text-green-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-500">Total Doctors</h3>
                <p class="text-2xl font-bold text-green-600">{{ $stats['total_doctors'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="flex items-center">
            <div class="p-3 bg-purple-100 rounded-full">
                <i class="fas fa-calendar-check text-purple-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-500">Today's Appointments</h3>
                <p class="text-2xl font-bold text-purple-600">{{ $stats['today_appointments'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="flex items-center">
            <div class="p-3 bg-yellow-100 rounded-full">
                <i class="fas fa-dollar-sign text-yellow-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-500">Total Revenue</h3>
                <p class="text-2xl font-bold text-yellow-600">${{ number_format($stats['total_revenue'], 2) }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Additional Stats Row -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="flex items-center">
            <div class="p-3 bg-indigo-100 rounded-full">
                <i class="fas fa-clock text-indigo-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-500">Pending Appointments</h3>
                <p class="text-2xl font-bold text-indigo-600">{{ $stats['pending_appointments'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="flex items-center">
            <div class="p-3 bg-red-100 rounded-full">
                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-500">Pending Payments</h3>
                <p class="text-2xl font-bold text-red-600">${{ number_format($stats['pending_payments'], 2) }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="flex items-center">
            <div class="p-3 bg-teal-100 rounded-full">
                <i class="fas fa-building text-teal-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-500">Total Departments</h3>
                <p class="text-2xl font-bold text-teal-600">{{ $stats['total_departments'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="flex items-center">
            <div class="p-3 bg-orange-100 rounded-full">
                <i class="fas fa-calendar-alt text-orange-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-500">Total Appointments</h3>
                <p class="text-2xl font-bold text-orange-600">{{ $stats['total_appointments'] }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="bg-white rounded-lg shadow-md p-6 mb-8">
    <h2 class="text-xl font-bold text-gray-800 mb-4">Quick Actions</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4">
        <a href="{{ route('admin.users.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white p-4 rounded-lg text-center transition">
            <i class="fas fa-user-plus text-2xl mb-2 block"></i>
            <span class="text-sm">Add User</span>
        </a>
        <a href="{{ route('admin.doctors.create') }}" class="bg-green-500 hover:bg-green-600 text-white p-4 rounded-lg text-center transition">
            <i class="fas fa-user-md text-2xl mb-2 block"></i>
            <span class="text-sm">Add Doctor</span>
        </a>
        <a href="{{ route('admin.departments.create') }}" class="bg-purple-500 hover:bg-purple-600 text-white p-4 rounded-lg text-center transition">
            <i class="fas fa-building text-2xl mb-2 block"></i>
            <span class="text-sm">Add Department</span>
        </a>
        <a href="{{ route('admin.users.index') }}" class="bg-indigo-500 hover:bg-indigo-600 text-white p-4 rounded-lg text-center transition">
            <i class="fas fa-users text-2xl mb-2 block"></i>
            <span class="text-sm">Manage Users</span>
        </a>
        <a href="{{ route('admin.doctors.index') }}" class="bg-teal-500 hover:bg-teal-600 text-white p-4 rounded-lg text-center transition">
            <i class="fas fa-stethoscope text-2xl mb-2 block"></i>
            <span class="text-sm">Manage Doctors</span>
        </a>
        <a href="{{ route('admin.departments.index') }}" class="bg-orange-500 hover:bg-orange-600 text-white p-4 rounded-lg text-center transition">
            <i class="fas fa-hospital text-2xl mb-2 block"></i>
            <span class="text-sm">Manage Departments</span>
        </a>
    </div>
</div>

<!-- Recent Activity -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Recent Appointments -->
    <div class="bg-white rounded-lg shadow-md">
        <div class="p-6 border-b">
            <h3 class="text-lg font-semibold text-gray-800">Recent Appointments</h3>
        </div>
        <div class="p-6">
            @forelse($recentAppointments as $appointment)
                <div class="flex items-center justify-between py-3 border-b last:border-b-0">
                    <div>
                        <p class="font-semibold text-gray-800">{{ $appointment->patient->full_name }}</p>
                        <p class="text-sm text-gray-600">Dr. {{ $appointment->doctor->user->full_name }}</p>
                        <p class="text-xs text-gray-500">{{ $appointment->appointment_date->format('M d, Y') }} at {{ $appointment->appointment_time->format('h:i A') }}</p>
                    </div>
                    <span class="px-2 py-1 text-xs rounded-full 
                        @if($appointment->status === 'completed') bg-green-100 text-green-800
                        @elseif($appointment->status === 'scheduled') bg-blue-100 text-blue-800
                        @elseif($appointment->status === 'cancelled') bg-red-100 text-red-800
                        @else bg-yellow-100 text-yellow-800 @endif">
                        {{ ucfirst($appointment->status) }}
                    </span>
                </div>
            @empty
                <p class="text-gray-500 text-center py-8">No recent appointments</p>
            @endforelse
        </div>
    </div>

    <!-- System Statistics -->
    <div class="bg-white rounded-lg shadow-md">
        <div class="p-6 border-b">
            <h3 class="text-lg font-semibold text-gray-800">System Overview</h3>
        </div>
        <div class="p-6 space-y-4">
            <div class="flex justify-between items-center">
                <span class="text-gray-600">Active Patients</span>
                <span class="font-semibold text-blue-600">{{ $stats['total_patients'] }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-600">Available Doctors</span>
                <span class="font-semibold text-green-600">{{ $stats['total_doctors'] }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-600">This Month Revenue</span>
                <span class="font-semibold text-yellow-600">${{ number_format($stats['total_revenue'], 2) }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-600">Pending Bills</span>
                <span class="font-semibold text-red-600">${{ number_format($stats['pending_payments'], 2) }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-600">Today's Schedule</span>
                <span class="font-semibold text-purple-600">{{ $stats['today_appointments'] }} appointments</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-600">Active Departments</span>
                <span class="font-semibold text-teal-600">{{ $stats['total_departments'] }}</span>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity Timeline -->
<div class="mt-8 bg-white rounded-lg shadow-md">
    <div class="p-6 border-b">
        <h3 class="text-lg font-semibold text-gray-800">System Activity</h3>
    </div>
    <div class="p-6">
        <div class="space-y-4">
            <div class="flex items-center space-x-4">
                <div class="p-2 bg-green-100 rounded-full">
                    <i class="fas fa-user-plus text-green-600"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-800">New patient registered</p>
                    <p class="text-xs text-gray-500">2 minutes ago</p>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <div class="p-2 bg-blue-100 rounded-full">
                    <i class="fas fa-calendar-plus text-blue-600"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-800">New appointment scheduled</p>
                    <p class="text-xs text-gray-500">5 minutes ago</p>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <div class="p-2 bg-yellow-100 rounded-full">
                    <i class="fas fa-dollar-sign text-yellow-600"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-800">Payment received</p>
                    <p class="text-xs text-gray-500">12 minutes ago</p>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <div class="p-2 bg-purple-100 rounded-full">
                    <i class="fas fa-user-md text-purple-600"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-800">Doctor schedule updated</p>
                    <p class="text-xs text-gray-500">1 hour ago</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection