{{-- File: resources/views/appointments/show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Appointment Details</h1>
                <p class="text-gray-600">{{ $appointment->appointment_number }}</p>
            </div>
            <span class="px-4 py-2 rounded-full text-sm font-semibold
                @if($appointment->status === 'completed') bg-green-100 text-green-800
                @elseif($appointment->status === 'scheduled') bg-blue-100 text-blue-800
                @elseif($appointment->status === 'confirmed') bg-indigo-100 text-indigo-800
                @elseif($appointment->status === 'cancelled') bg-red-100 text-red-800
                @else bg-yellow-100 text-yellow-800 @endif">
                {{ ucfirst($appointment->status) }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Appointment Information -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Appointment Information</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Doctor</h3>
                        <p class="text-lg text-gray-800">Dr. {{ $appointment->doctor->user->full_name }}</p>
                        <p class="text-sm text-gray-600">{{ $appointment->doctor->specialization }}</p>
                        <p class="text-sm text-blue-600">{{ $appointment->doctor->department->name }}</p>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Patient</h3>
                        <p class="text-lg text-gray-800">{{ $appointment->patient->full_name }}</p>
                        <p class="text-sm text-gray-600">{{ $appointment->patient->email }}</p>
                        <p class="text-sm text-gray-600">{{ $appointment->patient->phone }}</p>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Date & Time</h3>
                        <p class="text-lg text-gray-800">{{ $appointment->appointment_date->format('F d, Y') }}</p>
                        <p class="text-sm text-gray-600">{{ $appointment->appointment_time->format('h:i A') }}</p>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Appointment Number</h3>
                        <p class="text-lg text-gray-800">{{ $appointment->appointment_number }}</p>
                        <p class="text-sm text-gray-600">Created {{ $appointment->created_at->format('M d, Y') }}</p>
                    </div>
                </div>

                @if($appointment->reason_for_visit)
                    <div class="mt-6">
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Reason for Visit</h3>
                        <p class="text-gray-800">{{ $appointment->reason_for_visit }}</p>
                    </div>
                @endif

                @if($appointment->notes)
                    <div class="mt-6">
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Doctor's Notes</h3>
                        <p class="text-gray-800">{{ $appointment->notes }}</p>
                    </div>
                @endif

                @if($appointment->diagnosis)
                    <div class="mt-6">
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Diagnosis</h3>
                        <p class="text-gray-800">{{ $appointment->diagnosis }}</p>
                    </div>
                @endif

                @if($appointment->prescription)
                    <div class="mt-6">
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Prescription</h3>
                        <p class="text-gray-800">{{ $appointment->prescription }}</p>
                    </div>
                @endif

                @if($appointment->cancellation_reason)
                    <div class="mt-6">
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Cancellation Reason</h3>
                        <p class="text-red-600">{{ $appointment->cancellation_reason }}</p>
                        <p class="text-sm text-gray-500">
                            Cancelled on
                            @if($appointment->cancelled_at)
                                {{ $appointment->cancelled_at->format('M d, Y h:i A') }}
                            @else
                                (date not available)
                            @endif
                        </p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Bill Information -->
        <div>
            @if($appointment->bill)
                <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Billing Information</h2>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Bill Number:</span>
                            <span class="font-semibold">{{ $appointment->bill->bill_number }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Consultation Fee:</span>
                            <span>{{ number_format($appointment->bill->consultation_fee, 2) }} BDT</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tax:</span>
                            <span>{{ number_format($appointment->bill->tax_amount, 2) }} BDT</span>
                        </div>
                        <hr>
                        <div class="flex justify-between text-lg font-semibold">
                            <span>Total Amount:</span>
                            <span>{{ number_format($appointment->bill->total_amount, 2) }} BDT</span>
                        </div>
                    </div>

                    <div>
                        @if($appointment->bill)
                            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                                <h2 class="text-xl font-semibold text-gray-800 mb-4">Billing Information</h2>
                                <div class="space-y-3">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Bill Number:</span>
                                        <span class="font-semibold">{{ $appointment->bill->bill_number }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Consultation Fee:</span>
                                        <span>{{ number_format($appointment->bill->consultation_fee, 2) }} BDT</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Tax:</span>
                                        <span>{{ number_format($appointment->bill->tax_amount, 2) }} BDT</span>
                                    </div>
                                    <hr>
                                    <div class="flex justify-between text-lg font-semibold">
                                        <span>Total Amount:</span>
                                        <span>{{ number_format($appointment->bill->total_amount, 2) }} BDT</span>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <span class="px-3 py-1 rounded-full text-sm font-semibold
                                        @if($appointment->bill->payment_status === 'paid') bg-green-100 text-green-800
                                        @elseif($appointment->bill->payment_status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($appointment->bill->payment_status === 'overdue') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst($appointment->bill->payment_status) }}
                                    </span>
                                </div>
                                <div class="mt-4">
                                    <a href="{{ route('bills.show', $appointment->bill) }}" 
                                       class="w-full bg-blue-500 text-white text-center py-2 px-4 rounded hover:bg-blue-600 transition block">
                                        View Full Bill
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                                <h2 class="text-xl font-semibold text-gray-800 mb-4">Billing Information</h2>
                                <p class="text-gray-500">No bill has been generated for this appointment.</p>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Cancel Modal -->
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
@endsection