<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    {{ __('Transactions') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Track your income and spending history.</p>
            </div>
            <a href="{{ route('expenses.create') }}" 
               class="inline-flex items-center gap-2 bg-gray-900 text-white px-5 py-2.5 rounded-lg text-sm font-medium hover:bg-gray-800 transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Add Transaction
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Toast Notification Script -->
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
                     class="fixed bottom-5 right-5 bg-gray-900 text-white px-6 py-3 rounded-lg shadow-lg text-sm font-medium z-50 flex items-center gap-3 transition-all transform duration-500"
                     x-transition:enter="translate-y-10 opacity-0"
                     x-transition:enter-end="translate-y-0 opacity-100"
                     x-transition:leave="translate-y-10 opacity-0">
                    <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                @php
                    $totalIncome = auth()->user()->expenses()->where('type', 'income')->sum('amount');
                    $totalExpenses = auth()->user()->expenses()->where('type', 'expense')->sum('amount');
                    $balance = $totalIncome - $totalExpenses;
                @endphp

                <!-- Income -->
                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)]">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="p-2 bg-green-50 text-green-600 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path></svg>
                        </div>
                        <p class="text-sm font-medium text-gray-500">Total Income</p>
                    </div>
                    <p class="text-2xl font-bold text-gray-900">Ksh {{ number_format($totalIncome, 2) }}</p>
                </div>

                <!-- Expenses -->
                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)]">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="p-2 bg-red-50 text-red-600 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path></svg>
                        </div>
                        <p class="text-sm font-medium text-gray-500">Total Expenses</p>
                    </div>
                    <p class="text-2xl font-bold text-gray-900">Ksh {{ number_format($totalExpenses, 2) }}</p>
                </div>

                <!-- Balance -->
                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)]">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="p-2 bg-blue-50 text-blue-600 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                        </div>
                        <p class="text-sm font-medium text-gray-500">Net Balance</p>
                    </div>
                    <p class="text-2xl font-bold {{ $balance >= 0 ? 'text-gray-900' : 'text-red-600' }}">
                        Ksh {{ number_format($balance, 2) }}
                    </p>
                </div>
            </div>

            <!-- Transactions List -->
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                @if($expenses->count() > 0)
                    <div class="divide-y divide-gray-50">
                        @foreach($expenses as $expense)
                            <div class="group flex flex-col sm:flex-row sm:items-center justify-between p-5 hover:bg-gray-50 transition duration-150 ease-in-out">
                                
                                <!-- Icon & Info -->
                                <div class="flex items-center gap-4">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center border
                                        {{ $expense->type === 'income' ? 'bg-green-50 border-green-100 text-green-600' : 'bg-white border-gray-200 text-gray-500' }}">
                                        @if($expense->type === 'income')
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                        @else
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-gray-900">{{ $expense->name }}</p>
                                        <div class="flex items-center gap-2 mt-0.5">
                                            <span class="text-xs font-medium px-2 py-0.5 rounded-full bg-gray-100 text-gray-600">
                                                {{ $expense->category }}
                                            </span>
                                            <span class="text-xs text-gray-400">
                                                {{ $expense->date->format('M d, Y') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Amount & Actions -->
                                <div class="flex items-center justify-between sm:justify-end gap-6 mt-4 sm:mt-0 w-full sm:w-auto">
                                    <p class="font-mono text-base font-bold {{ $expense->type === 'income' ? 'text-green-600' : 'text-gray-900' }}">
                                        {{ $expense->type === 'income' ? '+' : '-' }} Ksh {{ number_format($expense->amount, 2) }}
                                    </p>
                                    
                                    <div class="flex gap-1 opacity-100 sm:opacity-0 sm:group-hover:opacity-100 transition-opacity">
                                        <a href="{{ route('expenses.edit', $expense) }}" 
                                           class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                            </svg>
                                        </a>
                                        
                                        <form method="POST" action="{{ route('expenses.destroy', $expense) }}" 
                                              onsubmit="return confirm('Delete this transaction? This cannot be undone.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Delete">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if($expenses->hasPages())
                        <div class="bg-gray-50 px-5 py-4 border-t border-gray-100">
                            {{ $expenses->links() }}
                        </div>
                    @endif
                @else
                    <!-- Empty State -->
                    <div class="flex flex-col items-center justify-center py-16 px-4 text-center">
                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">No transactions yet</h3>
                        <p class="text-gray-500 max-w-sm mt-1 mb-6">Start tracking your financial journey by adding your first income or expense.</p>
                        <a href="{{ route('expenses.create') }}" 
                           class="inline-flex items-center gap-2 bg-gray-900 text-white px-5 py-2.5 rounded-lg text-sm font-medium hover:bg-gray-800 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Add Transaction
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>