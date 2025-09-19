{{-- File: resources/views/doctors/show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Doctor Profile -->
    <div class="bg-white rounded-lg shadow-md p-8 mb-8">
        <div class="flex items-start space-x-6">
            <div class="w-32 h-32 bg-blue-100 rounded-full flex items-center justify-center">
                <i class="fas fa-user-md text-blue-600 text-4xl"></i>
            </div>
            
            <div class="flex-1">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Dr. {{ $doctor->user->full_name }}</h1>
                <p class="text-xl text-gray-600 mb-2">{{ $doctor->specialization }}</p>
                <p class="text-lg text-blue-600 mb-4">{{ $doctor->department->name }} Department</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div class="flex items-center text-gray-600">
                        <i class="fas fa-graduation-cap mr-2"></i>
                        <span>{{ $doctor->experience_years }} years experience</span>
                    </div>
                    <div class="flex items-center text-gray-600">
                        <i class="fas fa-dollar-sign mr-2"></i>
                        <span>{{ number_format($doctor->consultation_fee, 2) }} BDT consultation</span>
                    </div>
                    <div class="flex items-center text-gray-600">
                        <i class="fas fa-clock mr-2"></i>
                        <span>{{ $doctor->start_time->format('h:i A') }} - {{ $doctor->end_time->format('h:i A') }}</span>
                    </div>
                    <div class="flex items-center text-gray-600">
                        <i class="fas fa-id-card mr-2"></i>
                        <span>License: {{ $doctor->license_number }}</span>
                    </div>
                </div>

                @if($doctor->qualifications)
                    <div class="mb-4">
                        <h3 class="font-semibold text-gray-800 mb-2">Qualifications:</h3>
                        <p class="text-gray-600">{{ $doctor->qualifications }}</p>
                    </div>
                @endif

                @if($doctor->bio)
                    <div class="mb-6">
                        <h3 class="font-semibold text-gray-800 mb-2">About:</h3>
                        <p class="text-gray-600">{{ $doctor->bio }}</p>
                    </div>
                @endif

                <div class="mb-6">
                    <h3 class="font-semibold text-gray-800 mb-2">Available Days:</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($doctor->available_days as $day)
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                                {{ ucfirst($day) }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Available Time Slots -->
    <div class="bg-white rounded-lg shadow-md p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Available Time Slots</h2>
        
        @if($availableSlots)
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @foreach($availableSlots as $date => $dayInfo)
                    <div class="border rounded-lg p-4">
                        <h3 class="font-semibold text-gray-800 mb-3">{{ $dayInfo['date'] }}</h3>
                        <div class="grid grid-cols-3 gap-2">
                            @foreach($dayInfo['slots'] as $slot)
                                <a href="{{ route('appointments.create', ['doctor_id' => $doctor->id, 'date' => $date, 'time' => $slot]) }}" 
                                   class="bg-green-100 hover:bg-green-200 text-green-800 px-3 py-2 rounded text-sm text-center transition">
                                    {{ date('h:i A', strtotime($slot)) }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-6 text-center">
                <a href="{{ route('appointments.create', ['doctor_id' => $doctor->id]) }}" 
                   class="bg-blue-500 hover:bg-blue-600 text-white px-8 py-3 rounded-lg transition">
                    <i class="fas fa-calendar-plus mr-2"></i>
                    Book Appointment with Dr. {{ $doctor->user->full_name }}
                </a>
            </div>
        @else
            <div class="text-center py-8">
                <i class="fas fa-calendar-times text-gray-400 text-4xl mb-4"></i>
                <p class="text-gray-500 mb-4">No available time slots in the next 7 days.</p>
                <a href="{{ route('appointments.create', ['doctor_id' => $doctor->id]) }}" 
                   class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded transition">
                    Book for Later Date
                </a>
            </div>
        @endif
    </div>
</div>
@endsection