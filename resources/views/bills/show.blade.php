{{-- File: resources/views/bills/show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Bill Details</h1>
                <p class="text-gray-600">{{ $bill->bill_number }}</p>
            </div>
            <span class="px-4 py-2 rounded-full text-sm font-semibold
                @if($bill->payment_status === 'paid') bg-green-100 text-green-800
                @elseif($bill->payment_status === 'pending') bg-yellow-100 text-yellow-800
                @elseif($bill->payment_status === 'overdue') bg-red-100 text-red-800
                @else bg-gray-100 text-gray-800 @endif">
                {{ ucfirst($bill->payment_status) }}
            </span>
        </div>
    </div>

    <!-- Bill Information -->
    <div class="bg-white rounded-lg shadow-md p-8 mb-8">
        <div class="border-b pb-6 mb-6">
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Hospital Management System</h2>
                    <p class="text-gray-600">Your Healthcare Partner</p>
                </div>
                <div class="text-right">
                    <p class="text-gray-600">Bill Date: {{ $bill->created_at->format('M d, Y') }}</p>
                    <p class="text-gray-600">Bill #: {{ $bill->bill_number }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <!-- Patient Information -->
            <div>
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Patient Information</h3>
                <div class="space-y-2">
                    <p><span class="font-medium">Name:</span> {{ $bill->patient->full_name }}</p>
                    <p><span class="font-medium">Email:</span> {{ $bill->patient->email }}</p>
                    <p><span class="font-medium">Phone:</span> {{ $bill->patient->phone ?: 'N/A' }}</p>
                    @if($bill->patient->address)
                        <p><span class="font-medium">Address:</span> {{ $bill->patient->address }}</p>
                    @endif
                </div>
            </div>

            <!-- Appointment Information -->
            <div>
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Appointment Information</h3>
                <div class="space-y-2">
                    <p><span class="font-medium">Doctor:</span> Dr. {{ $bill->appointment->doctor->user->full_name }}</p>
                    <p><span class="font-medium">Department:</span> {{ $bill->appointment->doctor->department->name }}</p>
                    <p><span class="font-medium">Specialization:</span> {{ $bill->appointment->doctor->specialization }}</p>
                    <p><span class="font-medium">Date:</span> {{ $bill->appointment->appointment_date->format('M d, Y') }}</p>
                    <p><span class="font-medium">Time:</span> {{ $bill->appointment->appointment_time->format('h:i A') }}</p>
                    <p><span class="font-medium">Appointment #:</span> {{ $bill->appointment->appointment_number }}</p>
                </div>
            </div>
        </div>

        <!-- Bill Items -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Services</h3>
            <div class="overflow-x-auto">
                <table class="w-full border border-gray-300">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Service</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Quantity</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Unit Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">Consultation</div>
                                    <div class="text-sm text-gray-500">Dr. {{ $bill->appointment->doctor->user->full_name }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">1</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${{ number_format($bill->consultation_fee, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${{ number_format($bill->consultation_fee, 2) }}</td>
                        </tr>
                        
                        @foreach($bill->billItems as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $item->item_name }}</div>
                                        @if($item->description)
                                            <div class="text-sm text-gray-500">{{ $item->description }}</div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->quantity }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${{ number_format($item->unit_price, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${{ number_format($item->total_price, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Bill Summary -->
        <div class="flex justify-end">
            <div class="w-full max-w-sm">
                <div class="bg-gray-50 p-6 rounded-lg">
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Subtotal:</span>
                            <span>${{ number_format($bill->consultation_fee + $bill->additional_charges, 2) }}</span>
                        </div>
                        @if($bill->discount_amount > 0)
                            <div class="flex justify-between text-green-600">
                                <span>Discount:</span>
                                <span>-${{ number_format($bill->discount_amount, 2) }}</span>
                            </div>
                        @endif
                        @if($bill->tax_amount > 0)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tax:</span>
                                <span>${{ number_format($bill->tax_amount, 2) }}</span>
                            </div>
                        @endif
                        <hr>
                        <div class="flex justify-between text-xl font-bold">
                            <span>Total Amount:</span>
                            <span>${{ number_format($bill->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Information -->
        @if($bill->payment_status === 'paid')
            <div class="mt-8 p-4 bg-green-50 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-600 mr-2"></i>
                    <span class="font-semibold text-green-800">Payment Received</span>
                </div>
                <div class="mt-2 text-sm text-green-700">
                    <p>Payment Method: {{ ucfirst($bill->payment_method) }}</p>
                    <p>Payment Date: {{ $bill->payment_date->format('M d, Y h:i A') }}</p>
                    @if($bill->notes)
                        <p>Notes: {{ $bill->notes }}</p>
                    @endif
                </div>
            </div>
        @endif
    </div>

    <!-- Actions -->
    <div class="flex justify-between items-center">
        <a href="{{ route('bills.index') }}" 
           class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600 transition">
            <i class="fas fa-arrow-left mr-2"></i>Back to Bills
        </a>
        
        <div class="space-x-4">
            <button onclick="window.print()" 
                    class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 transition">
                <i class="fas fa-print mr-2"></i>Print Bill
            </button>
            
            @if($bill->payment_status === 'pending')
                <button onclick="payBill({{ $bill->id }})" 
                        class="bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600 transition">
                    <i class="fas fa-credit-card mr-2"></i>Pay Now
                </button>
            @endif
        </div>
    </div>
</div>

<!-- Payment Modal -->
<div id="paymentModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-md mx-4">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Process Payment</h3>
        <form id="paymentForm" method="POST">
            @csrf
            @method('PATCH')
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Payment Method</label>
                <select name="payment_method" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Select Payment Method</option>
                    <option value="cash">Cash</option>
                    <option value="card">Credit/Debit Card</option>
                    <option value="bank_transfer">Bank Transfer</option>
                    <option value="online">Online Payment</option>
                    <option value="insurance">Insurance</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Notes (Optional)</label>
                <textarea name="notes" rows="2"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                          placeholder="Any additional notes"></textarea>
            </div>
            <input type="hidden" name="payment_status" value="paid">
            <div class="flex space-x-4">
                <button type="button" onclick="closePaymentModal()"
                        class="flex-1 bg-gray-500 text-white py-2 px-4 rounded hover:bg-gray-600 transition">
                    Cancel
                </button>
                <button type="submit"
                        class="flex-1 bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600 transition">
                    Process Payment
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function payBill(billId) {
    document.getElementById('paymentForm').action = `/bills/${billId}/payment`;
    document.getElementById('paymentModal').classList.remove('hidden');
    document.getElementById('paymentModal').classList.add('flex');
}

function closePaymentModal() {
    document.getElementById('paymentModal').classList.add('hidden');
    document.getElementById('paymentModal').classList.remove('flex');
}
</script>

<style>
@media print {
    .no-print { display: none !important; }
    body { font-size: 12px; }
}
</style>
@endsection