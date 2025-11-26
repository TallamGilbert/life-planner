<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    Bills & Installments
                </h2>
                <p class="text-sm text-gray-500 mt-1">Manage your recurring payments and debt.</p>
            </div>
            <a href="{{ route('bills.create') }}" 
               class="inline-flex items-center gap-2 bg-gray-900 text-white px-5 py-2.5 rounded-lg text-sm font-medium hover:bg-gray-800 transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                New Bill
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
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

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @php
                    $totalOwed = $activeBills->sum('remaining_amount');
                    $totalPaid = $activeBills->sum('paid_amount');
                    $upcomingPayments = $activeBills->where('next_due_date', '<=', now()->addDays(7))->count();
                    $overdueBills = $activeBills->where('is_overdue', true)->count();
                @endphp

                <!-- Total Remaining -->
                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)]">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="p-2 bg-red-50 text-red-600 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <p class="text-sm font-medium text-gray-500">Total Remaining</p>
                    </div>
                    <p class="text-2xl font-bold text-gray-900">Ksh {{ number_format($totalOwed, 2) }}</p>
                </div>

                <!-- Total Paid -->
                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)]">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="p-2 bg-green-50 text-green-600 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <p class="text-sm font-medium text-gray-500">Total Paid</p>
                    </div>
                    <p class="text-2xl font-bold text-gray-900">Ksh {{ number_format($totalPaid, 2) }}</p>
                </div>

                <!-- Due Soon -->
                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)]">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="p-2 bg-blue-50 text-blue-600 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <p class="text-sm font-medium text-gray-500">Due This Week</p>
                    </div>
                    <p class="text-2xl font-bold text-gray-900">{{ $upcomingPayments }}</p>
                </div>

                <!-- Overdue -->
                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)]">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="p-2 bg-orange-50 text-orange-600 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <p class="text-sm font-medium text-gray-500">Overdue Bills</p>
                    </div>
                    <p class="text-2xl font-bold {{ $overdueBills > 0 ? 'text-red-600' : 'text-gray-900' }}">
                        {{ $overdueBills }}
                    </p>
                </div>
            </div>

            <!-- Active Bills Grid -->
            <div>
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-gray-900">Active Bills</h3>
                </div>

                @if($activeBills->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($activeBills as $bill)
                            <div class="group bg-white rounded-xl border border-gray-100 hover:border-gray-300 hover:shadow-lg transition-all duration-200 flex flex-col h-full {{ $bill->is_overdue ? 'ring-1 ring-red-100' : '' }}">
                                <!-- Card Header -->
                                <div class="p-6 pb-4">
                                    <div class="flex justify-between items-start mb-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full flex items-center justify-center bg-gray-50 text-gray-600">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                            </div>
                                            <div>
                                                <h4 class="font-bold text-gray-900">{{ $bill->name }}</h4>
                                                <p class="text-xs text-gray-500">{{ $bill->category ?? 'General' }}</p>
                                            </div>
                                        </div>
                                        @if($bill->is_overdue)
                                            <span class="px-2 py-1 bg-red-50 text-red-600 text-[10px] font-bold uppercase tracking-wider rounded">Overdue</span>
                                        @else
                                            <span class="px-2 py-1 bg-green-50 text-green-600 text-[10px] font-bold uppercase tracking-wider rounded">Active</span>
                                        @endif
                                    </div>
                                    
                                    <div class="mb-1">
                                        <p class="text-sm text-gray-500 mb-1">Remaining Balance</p>
                                        <p class="text-2xl font-bold text-gray-900 tracking-tight">Ksh {{ number_format($bill->remaining_amount, 2) }}</p>
                                    </div>
                                </div>

                                <!-- Progress Bar -->
                                <div class="px-6">
                                    <div class="flex justify-between text-xs font-medium text-gray-500 mb-2">
                                        <span>Progress</span>
                                        <span>{{ $bill->progress_percentage }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-100 rounded-full h-1.5 overflow-hidden">
                                        <div class="bg-gray-900 h-1.5 rounded-full transition-all duration-500" 
                                             style="width: {{ $bill->progress_percentage }}%"></div>
                                    </div>
                                </div>

                                <!-- Details Grid -->
                                <div class="p-6 grid grid-cols-2 gap-4 text-sm mt-auto">
                                    <div>
                                        <p class="text-gray-400 text-xs mb-1">Installment</p>
                                        <p class="font-semibold text-gray-700">Ksh {{ number_format($bill->installment_amount) }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-400 text-xs mb-1">Next Due</p>
                                        <p class="font-semibold {{ $bill->is_overdue ? 'text-red-600' : 'text-gray-700' }}">
                                            {{ $bill->next_due_date ? $bill->next_due_date->format('M d') : 'N/A' }}
                                        </p>
                                    </div>
                                    <div class="col-span-2">
                                        <p class="text-gray-400 text-xs mb-1">Frequency</p>
                                        <p class="font-semibold text-gray-700 capitalize">{{ $bill->frequency }} • {{ $bill->remaining_installments }} payments left</p>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="px-6 pb-6 pt-2 flex gap-3">
                                    <a href="{{ route('bills.show', $bill) }}" 
                                       class="flex-1 bg-gray-900 text-white text-center py-2.5 rounded-lg text-sm font-medium hover:bg-gray-800 transition shadow-sm">
                                        Pay Now
                                    </a>
                                    <a href="{{ route('bills.show', $bill) }}" 
                                       class="px-4 py-2.5 bg-white border border-gray-200 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-50 transition">
                                        Details
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-white rounded-xl border border-gray-100 p-12 text-center">
                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">No active bills</h3>
                        <p class="text-gray-500 mt-1 mb-6">You're debt-free! Or maybe you just haven't added them yet.</p>
                        <a href="{{ route('bills.create') }}" class="inline-flex items-center gap-2 bg-gray-900 text-white px-5 py-2.5 rounded-lg text-sm font-medium hover:bg-gray-800 transition">
                            Create Bill
                        </a>
                    </div>
                @endif
            </div>

            <!-- Recently Completed -->
            @if($completedBills->count() > 0)
                <div class="mt-8">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">History</h3>
                    <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
                        <div class="divide-y divide-gray-50">
                            @foreach($completedBills as $bill)
                                <div class="p-4 flex items-center justify-between hover:bg-gray-50 transition">
                                    <div class="flex items-center gap-4">
                                        <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $bill->name }}</p>
                                            <p class="text-xs text-gray-500">Completed • {{ $bill->total_installments }} installments</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-gray-900">Ksh {{ number_format($bill->total_amount, 2) }}</p>
                                        <span class="text-xs text-green-600 font-medium">Fully Paid</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>