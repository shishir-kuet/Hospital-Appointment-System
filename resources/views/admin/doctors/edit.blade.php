{{-- File: resources/views/admin/doctors/edit.blade.php --}}
@extends('layouts.app')
@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Edit Doctor Profile</h1>
        <p class="text-gray-600">Update Dr. {{ $doctor->user->full_name }}'s information</p>
    </div>

        <form method="POST" action="{{ route('admin.doctors.update', $doctor) }}">
            @csrf
            @method('PUT')
            


            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Department -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Department</label>
                    <select name="department_id" required 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('department_id') border-red-500 @enderror">
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}" 
                                {{ old('department_id', $doctor->department_id) == $department->id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                        @endforeach
                        @error('department_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                </div>

                <!-- License Number -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Medical License Number</label>
                    <input type="text" name="license_number" value="{{ old('license_number', $doctor->license_number) }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('license_number') border-red-500 @enderror">
                    @error('license_number')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Specialization -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Specialization</label>
                    <input type="text" name="specialization" value="{{ old('specialization', $doctor->specialization) }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('specialization') border-red-500 @enderror">
                    @error('specialization')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Experience Years -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Years of Experience</label>
                    <input type="number" name="experience_years" value="{{ old('experience_years', $doctor->experience_years) }}" required min="0"
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
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('qualifications') border-red-500 @enderror">{{ old('qualifications', $doctor->qualifications) }}</textarea>
                @error('qualifications')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Bio -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Bio</label>
                <textarea name="bio" rows="4" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('bio') border-red-500 @enderror">{{ old('bio', $doctor->bio) }}</textarea>
                @error('bio')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Consultation Fee -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Consultation Fee (BDT)</label>
                <input type="number" name="consultation_fee" value="{{ old('consultation_fee', $doctor->consultation_fee) }}" required min="0" step="0.01"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('consultation_fee') border-red-500 @enderror">
                @error('consultation_fee')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Available Days -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Available Days</label>
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-3">
                    @php
                        $selectedDays = old('available_days', is_array($doctor->available_days) ? $doctor->available_days : explode(',', $doctor->available_days ?? ''));
                    @endphp
                    @foreach(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day)
                        <div class="flex items-center">
                            <input type="checkbox" name="available_days[]" id="{{ $day }}" value="{{ $day }}"
                                   {{ in_array($day, $selectedDays) ? 'checked' : '' }}
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
            </div>

            <!-- Availability Status -->
            <div class="mb-6">
                <div class="flex items-center">
                    <input type="checkbox" name="is_available" id="is_available" value="1" 
                           {{ old('is_available', $doctor->is_available) ? 'checked' : '' }}
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="is_available" class="ml-2 block text-sm text-gray-900">
                        Doctor is available for appointments
                    </label>
                </div>
                <p class="text-sm text-gray-500 mt-1">Uncheck to make doctor unavailable for new appointments</p>
            </div>

            <!-- Update Button -->
            <div class="mt-4 flex justify-end" style="position:relative; top:-5px;">
                <button type="submit" class="px-6 py-2 text-white font-semibold rounded shadow focus:outline-none focus:ring-2 focus:ring-green-700" style="background-color: #15803d !important; color: #fff !important; transition: background 0.2s;" onmouseover="this.style.backgroundColor='#166534'" onmouseout="this.style.backgroundColor='#15803d'">Update Doctor</button>
            </div>

        </form>
</div>
@endsection