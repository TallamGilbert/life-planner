<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $bill->name }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('bills.edit', $bill) }}" 
                   class="text-sm text-gray-600 hover:text-gray-900">
                    Edit
                </a>
                <a href="{{ route('bills.index') }}" 
                   class="text-sm text-gray-600 hover:text-gray-900">
                    ← Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Success Message -->
            @if(session('success'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        showToast('{{ session('success') }}', 'success');
                    });
                </script>
            @endif

            <!-- Bill Overview -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <!-- Total Amount -->
                        <div class="text-center">
                            <p class="text-sm text-gray-600">Total Amount</p>
                            <p class="text-3xl font-bold text-gray-900">Ksh {{ number_format($bill->total_amount, 2) }}</p>
                        </div>

                        <!-- Paid Amount -->
                        <div class="text-center">
                            <p class="text-sm text-gray-600">Paid So Far</p>
                            <p class="text-3xl font-bold text-green-600">Ksh {{ number_format($bill->paid_amount, 2) }}</p>
                        </div>

                        <!-- Remaining Amount -->
                        <div class="text-center">
                            <p class="text-sm text-gray-600">Remaining</p>
                            <p class="text-3xl font-bold text-red-600">Ksh {{ number_format($bill->remaining_amount, 2) }}</p>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    <div class="mb-6">
                        <div class="flex justify-between text-sm text-gray-600 mb-2">
                            <span>Progress: {{ $bill->paid_installments }} / {{ $bill->total_installments }} payments</span>
                            <span>{{ $bill->progress_percentage }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full progress-bar" 
                                    style="width: {{ $bill->progress_percentage }}%"></div>
                            </div>
                    </div>

                    <!-- Bill Details Grid -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 p-4 bg-gray-50 rounded-lg">
                        <div>
                            <p class="text-xs text-gray-500">Installment Amount</p>
                            <p class="font-semibold text-gray-900">Ksh {{ number_format($bill->installment_amount, 2) }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Frequency</p>
                            <p class="font-semibold text-gray-900 capitalize">{{ $bill->frequency }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Next Due Date</p>
                            <p class="font-semibold {{ $bill->is_overdue ? 'text-red-600' : 'text-gray-900' }}">
                                {{ $bill->next_due_date ? $bill->next_due_date->format('M d, Y') : 'Completed' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Remaining Payments</p>
                            <p class="font-semibold text-gray-900">{{ $bill->remaining_installments }}</p>
                        </div>
                    </div>

                    @if($bill->notes)
                        <div class="mt-4 p-4 bg-blue-50 rounded-lg">
                            <p class="text-sm text-gray-700">{{ $bill->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Record Payment Form -->
            @if($bill->is_active)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Record Payment</h3>
                        
                        <form method="POST" action="{{ route('bills.payment', $bill) }}" class="space-y-4">
                            @csrf

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Payment Amount -->
                                <div>
                                    <label for="amount" class="block text-sm font-medium text-gray-700 mb-1">
                                        Payment Amount *
                                    </label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-3 text-gray-500">$</span>
                                        <input type="number" 
                                               name="amount" 
                                               id="amount" 
                                               step="0.01" 
                                               min="0.01"
                                               value="{{ old('amount', $bill->installment_amount) }}"
                                               class="w-full pl-8 rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                               required>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">
                                        Regular installment: Ksh {{ number_format($bill->installment_amount, 2) }}
                                    </p>
                                    @error('amount')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Payment Date -->
                                <div>
                                    <label for="payment_date" class="block text-sm font-medium text-gray-700 mb-1">
                                        Payment Date *
                                    </label>
                                    <input type="date" 
                                           name="payment_date" 
                                           id="payment_date" 
                                           value="{{ old('payment_date', date('Y-m-d')) }}"
                                           class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                           required>
                                    @error('payment_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Notes -->
                            <div>
                                <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">
                                    Notes (Optional)
                                </label>
                                <input type="text" 
                                       name="notes" 
                                       id="notes" 
                                       value="{{ old('notes') }}"
                                       class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                       placeholder="e.g., Paid via bank transfer">
                                @error('notes')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" 
                                    class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                                Record Payment
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="bg-green-50 border border-green-200 rounded-lg p-6 text-center">
                    <svg class="w-16 h-16 mx-auto text-green-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="text-lg font-semibold text-green-900 mb-2">Bill Fully Paid </h3>
                    <p class="text-green-700">Congratulations! This bill has been completed.</p>
                </div>
            @endif

            <!-- Payment History -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Payment History</h3>

                    @if($payments->count() > 0)
                        <div class="space-y-3">
                            @foreach($payments as $payment)
                                <div class="flex justify-between items-center py-3 border-b last:border-b-0">
                                    <div>
                                        <p class="font-medium text-gray-900">
                                            ${{ number_format($payment->amount, 2) }}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            {{ $payment->payment_date->format('M d, Y') }}
                                            @if($payment->notes)
                                                • {{ $payment->notes }}
                                            @endif
                                        </p>
                                    </div>
                                    <span class="text-green-600">✓</span>
                                </div>
                            @endforeach
                        </div>

                        <!-- Summary -->
                        <div class="mt-4 pt-4 border-t">
                            <div class="flex justify-between text-sm font-medium">
                                <span>Total Payments Made:</span>
                                <span>{{ $payments->count() }}</span>
                            </div>
                            <div class="flex justify-between text-sm font-medium">
                                <span>Total Amount Paid:</span>
                                <span class="text-green-600">Ksh {{ number_format($payments->sum('amount'), 2) }}</span>
                            </div>
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">No payments recorded yet</p>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <!-- Delete Form (Hidden) -->
    <form id="delete-form" 
          method="POST" 
          action="{{ route('bills.destroy', $bill) }}" 
          class="hidden">
        @csrf
        @method('DELETE')
    </form>
</x-app-layout>