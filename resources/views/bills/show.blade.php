<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <div class="flex items-center gap-3">
                    <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                        {{ $bill->name }}
                    </h2>
                    @if($bill->is_active)
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-700">
                            Active
                        </span>
                    @else
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-gray-100 text-gray-600">
                            Completed
                        </span>
                    @endif
                </div>
                <p class="text-sm text-gray-500 mt-1">
                    {{ $bill->category ?? 'General Expense' }}
                </p>
            </div>
            
            <div class="flex items-center gap-3">
                <a href="{{ route('bills.edit', $bill) }}" 
                   class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                    Edit Bill
                </a>
                <a href="{{ route('bills.index') }}" 
                   class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-900 transition">
                    &larr; Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Toast Notification -->
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
                     class="fixed bottom-5 right-5 bg-gray-900 text-white px-6 py-3 rounded-lg shadow-lg text-sm font-medium z-50 flex items-center gap-3"
                     x-transition:enter="translate-y-10 opacity-0"
                     x-transition:enter-end="translate-y-0 opacity-100">
                    <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- LEFT COLUMN: Stats & History -->
                <div class="lg:col-span-2 space-y-8">
                    
                    <!-- Hero Stats Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 divide-y md:divide-y-0 md:divide-x divide-gray-100">
                            <!-- Remaining -->
                            <div class="text-center md:text-left md:pr-4">
                                <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Remaining</p>
                                <p class="text-3xl font-bold text-gray-900 mt-1">Ksh {{ number_format($bill->remaining_amount, 2) }}</p>
                            </div>

                            <!-- Paid -->
                            <div class="text-center md:text-left md:px-4 pt-4 md:pt-0">
                                <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Paid So Far</p>
                                <p class="text-3xl font-bold text-green-600 mt-1">Ksh {{ number_format($bill->paid_amount, 2) }}</p>
                            </div>

                            <!-- Total -->
                            <div class="text-center md:text-left md:pl-4 pt-4 md:pt-0">
                                <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Total Bill</p>
                                <p class="text-3xl font-bold text-gray-400 mt-1">Ksh {{ number_format($bill->total_amount, 2) }}</p>
                            </div>
                        </div>

                        <!-- Progress Bar -->
                        <div class="mt-8">
                            <div class="flex justify-between items-end mb-2">
                                <span class="text-sm font-semibold text-gray-700">Progress</span>
                                <span class="text-xs text-gray-500">{{ $bill->paid_installments }} of {{ $bill->total_installments }} payments made ({{ $bill->progress_percentage }}%)</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2.5 overflow-hidden">
                                <div class="bg-gray-900 h-2.5 rounded-full transition-all duration-1000 ease-out" 
                                     style="width: {{ $bill->progress_percentage }}%"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Details Grid -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h3 class="font-bold text-gray-900 mb-4">Plan Details</h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                            <div class="flex flex-col">
                                <span class="text-xs text-gray-500 mb-1">Installment</span>
                                <span class="font-semibold text-gray-900">Ksh {{ number_format($bill->installment_amount) }}</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-xs text-gray-500 mb-1">Frequency</span>
                                <span class="font-semibold text-gray-900 capitalize">{{ $bill->frequency }}</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-xs text-gray-500 mb-1">Next Due</span>
                                <span class="font-semibold {{ $bill->is_overdue ? 'text-red-600' : 'text-gray-900' }}">
                                    {{ $bill->next_due_date ? $bill->next_due_date->format('M d, Y') : '-' }}
                                </span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-xs text-gray-500 mb-1">Payments Left</span>
                                <span class="font-semibold text-gray-900">{{ $bill->remaining_installments }}</span>
                            </div>
                        </div>
                        @if($bill->notes)
                            <div class="mt-6 pt-6 border-t border-gray-50">
                                <p class="text-sm text-gray-600 italic">"{{ $bill->notes }}"</p>
                            </div>
                        @endif
                    </div>

                    <!-- Payment History -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-6 border-b border-gray-50 flex justify-between items-center">
                            <h3 class="font-bold text-gray-900">Payment History</h3>
                            <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded-md">{{ $payments->count() }} records</span>
                        </div>
                        
                        @if($payments->count() > 0)
                            <div class="divide-y divide-gray-50">
                                @foreach($payments as $payment)
                                    <div class="p-4 flex items-center justify-between hover:bg-gray-50 transition">
                                        <div class="flex items-center gap-4">
                                            <div class="w-8 h-8 rounded-full bg-green-50 flex items-center justify-center text-green-600 border border-green-100">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900">Payment Received</p>
                                                <p class="text-xs text-gray-500">{{ $payment->payment_date->format('M d, Y') }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-bold text-gray-900">Ksh {{ number_format($payment->amount, 2) }}</p>
                                            @if($payment->notes)
                                                <p class="text-xs text-gray-400">{{ Str::limit($payment->notes, 20) }}</p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="p-8 text-center text-gray-400">
                                <p class="text-sm">No payments recorded yet.</p>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Danger Zone -->
                    <div class="flex justify-end">
                        <form method="POST" action="{{ route('bills.destroy', $bill) }}" onsubmit="return confirm('Are you sure? This will delete the bill and all payment history.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-sm text-red-500 hover:text-red-700 hover:underline transition">
                                Delete Bill
                            </button>
                        </form>
                    </div>

                </div>

                <!-- RIGHT COLUMN: Actions -->
                <div class="lg:col-span-1">
                    @if($bill->is_active)
                        <div class="bg-white rounded-xl shadow-lg border border-gray-100 sticky top-6 overflow-hidden">
                            <div class="bg-gray-900 p-6 text-white">
                                <h3 class="font-bold text-lg">Record Payment</h3>
                                <p class="text-gray-400 text-sm mt-1">Log a new installment payment.</p>
                            </div>
                            
                            <div class="p-6">
                                <form method="POST" action="{{ route('bills.payment', $bill) }}" class="space-y-5">
                                    @csrf

                                    <!-- Amount -->
                                    <div>
                                        <label for="amount" class="block text-sm font-medium text-gray-700 mb-1">
                                            Amount
                                        </label>
                                        <div class="relative">
                                            <span class="absolute left-3 top-2.5 text-gray-500 font-medium">Ksh</span>
                                            <input type="number" 
                                                   name="amount" 
                                                   id="amount" 
                                                   step="0.01" 
                                                   min="0.01"
                                                   value="{{ old('amount', $bill->installment_amount) }}"
                                                   class="w-full pl-12 rounded-lg border-gray-200 bg-gray-50 focus:bg-white focus:border-gray-900 focus:ring-0 transition duration-200"
                                                   required>
                                        </div>
                                        @if($bill->installment_amount > 0)
                                            <p class="mt-1.5 text-xs text-gray-500">
                                                Suggested: Ksh {{ number_format($bill->installment_amount) }}
                                            </p>
                                        @endif
                                    </div>

                                    <!-- Date -->
                                    <div>
                                        <label for="payment_date" class="block text-sm font-medium text-gray-700 mb-1">
                                            Date Paid
                                        </label>
                                        <input type="date" 
                                               name="payment_date" 
                                               id="payment_date" 
                                               value="{{ old('payment_date', date('Y-m-d')) }}"
                                               class="w-full rounded-lg border-gray-200 bg-gray-50 focus:bg-white focus:border-gray-900 focus:ring-0 transition duration-200 text-gray-600"
                                               required>
                                    </div>

                                    <!-- Notes -->
                                    <div>
                                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">
                                            Notes <span class="text-gray-400 font-normal">(Optional)</span>
                                        </label>
                                        <textarea name="notes" 
                                                  id="notes" 
                                                  rows="2"
                                                  class="w-full rounded-lg border-gray-200 bg-gray-50 focus:bg-white focus:border-gray-900 focus:ring-0 transition duration-200"
                                                  placeholder="e.g. Bank transfer">{{ old('notes') }}</textarea>
                                    </div>

                                    <button type="submit" 
                                            class="w-full bg-gray-900 text-white py-3 rounded-lg font-medium hover:bg-gray-800 transition shadow-sm">
                                        Confirm Payment
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <!-- Completed State -->
                        <div class="bg-green-50 rounded-xl border border-green-100 p-6 text-center">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4 text-green-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <h3 class="font-bold text-green-900 text-lg">Fully Paid!</h3>
                            <p class="text-green-700 text-sm mt-2">
                                You have successfully completed all payments for this bill.
                            </p>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>