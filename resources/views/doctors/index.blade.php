{{-- File: resources/views/doctors/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-4">Find Doctors</h1>
    
    <!-- Search and Filter -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <form method="GET" action="{{ route('doctors.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Search Doctors</label>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Search by name or specialization"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Department</label>
                <select name="department_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">All Departments</option>
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}" {{ request('department_id') == $department->id ? 'selected' : '' }}>
                            {{ $department->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="flex items-end">
                <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition">
                    <i class="fas fa-search mr-2"></i>Search
                </button>
            </div>
        </form>
    </div>

    <!-- Doctors Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($doctors as $doctor)
            <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition">
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-user-md text-blue-600 text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-800">Dr. {{ $doctor->user->full_name }}</h3>
                            <p class="text-sm text-gray-600">{{ $doctor->specialization }}</p>
                            <p class="text-sm text-blue-600">{{ $doctor->department->name }}</p>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <div class="flex items-center text-sm text-gray-600 mb-1">
                            <i class="fas fa-graduation-cap mr-2"></i>
                            {{ $doctor->experience_years }} years experience
                        </div>
                        <div class="flex items-center text-sm text-gray-600 mb-1">
                            <i class="fas fa-dollar-sign mr-2"></i>
                            ${{ number_format($doctor->consultation_fee, 2) }} consultation fee
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-clock mr-2"></i>
                            {{ $doctor->start_time->format('h:i A') }} - {{ $doctor->end_time->format('h:i A') }}
                        </div>
                    </div>
                    
                    @if($doctor->bio)
                        <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ $doctor->bio }}</p>
                    @endif
                    
                    <div class="flex space-x-2">
                        <a href="{{ route('doctors.show', $doctor) }}" 
                           class="flex-1 bg-blue-500 text-white text-center py-2 px-4 rounded hover:bg-blue-600 transition">
                            View Profile
                        </a>
                        <a href="{{ route('appointments.create', ['doctor_id' => $doctor->id]) }}" 
                           class="flex-1 bg-green-500 text-white text-center py-2 px-4 rounded hover:bg-green-600 transition">
                            Book Appointment
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-lg shadow-md p-12 text-center">
                <i class="fas fa-user-md text-gray-400 text-6xl mb-4"></i>
                <p class="text-gray-500 text-lg">No doctors found matching your criteria.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $doctors->links() }}
    </div>
</div>
@endsection