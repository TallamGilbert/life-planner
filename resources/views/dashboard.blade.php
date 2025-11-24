<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-4">Welcome back, {{ auth()->user()->name }} </h3>
                    
                    <!-- Dashboard Overview Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-6">
                        <!-- Budget Card -->
                        <div class="bg-blue-50 p-6 rounded-lg border border-blue-200">
                            <div class="flex items-center justify-between">
                                <h4 class="text-lg font-semibold text-blue-900">Budget</h4>
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            @php
                                $totalIncome = auth()->user()->expenses()->where('type', 'income')->sum('amount');
                                $totalExpenses = auth()->user()->expenses()->where('type', 'expense')->sum('amount');
                                $balance = $totalIncome - $totalExpenses;
                            @endphp
                            <p class="text-3xl font-bold text-blue-600 mt-2">Ksh {{ number_format($balance, 2) }}</p>
                            <p class="text-sm text-gray-600 mt-2">Current balance</p>
                            <div class="mt-3 pt-3 border-t border-blue-200">
                                <p class="text-xs text-gray-500">
                                    <span class="text-green-600 font-semibold">↑ Ksh {{ number_format($totalIncome, 2) }}</span> Income
                                </p>
                                <p class="text-xs text-gray-500">
                                    <span class="text-red-600 font-semibold">↓ Ksh {{ number_format($totalExpenses, 2) }}</span> Expenses
                                </p>
                            </div>
                        </div>
                        
                        <!-- Streaks Card -->
                        <div class="bg-green-50 p-6 rounded-lg border border-green-200">
                            <div class="flex items-center justify-between">
                                <h4 class="text-lg font-semibold text-green-900">Active Streaks</h4>
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                </svg>
                            </div>
                            @php
                                $activeHabits = auth()->user()->habits()->where('is_active', true)->count();
                                $totalStreak = auth()->user()->habits()->sum('streak');
                                $longestStreak = auth()->user()->habits()->max('longest_streak');
                            @endphp
                            <p class="text-3xl font-bold text-green-600 mt-2">{{ $activeHabits }}</p>
                            <p class="text-sm text-gray-600 mt-2">Active habits</p>
                            <div class="mt-3 pt-3 border-t border-green-200">
                                <p class="text-xs text-gray-500">
                                    Total streak days: <span class="font-semibold">{{ $totalStreak }}</span>
                                </p>
                                <p class="text-xs text-gray-500">
                                    Longest streak: <span class="font-semibold">{{ $longestStreak }} days 🔥</span>
                                </p>
                            </div>
                        </div>
                        
                        <!-- Meals Card -->
                        <div class="bg-purple-50 p-6 rounded-lg border border-purple-200">
                            <div class="flex items-center justify-between">
                                <h4 class="text-lg font-semibold text-purple-900">Meals Planned</h4>
                                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            @php
                                $mealsThisWeek = auth()->user()->meals()
                                    ->whereBetween('date', [now()->startOfWeek(), now()->endOfWeek()])
                                    ->count();
                                $mealsToday = auth()->user()->meals()
                                    ->whereDate('date', today())
                                    ->count();
                            @endphp
                            <p class="text-3xl font-bold text-purple-600 mt-2">{{ $mealsThisWeek }}</p>
                            <p class="text-sm text-gray-600 mt-2">This week</p>
                            <div class="mt-3 pt-3 border-t border-purple-200">
                                <p class="text-xs text-gray-500">
                                    Today: <span class="font-semibold">{{ $mealsToday }} meals</span>
                                </p>
                                <p class="text-xs text-gray-500">
                                    Remaining: <span class="font-semibold">{{ 21 - $mealsThisWeek }} slots</span>
                                </p>
                            </div>
                        </div>

                        <!-- Bills Card -->
                        <div class="bg-orange-50 p-6 rounded-lg border border-orange-200">
                            <div class="flex items-center justify-between">
                                <h4 class="text-lg font-semibold text-orange-900">Bills</h4>
                                <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            @php
                                $activeBills = auth()->user()->bills()->where('is_active', true)->get();
                                $activeBillsCount = $activeBills->count();
                                $totalOwed = $activeBills->sum(function($bill) {
                                    return $bill->total_amount - $bill->paid_amount;
                                });
                            @endphp
                            <p class="text-3xl font-bold text-orange-600 mt-2">{{ $activeBillsCount }}</p>
                            <p class="text-sm text-gray-600 mt-2">Active bills</p>
                            <div class="mt-3 pt-3 border-t border-orange-200">
                                <p class="text-xs text-gray-500">
                                    Total owed: <span class="font-semibold">Ksh {{ number_format($totalOwed, 2) }}</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    
                    
                    <!-- Quick Actions -->
                    <div class="mt-8">
                        <h4 class="text-lg font-semibold mb-4">Quick Actions</h4>
                        <div class="flex flex-wrap gap-4">
                                <a href="{{ route('expenses.index') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Add Expenses
                                </a>
                                <a href="{{ route('habits.index') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Check-in Habit
                                </a>
                            <a href="{{ route('meals.index') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Plan Meal
                            </a>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Recent Expenses -->
                        <div>
                            <h4 class="text-lg font-semibold mb-4">Recent Expenses</h4>
                            <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                                @forelse(auth()->user()->expenses()->latest()->take(5)->get() as $expense)
                                    <div class="flex justify-between items-center py-2 border-b last:border-b-0">
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $expense->name }}</p>
                                            <p class="text-sm text-gray-500">
                                                {{ $expense->category }} • {{ $expense->date->format('M d, Y') }}
                                            </p>
                                        </div>
                                        <p class="font-bold {{ $expense->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $expense->type === 'income' ? '+' : '-' }}Ksh {{ number_format($expense->amount, 2) }}
                                        </p>
                                    </div>
                                @empty
                                    <p class="text-gray-500 text-center py-4">No expenses yet. Add your first one!</p>
                                @endforelse
                            </div>
                        </div>

                        <!-- Active Habits -->
                        <div>
                            <h4 class="text-lg font-semibold mb-4">Your Habits</h4>
                            <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                                @forelse(auth()->user()->habits()->where('is_active', true)->take(5)->get() as $habit)
                                    <div class="flex justify-between items-center py-2 border-b last:border-b-0">
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $habit->name }}</p>
                                            <p class="text-sm text-gray-500">
                                                {{ $habit->category ?? 'General' }}
                                            </p>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-bold text-green-600">{{ $habit->streak }} days 🔥</p>
                                            <p class="text-xs text-gray-500">Best: {{ $habit->longest_streak }}</p>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-gray-500 text-center py-4">No habits yet. Create your first one!</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Upcoming Bill Payments -->
                    @php
                        $upcomingBills = auth()->user()->bills()
                            ->where('is_active', true)
                            ->where('next_due_date', '<=', now()->addDays(7))
                            ->orderBy('next_due_date')
                            ->take(3)
                            ->get();
                    @endphp

                    @if($upcomingBills->count() > 0)
                        <div class="mt-8">
                            <div class="flex justify-between items-center mb-4">
                                <h4 class="text-lg font-semibold">Upcoming Bill Payments</h4>
                                <a href="{{ route('bills.index') }}" class="text-sm text-blue-600 hover:text-blue-800">
                                    View All →
                                </a>
                            </div>
                            <div class="bg-white rounded-lg shadow-sm p-4">
                                @foreach($upcomingBills as $bill)
                                    <div class="flex justify-between items-center py-3 border-b last:border-b-0">
                                        <div class="flex-1">
                                            <p class="font-medium text-gray-900">{{ $bill->name }}</p>
                                            <p class="text-sm text-gray-500">
                                                Ksh {{ number_format($bill->installment_amount, 2) }} • 
                                                Due {{ $bill->next_due_date->format('M d') }}
                                                @if($bill->is_overdue)
                                                    <span class="text-red-600 font-semibold">• OVERDUE</span>
                                                @endif
                                            </p>
                                        </div>
                                        <a href="{{ route('bills.show', $bill) }}" 
                                           class="px-3 py-1 text-sm bg-blue-600 text-white rounded hover:bg-blue-700">
                                            Pay
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif



                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>