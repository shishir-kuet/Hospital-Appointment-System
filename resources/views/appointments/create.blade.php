{{-- File: resources/views/appointments/create.blade.php --}}
<x-app-layout>
<div class="max-w-2xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Book New Appointment</h1>
        <p class="text-gray-600">Schedule your consultation with our doctors</p>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <form method="POST" action="{{ route('appointments.store') }}">
            @csrf
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Select Doctor</label>
                <select name="doctor_id" required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('doctor_id') border-red-500 @enderror">
                    <option value="">Choose a doctor...</option>
                    @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}" 
                                {{ old('doctor_id', request('doctor_id')) == $doctor->id ? 'selected' : '' }}
                                data-fee="{{ $doctor->consultation_fee }}">
                            Dr. {{ $doctor->user->full_name }} - {{ $doctor->specialization }} ({{ $doctor->department->name }}) - {{ number_format($doctor->consultation_fee, 2) }} BDT
                        </option>
                    @endforeach
                </select>
                @error('doctor_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Appointment Date</label>
                    <input type="date" name="appointment_date" value="{{ old('appointment_date', request('date')) }}" 
                           min="{{ date('Y-m-d', strtotime('+1 day')) }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('appointment_date') border-red-500 @enderror">
                    @error('appointment_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Appointment Time</label>
                    <input type="time" name="appointment_time" value="{{ old('appointment_time', request('time')) }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('appointment_time') border-red-500 @enderror">
                    @error('appointment_time')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Reason for Visit</label>
                <textarea name="reason_for_visit" rows="4" required
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('reason_for_visit') border-red-500 @enderror"
                          placeholder="Please describe your symptoms or reason for consultation">{{ old('reason_for_visit') }}</textarea>
                @error('reason_for_visit')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Fee Display -->
            <div id="fee-display" class="hidden mb-6 p-4 bg-blue-50 rounded-lg">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Consultation Fee:</span>
                    <span class="font-semibold text-blue-600" id="fee-amount">0.00 BDT</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Tax (10%):</span>
                    <span class="font-semibold text-blue-600" id="tax-amount">0.00 BDT</span>
                </div>
                <hr class="my-2">
                <div class="flex justify-between items-center">
                    <span class="font-semibold text-gray-800">Total Amount:</span>
                    <span class="font-bold text-blue-600" id="total-amount">0.00 BDT</span>
                </div>
            </div>

            <div class="flex justify-end space-x-4">
                <!-- Removed broken Back to Doctors link -->
                <button type="submit" 
                        class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">
                    Book Appointment
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const doctorSelect = document.querySelector('select[name="doctor_id"]');
    const feeDisplay = document.getElementById('fee-display');
    const feeAmount = document.getElementById('fee-amount');
    const taxAmount = document.getElementById('tax-amount');
    const totalAmount = document.getElementById('total-amount');

    doctorSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const fee = parseFloat(selectedOption.dataset.fee || 0);
        
        if (fee > 0) {
            const tax = fee * 0.1;
            const total = fee + tax;
            
            feeAmount.textContent = `${fee.toFixed(2)} BDT`;
            taxAmount.textContent = `${tax.toFixed(2)} BDT`;
            totalAmount.textContent = `${total.toFixed(2)} BDT`;

            feeDisplay.classList.remove('hidden');
        } else {
            feeDisplay.classList.add('hidden');
        }
    });
});
</script>
</x-app-layout>
