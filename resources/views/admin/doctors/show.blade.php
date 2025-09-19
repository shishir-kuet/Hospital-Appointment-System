@extends('layouts.app')
@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Doctor Details</h1>
        <p class="text-gray-600">Profile information of this doctor</p>
    </div>
    <div class="bg-white rounded-lg shadow-md p-8 space-y-6">
        <div>
            <h2 class="text-sm font-medium text-gray-500">Full Name</h2>
            <p class="text-lg text-gray-900">{{ $doctor->user->full_name }}</p>
        </div>
        <div>
            <h2 class="text-sm font-medium text-gray-500">Email</h2>
            <p class="text-lg text-gray-900">{{ $doctor->user->email }}</p>
        </div>
        <div>
            <h2 class="text-sm font-medium text-gray-500">Department</h2>
            <p class="text-lg text-gray-900">{{ $doctor->department->name ?? 'N/A' }}</p>
        </div>
        <div>
            <h2 class="text-sm font-medium text-gray-500">License Number</h2>
            <p class="text-lg text-gray-900">{{ $doctor->license_number }}</p>
        </div>
        <div>
            <h2 class="text-sm font-medium text-gray-500">Created At</h2>
            <p class="text-lg text-gray-900">{{ $doctor->created_at->format('M d, Y H:i') }}</p>
        </div>
        <div>
            <h2 class="text-sm font-medium text-gray-500">Last Updated</h2>
            <p class="text-lg text-gray-900">{{ $doctor->updated_at->format('M d, Y H:i') }}</p>
        </div>
    </div>
    <div class="flex justify-end mt-6">
        <a href="{{ route('admin.doctors.index') }}" 
           class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
            Back
        </a>
    </div>
</div>
@endsection
