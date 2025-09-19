{{-- File: resources/views/bills/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">My Bills</h1>

    <!-- Bills Summary -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-full">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Pending</h3>
                    <p class="text-2xl font-bold text-yellow-600">
                        ${{ number_format($bills->where('payment_status', 'pending')->sum('total_amount'), 2) }}
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-full">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Paid</h3>
                    <p class="text-2xl font-bold text-green-600">
                        ${{ number_format($bills->where('payment_status', 'paid')->sum('total_amount'), 2) }}
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="flex items-center">
                <div class="p-3 bg-red-100 rounded-full">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Overdue</h3>
                    <p class="text-2xl font-bold text-red-600">
                        ${{ number_format($bills->where('payment_status', 'overdue')->sum('total_amount'), 2) }}
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-full">
                    <i class="fas fa-calculator text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Total</h3>
                    <p class="text-2xl font-bold text-blue-600">
                        ${{ number_format($bills->sum('total_amount'), 2) }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bills List -->
    <div class="bg-white rounded-lg shadow-md">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bill #</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Doctor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($bills as $bill)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $bill->bill_number }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">Dr. {{ $bill->appointment->doctor->user->full_name }}</div>
                                <div class="text-sm text-gray-500">{{ $bill->appointment->doctor->department->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $bill->created_at->format('M d, Y') }}</div>
                                <div class="text-sm text-gray-500">{{ $bill->created_at->format('h:i A') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">${{ number_format($bill->total_amount, 2) }}</div>
                                @if($bill->consultation_fee != $bill->total_amount)
                                    <div class="text-xs text-gray-500">Base: ${{ number_format($bill->consultation_fee, 2) }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($bill->payment_status === 'paid') bg-green-100 text-green-800
                                    @elseif($bill->payment_status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($bill->payment_status === 'overdue') bg-red-100 text-red-800
                                    @elseif($bill->payment_status === 'partially_paid') bg-blue-100 text-blue-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($bill->payment_status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('bills.show', $bill) }}" 
                                       class="text-blue-600 hover:text-blue-900">View</a>
                                    @if($bill->payment_status === 'pending')
                                        <button onclick="payBill({{ $bill->id }})"
                                                class="text-green-600 hover:text-green-900">Pay Now</button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <i class="fas fa-file-invoice text-gray-400 text-4xl mb-4"></i>
                                <p class="text-gray-500">No bills found.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($bills->hasPages())
        <div class="mt-8">
            {{ $bills->links() }}
        </div>
    @endif
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
@endsection