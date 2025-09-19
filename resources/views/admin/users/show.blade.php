{{-- File: resources/views/admin/users/show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">User Details</h1>
        <p class="text-gray-600">Profile information of this user</p>
    </div>

    <div class="bg-white rounded-lg shadow-md p-8 space-y-6">
        <!-- Name -->
        <div>
            <h2 class="text-sm font-medium text-gray-500">Full Name</h2>
            <p class="text-lg text-gray-900">{{ $user->name }}</p>
        </div>

        <!-- Email -->
        <div>
            <h2 class="text-sm font-medium text-gray-500">Email</h2>
            <p class="text-lg text-gray-900">{{ $user->email }}</p>
        </div>

        <!-- Role -->
        <div>
            <h2 class="text-sm font-medium text-gray-500">Role</h2>
            <span class="inline-block px-3 py-1 text-sm rounded-full 
                @if($user->role == 'admin') bg-red-100 text-red-700 
                @elseif($user->role == 'doctor') bg-green-100 text-green-700 
                @else bg-blue-100 text-blue-700 @endif">
                {{ ucfirst($user->role) }}
            </span>
        </div>

        <!-- Created At -->
        <div>
            <h2 class="text-sm font-medium text-gray-500">Created At</h2>
            <p class="text-lg text-gray-900">{{ $user->created_at->format('M d, Y H:i') }}</p>
        </div>

        <!-- Updated At -->
        <div>
            <h2 class="text-sm font-medium text-gray-500">Last Updated</h2>
            <p class="text-lg text-gray-900">{{ $user->updated_at->format('M d, Y H:i') }}</p>
        </div>
    </div>

    <div class="flex justify-end mt-6">
        <a href="{{ route('admin.users.index') }}" 
           class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
            Back
        </a>
    </div>
</div>
@endsection
