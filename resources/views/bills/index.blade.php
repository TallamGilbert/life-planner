{{-- @formatter:off --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Bills & Installments
            </h2>
            <a href="{{ route('bills.create') }}" 
               class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                + New Bill
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Success Message -->
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                @php
                    $totalOwed = $activeBills->sum('remaining_amount');
                    $totalPaid = $activeBills->sum('paid_amount');
                    $upcomingPayments = $activeBills->where('next_due_date', '<=', now()->addDays(7))->count();
                    $overdueBills = $activeBills->where('is_overdue', true)->count();
                @endphp

                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <p class="text-sm text-gray-600">Total Remaining</p>
                    <p class="text-2xl font-bold text-red-600">Ksh {{ number_format($totalOwed, 2) }}</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <p class="text-sm text-gray-600">Total Paid</p>
                    <p class="text-2xl font-bold text-green-600">Ksh {{ number_format($totalPaid, 2) }}</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <p class="text-sm text-gray-600">Due This Week</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $upcomingPayments }}</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <p class="text-sm text-gray-600">Overdue</p>
                    <p class="text-2xl font-bold {{ $overdueBills > 0 ? 'text-red-600' : 'text-green-600' }}">
                        {{ $overdueBills }}
                    </p>
                </div>
            </div>

            <!-- Active Bills -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Active Bills</h3>

                    @if($activeBills->count() > 0)
                        <div class="space-y-4">
                            @foreach($activeBills as $bill)
                                <div class="border rounded-lg p-4 {{ $bill->is_overdue ? 'border-red-300 bg-red-50' : 'border-gray-200' }}">
                                    <div class="flex justify-between items-start mb-3">
                                        <div class="flex-1">
                                            <h4 class="font-semibold text-gray-900">{{ $bill->name }}</h4>
                                            <p class="text-sm text-gray-500">{{ $bill->category ?? 'Uncategorized' }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-lg font-bold text-red-600">
                                                ${{ number_format($bill->remaining_amount, 2) }}
                                            </p>
                                            <p class="text-xs text-gray-500">remaining</p>
                                        </div>
                                    </div>

                                    <!-- Progress Bar -->
                                    <div class="mb-3">
                                        <div class="flex justify-between text-xs text-gray-600 mb-1">
                                            <span>{{ $bill->paid_installments }} / {{ $bill->total_installments }} payments</span>
                                            <span>{{ $bill->progress_percentage }}%</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-blue-600 h-2 rounded-full" 
                                                 style="width: {{ $bill->progress_percentage }}%"></div>
                                        </div>
                                    </div>

                                    <!-- Details -->
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-sm mb-3">
                                        <div>
                                            <p class="text-gray-500">Installment</p>
                                            <p class="font-semibold">${{ number_format($bill->installment_amount, 2) }}</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500">Frequency</p>
                                            <p class="font-semibold capitalize">{{ $bill->frequency }}</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500">Next Due</p>
                                            <p class="font-semibold {{ $bill->is_overdue ? 'text-red-600' : '' }}">
                                                {{ $bill->next_due_date ? $bill->next_due_date->format('M d, Y') : 'N/A' }}
                                            </p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500">Remaining</p>
                                            <p class="font-semibold">{{ $bill->remaining_installments }} payments</p>
                                        </div>
                                    </div>

                                    <!-- Actions -->
                                    <div class="flex gap-2">
                                        <a href="{{ route('bills.show', $bill) }}" 
                                           class="flex-1 bg-blue-600 text-white text-center py-2 rounded-lg hover:bg-blue-700 transition text-sm">
                                            Record Payment
                                        </a>
                                        <a href="{{ route('bills.show', $bill) }}" 
                                           class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition text-sm">
                                            Details
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p class="text-gray-600 mb-4">No bills yet</p>
                            <a href="{{ route('bills.create') }}" 
                               class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                                Create Your First Bill
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Completed Bills -->
            @if($completedBills->count() > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Recently Completed</h3>
                        <div class="space-y-3">
                            @foreach($completedBills as $bill)
                                <div class="flex justify-between items-center py-3 border-b last:border-b-0">
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $bill->name }}</p>
                                        <p class="text-sm text-gray-500">
                                            ${{ number_format($bill->total_amount, 2) }} • 
                                            {{ $bill->total_installments }} payments
                                        </p>
                                    </div>
                                    <span class="text-green-600 font-semibold">✓ Paid</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>