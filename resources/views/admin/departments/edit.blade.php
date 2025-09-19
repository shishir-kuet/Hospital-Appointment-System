{{-- File: resources/views/admin/departments/edit.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Edit Department</h1>
        <p class="text-gray-600">Update {{ $department->name }} department information</p>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <form method="POST" action="{{ route('admin.departments.update', $department) }}">
            @csrf
            @method('PUT')
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Department Name</label>
                <input type="text" name="name" value="{{ old('name', $department->name) }}" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Head of Department</label>
                <input type="text" name="head_of_department" value="{{ old('head_of_department', $department->head_of_department) }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('head_of_department') border-red-500 @enderror"
                       placeholder="Dr. John Smith">
                @error('head_of_department')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-sm text-gray-500 mt-1">Name of the department head (optional)</p>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea name="description" rows="4" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('description') border-red-500 @enderror"
                          placeholder="Brief description of the department and services offered">{{ old('description', $department->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-sm text-gray-500 mt-1">Describe the department's services and specialties</p>
            </div>

            <!-- Department Status -->
            <div class="mb-6">
                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" value="1" 
                           {{ old('is_active', $department->is_active) ? 'checked' : '' }}
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="is_active" class="ml-2 block text-sm text-gray-900">
                        Active Department
                    </label>
                </div>
                <p class="text-sm text-gray-500 mt-1">Deactivating will hide this department from patient booking</p>
            </div>

            <!-- Department Statistics -->
            <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                <h3 class="text-sm font-medium text-gray-700 mb-3">Department Statistics</h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-500">Total Doctors:</span>
                        <span class="font-semibold text-gray-800 ml-2">{{ $department->doctors->count() }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Created:</span>
                        <span class="font-semibold text-gray-800 ml-2">{{ $department->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.departments.index') }}" 
                   class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">
                    Update Department
                </button>
            </div>
        </form>
    </div>

    <!-- Doctors in Department -->
    @if($department->doctors->count() > 0)
        <div class="mt-8 bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Doctors in this Department</h2>
            <div class="space-y-3">
                @foreach($department->doctors as $doctor)
                    <div class="flex items-center justify-between p-3 border rounded-lg">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-user-md text-blue-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">Dr. {{ $doctor->user->full_name }}</p>
                                <p class="text-sm text-gray-600">{{ $doctor->specialization }}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="px-2 py-1 text-xs rounded-full {{ $doctor->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $doctor->is_available ? 'Available' : 'Unavailable' }}
                            </span>
                            <a href="{{ route('admin.doctors.edit', $doctor) }}" 
                               class="text-blue-600 hover:text-blue-900 text-sm">Edit</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection