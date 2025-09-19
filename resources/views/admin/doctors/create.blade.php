{{-- File: resources/views/admin/doctors/create.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Create Doctor Profile</h1>
        <p class="text-gray-600">Add a new doctor to the hospital system</p>
    </div>

    <div class="bg-white rounded-lg shadow-md p-8">
        <form method="POST" action="{{ route('admin.doctors.store') }}">
            @csrf
            


            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror"
                           placeholder="doctor@email.com">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Password -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <input type="password" name="password" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror"
                           placeholder="Enter password">
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Doctor Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Doctor Name</label>
                    <input type="text" name="full_name" value="{{ old('full_name') }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('full_name') border-red-500 @enderror"
                           placeholder="Dr. John Doe">
                    @error('full_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Department -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Department</label>
                    <select name="department_id" required 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('department_id') border-red-500 @enderror">
                        <option value="">Choose department...</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('department_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- License Number -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Medical License Number</label>
                    <input type="text" name="license_number" value="{{ old('license_number') }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('license_number') border-red-500 @enderror"
                           placeholder="LIC123456">
                    @error('license_number')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Specialization -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Specialization</label>
                    <input type="text" name="specialization" value="{{ old('specialization') }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('specialization') border-red-500 @enderror"
                           placeholder="Cardiologist">
                    @error('specialization')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Experience Years -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Years of Experience</label>
                    <input type="number" name="experience_years" value="{{ old('experience_years') }}" required min="0"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('experience_years') border-red-500 @enderror">
                    @error('experience_years')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Qualifications -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Qualifications</label>
                <textarea name="qualifications" rows="3" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('qualifications') border-red-500 @enderror"
                          placeholder="MBBS, MD Cardiology, Fellowship in Interventional Cardiology">{{ old('qualifications') }}</textarea>
                @error('qualifications')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Bio -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Bio</label>
                <textarea name="bio" rows="4" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('bio') border-red-500 @enderror"
                          placeholder="Brief biography and areas of expertise">{{ old('bio') }}</textarea>
                @error('bio')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Consultation Fee -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Consultation Fee ($)</label>
                <input type="number" name="consultation_fee" value="{{ old('consultation_fee') }}" required min="0" step="0.01"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('consultation_fee') border-red-500 @enderror"
                       placeholder="100.00">
                @error('consultation_fee')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Available Days -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Available Days</label>
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-3">
                    @foreach(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day)
                        <div class="flex items-center">
                            <input type="checkbox" name="available_days[]" id="{{ $day }}" value="{{ $day }}"
                                   {{ in_array($day, old('available_days', [])) ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="{{ $day }}" class="ml-2 block text-sm text-gray-900">
                                {{ ucfirst($day) }}
                            </label>
                        </div>
                    @endforeach
                </div>
                @error('available_days')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-sm text-gray-500 mt-1">Select at least one available day</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Start Time -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Start Time</label>
                    <input type="time" name="start_time" value="{{ old('start_time', '09:00') }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('start_time') border-red-500 @enderror">
                    @error('start_time')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- End Time -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">End Time</label>
                    <input type="time" name="end_time" value="{{ old('end_time', '17:00') }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('end_time') border-red-500 @enderror">
                    @error('end_time')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Slot Duration -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Slot Duration (minutes)</label>
                    <select name="slot_duration_minutes" required 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('slot_duration_minutes') border-red-500 @enderror">
                        <option value="15" {{ old('slot_duration_minutes') == '15' ? 'selected' : '' }}>15 minutes</option>
                        <option value="30" {{ old('slot_duration_minutes', '30') == '30' ? 'selected' : '' }}>30 minutes</option>
                        <option value="45" {{ old('slot_duration_minutes') == '45' ? 'selected' : '' }}>45 minutes</option>
                        <option value="60" {{ old('slot_duration_minutes') == '60' ? 'selected' : '' }}>60 minutes</option>
                    </select>
                    @error('slot_duration_minutes')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Availability Status -->
            <div class="mb-6">
                <div class="flex items-center">
                    <input type="checkbox" name="is_available" id="is_available" value="1" checked
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="is_available" class="ml-2 block text-sm text-gray-900">
                        Doctor is available for appointments
                    </label>
                </div>
                <p class="text-sm text-gray-500 mt-1">Uncheck to make doctor unavailable for new appointments</p>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.doctors.index') }}" 
                   class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">
                    Create Doctor Profile
                </button>
            </div>
        </form>
    </div>
</div>
@endsection