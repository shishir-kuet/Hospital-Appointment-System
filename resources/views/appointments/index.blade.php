{{-- File: resources/views/appointments/index.blade.php --}}
<x-app-layout>

<div class="mb-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">My Appointments</h1>
        <a href="{{ route('appointments.create') }}" 
           class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition">
            <i class="fas fa-plus mr-2"></i>Book New Appointment
        </a>
    </div>

    <!-- Appointments List -->
    <div class="bg-white rounded-lg shadow-md">
        @forelse($appointments as $appointment)
            <div class="border-b last:border-b-0 p-6">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                    <div class="flex-1">
                        <div class="flex items-center mb-2">
                            <h3 class="text-lg font-semibold text-gray-800 mr-4">
                                Dr. {{ $appointment->doctor->user->full_name }}
                                <span class="ml-2 px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Doctor</span>
                            </h3>
                            <span class="px-2 py-1 text-xs rounded-full 
                                @if($appointment->status === 'completed') bg-green-100 text-green-800
                                @elseif($appointment->status === 'scheduled') bg-blue-100 text-blue-800
                                @elseif($appointment->status === 'confirmed') bg-indigo-100 text-indigo-800
                                @elseif($appointment->status === 'cancelled') bg-red-100 text-red-800
                                @else bg-yellow-100 text-yellow-800 @endif">
                                {{ ucfirst($appointment->status) }}
                            </span>
                        </div>
                        <div class="flex items-center mb-2">
                            <span class="text-sm text-gray-700 mr-2">Patient:</span>
                            <span class="font-semibold text-gray-800">{{ $appointment->patient->full_name }}</span>
                            <span class="ml-2 px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">Patient</span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 text-sm text-gray-600">
                            <div class="flex items-center">
                                <i class="fas fa-calendar mr-2"></i>
                                {{ $appointment->appointment_date->format('M d, Y') }}
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-clock mr-2"></i>
                                {{ $appointment->appointment_time->format('h:i A') }}
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-building mr-2"></i>
                                {{ $appointment->doctor->department->name }}
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-hashtag mr-2"></i>
                                {{ $appointment->appointment_number }}
                            </div>
                        </div>
                        @if($appointment->reason_for_visit)
                            <div class="mt-2">
                                <span class="text-sm font-medium text-gray-700">Reason: </span>
                                <span class="text-sm text-gray-600">{{ $appointment->reason_for_visit }}</span>
                            </div>
                        @endif
                    </div>
                    
                    <div class="mt-4 lg:mt-0 lg:ml-4 flex space-x-2">
                        <a href="{{ route('appointments.show', $appointment) }}" 
                           class="bg-blue-500 text-white px-4 py-2 rounded text-sm hover:bg-blue-600 transition">
                            View Details
                        </a>
                        
                        @if(in_array($appointment->status, ['scheduled', 'confirmed']))
                            <button onclick="cancelAppointment({{ $appointment->id }})"
                                    class="bg-red-500 text-white px-4 py-2 rounded text-sm hover:bg-red-600 transition">
                                Cancel
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="p-12 text-center">
                <i class="fas fa-calendar-times text-gray-400 text-6xl mb-4"></i>
                <p class="text-gray-500 text-lg mb-4">No appointments found.</p>
                <a href="{{ route('appointments.create') }}" 
                   class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 transition">
                    Book Your First Appointment
                </a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($appointments->hasPages())
        <div class="mt-8">
            {{ $appointments->links() }}
        </div>
    @endif
</div>

<!-- Cancel Appointment Modal -->
<div id="cancelModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-md mx-4">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Cancel Appointment</h3>
        <form id="cancelForm" method="POST">
            @csrf
            @method('PATCH')
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Cancellation Reason</label>
                <textarea name="cancellation_reason" rows="3" required
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                          placeholder="Please provide a reason for cancellation"></textarea>
            </div>
            <input type="hidden" name="status" value="cancelled">
            <div class="flex space-x-4">
                <button type="button" onclick="closeCancelModal()"
                        class="flex-1 bg-gray-500 text-white py-2 px-4 rounded hover:bg-gray-600 transition">
                    Cancel
                </button>
                <button type="submit"
                        class="flex-1 bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600 transition">
                    Confirm Cancellation
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function cancelAppointment(appointmentId) {
    document.getElementById('cancelForm').action = `/appointments/${appointmentId}/status`;
    document.getElementById('cancelModal').classList.remove('hidden');
    document.getElementById('cancelModal').classList.add('flex');
}

function closeCancelModal() {
    document.getElementById('cancelModal').classList.add('hidden');
    document.getElementById('cancelModal').classList.remove('flex');
}
</script>
</x-app-layout>