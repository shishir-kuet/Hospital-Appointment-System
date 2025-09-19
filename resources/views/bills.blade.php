<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bills') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($bills->isEmpty())
                        <p>No bills found.</p>
                    @else
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">Bill Number</th>
                                    <th class="px-4 py-2">Appointment</th>
                                    <th class="px-4 py-2">Doctor</th>
                                    <th class="px-4 py-2">Consultation Fee (BDT)</th>
                                    <th class="px-4 py-2">Tax (BDT)</th>
                                    <th class="px-4 py-2">Discount (BDT)</th>
                                    <th class="px-4 py-2">Total (BDT)</th>
                                    <th class="px-4 py-2">Payment Status</th>
                                    <th class="px-4 py-2">Payment Method</th>
                                    <th class="px-4 py-2">Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bills as $bill)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $bill->bill_number }}</td>
                                        <td class="border px-4 py-2">
                                            @if($bill->appointment)
                                                {{ $bill->appointment->appointment_number }}<br>
                                                {{ $bill->appointment->appointment_date }} {{ $bill->appointment->appointment_time }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td class="border px-4 py-2">
                                            @if($bill->appointment && $bill->appointment->doctor)
                                                Dr. {{ $bill->appointment->doctor->user->full_name ?? ($bill->appointment->doctor->user->first_name ?? 'N/A') }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td class="border px-4 py-2">{{ number_format($bill->consultation_fee, 2) }}</td>
                                        <td class="border px-4 py-2">{{ number_format($bill->tax_amount, 2) }}</td>
                                        <td class="border px-4 py-2">{{ number_format($bill->discount_amount, 2) }}</td>
                                        <td class="border px-4 py-2">{{ number_format($bill->total_amount, 2) }}</td>
                                        <td class="border px-4 py-2">{{ ucfirst($bill->payment_status) }}</td>
                                        <td class="border px-4 py-2">{{ ucfirst($bill->payment_method ?? 'N/A') }}</td>
                                        <td class="border px-4 py-2">{{ $bill->notes ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="10" class="border px-4 py-2 bg-gray-50">
                                            <strong>Items:</strong>
                                            @if($bill->billItems->isEmpty())
                                                <span>No items</span>
                                            @else
                                                <ul class="list-disc ml-4">
                                                    @foreach($bill->billItems as $item)
                                                        <li>{{ $item->item_name }} ({{ $item->quantity }} x {{ number_format($item->unit_price, 2) }} BDT) = {{ number_format($item->total_price, 2) }} BDT</li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
