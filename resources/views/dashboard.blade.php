<x-app-layout>
    <x-slot name="header">
    <h2 class="font-extrabold text-4xl text-blue-700 text-left w-full block">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gradient-to-br from-purple-200 via-blue-100 to-pink-100 shadow-2xl rounded-2xl p-10 border border-purple-200 transition duration-200 group hover:shadow-2xl hover:-translate-y-1 hover:border-pink-400">
                <div class="mb-8 border-b pb-6">
                    <h3 class="text-2xl font-bold text-blue-900 mb-2">Welcome, {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}!</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700">
                        <div><span class="font-semibold">Email:</span> {{ Auth::user()->email }}</div>
                        <div><span class="font-semibold">Phone:</span> {{ Auth::user()->phone ?? 'N/A' }}</div>
                        <div><span class="font-semibold">Role:</span> {{ ucfirst(Auth::user()->role) }}</div>
                    </div>
                </div>

                <div class="mb-10">
                    <h4 class="text-xl font-semibold text-blue-800 mb-4">Your Appointments</h4>
                    @php
                        $appointments = \App\Models\Appointment::where('patient_id', Auth::id())->orderBy('appointment_date', 'desc')->get();
                    @endphp
                    @if($appointments->isEmpty())
                        <div class="text-gray-500">No appointments found.</div>
                    @else
                        <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                            <thead class="bg-blue-100">
                                <tr>
                                    <th class="px-4 py-2 text-left">Date</th>
                                    <th class="px-4 py-2 text-left">Time</th>
                                    <th class="px-4 py-2 text-left">Doctor</th>
                                    <th class="px-4 py-2 text-left">Status</th>
                                    <th class="px-4 py-2 text-left">Reason</th>
                                    <th class="px-4 py-2 text-left">Bill</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($appointments as $appointment)
                                    <tr class="border-b">
                                        <td class="px-4 py-2">{{ $appointment->appointment_date }}</td>
                                        <td class="px-4 py-2">{{ $appointment->appointment_time }}</td>
                                        <td class="px-4 py-2">
                                            @if($appointment->doctor && $appointment->doctor->user)
                                                Dr. {{ $appointment->doctor->user->full_name ?? ($appointment->doctor->user->first_name ?? 'N/A') }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td class="px-4 py-2">
                                            <span class="px-2 py-1 rounded text-xs font-semibold {{ $appointment->status === 'scheduled' ? 'bg-yellow-100 text-yellow-800' : ($appointment->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800') }}">
                                                {{ ucfirst($appointment->status) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-2">{{ $appointment->reason_for_visit ?? 'N/A' }}</td>
                                        <td class="px-4 py-2">
                                            @if($appointment->bill)
                                                <span class="text-green-700 font-semibold">{{ $appointment->bill->bill_number }}</span><br>
                                                <span class="text-xs">{{ ucfirst($appointment->bill->payment_status) }}</span><br>
                                                <span class="text-xs">{{ number_format($appointment->bill->total_amount, 2) }} BDT</span>
                                            @else
                                                <span class="text-gray-400">N/A</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </div>
                    @endif
                </div>

                <div>
                    <h4 class="text-xl font-semibold text-blue-800 mb-4">Your Bills</h4>
                    @php
                        $bills = \App\Models\Bill::where('patient_id', Auth::id())->orderBy('created_at', 'desc')->get();
                    @endphp
                    @if($bills->isEmpty())
                        <div class="text-gray-500">No bills found.</div>
                    @else
                        <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                            <thead class="bg-blue-100">
                                <tr>
                                    <th class="px-4 py-2 text-left">Bill Number</th>
                                    <th class="px-4 py-2 text-left">Appointment</th>
                                    <th class="px-4 py-2 text-left">Doctor</th>
                                    <th class="px-4 py-2 text-left">Consultation Fee</th>
                                    <th class="px-4 py-2 text-left">Tax</th>
                                    <th class="px-4 py-2 text-left">Discount</th>
                                    <th class="px-4 py-2 text-left">Total</th>
                                    <th class="px-4 py-2 text-left">Status</th>
                                    <th class="px-4 py-2 text-left">Payment Method</th>
                                    <th class="px-4 py-2 text-left">Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bills as $bill)
                                    <tr class="border-b">
                                        <td class="px-4 py-2 font-semibold">{{ $bill->bill_number }}</td>
                                        <td class="px-4 py-2">
                                            @if($bill->appointment)
                                                {{ $bill->appointment->appointment_number }}<br>
                                                <span class="text-xs text-gray-500">{{ $bill->appointment->appointment_date }} {{ $bill->appointment->appointment_time }}</span>
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td class="px-4 py-2">
                                            @if($bill->appointment && $bill->appointment->doctor)
                                                Dr. {{ $bill->appointment->doctor->user->full_name ?? ($bill->appointment->doctor->user->first_name ?? 'N/A') }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td class="px-4 py-2">{{ number_format($bill->consultation_fee, 2) }} BDT</td>
                                        <td class="px-4 py-2">{{ number_format($bill->tax_amount, 2) }} BDT</td>
                                        <td class="px-4 py-2">{{ number_format($bill->discount_amount, 2) }} BDT</td>
                                        <td class="px-4 py-2 font-bold">{{ number_format($bill->total_amount, 2) }} BDT</td>
                                        <td class="px-4 py-2">
                                            <span class="px-2 py-1 rounded text-xs font-semibold {{ $bill->payment_status === 'paid' ? 'bg-green-100 text-green-800' : ($bill->payment_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                                {{ ucfirst($bill->payment_status) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-2">{{ ucfirst($bill->payment_method ?? 'N/A') }}</td>
                                        <td class="px-4 py-2">{{ $bill->notes ?? '' }}</td>
                                    </tr>
                                    <tr class="bg-gray-50">
                                        <td colspan="10" class="px-4 py-2">
                                            <strong>Items:</strong>
                                            @if($bill->billItems->isEmpty())
                                                <span class="text-gray-400">No items</span>
                                            @else
                                                <ul class="list-disc ml-4 text-sm text-gray-700">
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
                        </div>
                    @endif
                </div>
            </div>
        </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
