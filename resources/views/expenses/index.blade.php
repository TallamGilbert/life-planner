<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Transactions') }}
            </h2>
            <a href="{{ route('expenses.create') }}" 
               class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                + Add Transaction
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                @php
                    $totalIncome = auth()->user()->expenses()->where('type', 'income')->sum('amount');
                    $totalExpenses = auth()->user()->expenses()->where('type', 'expense')->sum('amount');
                    $balance = $totalIncome - $totalExpenses;
                @endphp

                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <p class="text-sm text-gray-600">Total Income</p>
                    <p class="text-2xl font-bold text-green-600">Ksh {{ number_format($totalIncome, 2) }}</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <p class="text-sm text-gray-600">Total Expenses</p>
                    <p class="text-2xl font-bold text-red-600">Ksh {{ number_format($totalExpenses, 2) }}</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <p class="text-sm text-gray-600">Balance</p>
                    <p class="text-2xl font-bold {{ $balance >= 0 ? 'text-blue-600' : 'text-red-600' }}">
                        Ksh {{ number_format($balance, 2) }}
                    </p>
                </div>
            </div>

            <!-- Transactions List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($expenses->count() > 0)
                        <div class="space-y-3">
                            @foreach($expenses as $expense)
                                <div class="flex items-center justify-between p-4 border rounded-lg hover:bg-gray-50 transition">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full flex items-center justify-center
                                                {{ $expense->type === 'income' ? 'bg-green-100' : 'bg-red-100' }}">
                                                @if($expense->type === 'income')
                                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                                                    </svg>
                                                @else
                                                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                                    </svg>
                                                @endif
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-900">{{ $expense->name }}</p>
                                                <p class="text-sm text-gray-500">
                                                    {{ $expense->category }} • {{ $expense->date->format('M d, Y') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center gap-4">
                                        <p class="text-lg font-bold {{ $expense->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $expense->type === 'income' ? '+' : '-' }}Ksh {{ number_format($expense->amount, 2) }}
                                        </p>
                                        
                                        <div class="flex gap-2">
                                            <a href="{{ route('expenses.edit', $expense) }}" 
                                               class="text-blue-600 hover:text-blue-800">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>
                                            
                                            <form method="POST" action="{{ route('expenses.destroy', $expense) }}" 
                                                  onsubmit="return confirm('Are you sure you want to delete this transaction?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                        <div class="mt-6">
                            {{ $expenses->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="mt-4 text-gray-600">No transactions yet</p>
                            <a href="{{ route('expenses.create') }}" 
                               class="mt-4 inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                                Add Your First Transaction
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>