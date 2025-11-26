<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50/50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Welcome Section -->
            <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">Welcome back, {{ auth()->user()->name }}</h3>
                    <p class="text-gray-500 text-sm mt-1">Here's what's happening with your life today.</p>
                </div>
                
                <!-- Quick Actions (Pill Buttons) -->
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('expenses.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-black transition shadow-sm">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Add Expense
                    </a>
                    <a href="{{ route('habits.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-black transition shadow-sm">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Check-in Habit
                    </a>
                    <a href="{{ route('meals.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-900 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-gray-800 transition shadow-sm">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        Plan Meal
                    </a>
                </div>
            </div>

            <!-- Dashboard Overview Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                
                <!-- Budget Card -->
                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] hover:shadow-md transition duration-200">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-sm font-medium text-gray-500">Total Balance</h4>
                        <div class="p-2 bg-gray-50 rounded-lg">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                    @php
                        $totalIncome = auth()->user()->expenses()->where('type', 'income')->sum('amount');
                        $totalExpenses = auth()->user()->expenses()->where('type', 'expense')->sum('amount');
                        $balance = $totalIncome - $totalExpenses;
                    @endphp
                    <p class="text-2xl font-bold text-gray-900">Ksh {{ number_format($balance, 2) }}</p>
                    <div class="mt-4 flex items-center justify-between text-xs">
                        <span class="text-green-600 bg-green-50 px-2 py-1 rounded-md font-medium">+{{ number_format($totalIncome) }}</span>
                        <span class="text-red-600 bg-red-50 px-2 py-1 rounded-md font-medium">-{{ number_format($totalExpenses) }}</span>
                    </div>
                </div>
                
                <!-- Streaks Card -->
                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] hover:shadow-md transition duration-200">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-sm font-medium text-gray-500">Active Habits</h4>
                        <div class="p-2 bg-gray-50 rounded-lg">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                    </div>
                    @php
                        $activeHabits = auth()->user()->habits()->where('is_active', true)->count();
                        $longestStreak = auth()->user()->habits()->max('longest_streak');
                    @endphp
                    <p class="text-2xl font-bold text-gray-900">{{ $activeHabits }} <span class="text-sm font-normal text-gray-400">habits</span></p>
                    <div class="mt-4 text-xs text-gray-500">
                        Best streak: <span class="font-semibold text-gray-700">{{ $longestStreak ?? 0 }} days</span>
                    </div>
                </div>
                
                <!-- Meals Card -->
                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] hover:shadow-md transition duration-200">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-sm font-medium text-gray-500">Meals This Week</h4>
                        <div class="p-2 bg-gray-50 rounded-lg">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    </div>
                    @php
                        $mealsThisWeek = auth()->user()->meals()
                            ->whereBetween('date', [now()->startOfWeek(), now()->endOfWeek()])
                            ->count();
                        $mealsToday = auth()->user()->meals()
                            ->whereDate('date', today())
                            ->count();
                    @endphp
                    <p class="text-2xl font-bold text-gray-900">{{ $mealsThisWeek }} <span class="text-sm font-normal text-gray-400">/ 21</span></p>
                    <div class="mt-4 w-full bg-gray-100 rounded-full h-1.5">
                        <div class="bg-gray-900 h-1.5 rounded-full" style="width: {{ ($mealsThisWeek / 21) * 100 }}%"></div>
                    </div>
                    <p class="mt-2 text-xs text-gray-500">Today: {{ $mealsToday }} meals planned</p>
                </div>

                <!-- Bills Card -->
                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] hover:shadow-md transition duration-200">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-sm font-medium text-gray-500">Outstanding Bills</h4>
                        <div class="p-2 bg-gray-50 rounded-lg">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                    </div>
                    @php
                        $activeBills = auth()->user()->bills()->where('is_active', true)->get();
                        $totalOwed = $activeBills->sum(function($bill) {
                            return $bill->total_amount - $bill->paid_amount;
                        });
                    @endphp
                    <p class="text-2xl font-bold text-gray-900">{{ $activeBills->count() }} <span class="text-sm font-normal text-gray-400">active</span></p>
                    <p class="mt-4 text-xs font-medium text-gray-500">
                        Total owed: <span class="text-gray-900">Ksh {{ number_format($totalOwed) }}</span>
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Left Column -->
                <div class="space-y-8">
                    
                    <!-- Recent Expenses -->
                    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                            <h4 class="font-bold text-gray-800">Recent Transactions</h4>
                            <a href="{{ route('expenses.index') }}" class="text-xs font-medium text-gray-500 hover:text-gray-900">View All</a>
                        </div>
                        <div class="divide-y divide-gray-50">
                            @forelse(auth()->user()->expenses()->latest()->take(5)->get() as $expense)
                                <div class="p-4 flex justify-between items-center hover:bg-gray-50 transition">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full flex items-center justify-center {{ $expense->type === 'income' ? 'bg-green-100 text-green-600' : 'bg-gray-100 text-gray-600' }}">
                                            @if($expense->type === 'income')
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path></svg>
                                            @else
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path></svg>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $expense->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $expense->date->format('M d') }} • {{ $expense->category }}</p>
                                        </div>
                                    </div>
                                    <span class="text-sm font-semibold {{ $expense->type === 'income' ? 'text-green-600' : 'text-gray-900' }}">
                                        {{ $expense->type === 'income' ? '+' : '-' }}Ksh {{ number_format($expense->amount) }}
                                    </span>
                                </div>
                            @empty
                                <div class="p-8 text-center text-gray-400 text-sm">No recent activity.</div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Upcoming Bills -->
                    @php
                        $upcomingBills = auth()->user()->bills()
                            ->where('is_active', true)
                            ->where('next_due_date', '<=', now()->addDays(7))
                            ->orderBy('next_due_date')
                            ->take(3)
                            ->get();
                    @endphp
                    @if($upcomingBills->count() > 0)
                        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                            <div class="p-6 border-b border-gray-100">
                                <h4 class="font-bold text-gray-800">Due Soon</h4>
                            </div>
                            <div class="divide-y divide-gray-50">
                                @foreach($upcomingBills as $bill)
                                    <div class="p-4 flex justify-between items-center group hover:bg-red-50/30 transition">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $bill->name }}</p>
                                            <div class="flex items-center gap-2 mt-1">
                                                <span class="text-xs text-gray-500">Due {{ $bill->next_due_date->format('M d') }}</span>
                                                @if($bill->is_overdue)
                                                    <span class="px-1.5 py-0.5 rounded text-[10px] font-bold bg-red-100 text-red-600">OVERDUE</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <span class="text-sm font-medium text-gray-900">Ksh {{ number_format($bill->installment_amount) }}</span>
                                            <a href="{{ route('bills.show', $bill) }}" class="opacity-0 group-hover:opacity-100 transition px-3 py-1 text-xs bg-gray-900 text-white rounded hover:bg-gray-800">Pay</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Right Column (Habits) -->
                <div>
                    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden h-full">
                        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                            <h4 class="font-bold text-gray-800">Habit Tracker</h4>
                            <a href="{{ route('habits.index') }}" class="text-xs font-medium text-gray-500 hover:text-gray-900">Manage</a>
                        </div>
                        <div class="p-2">
                            @forelse(auth()->user()->habits()->where('is_active', true)->take(6)->get() as $habit)
                                <div class="p-4 mb-2 rounded-lg border border-gray-100 hover:border-blue-200 hover:bg-blue-50/30 transition flex justify-between items-center">
                                    <div class="flex items-center gap-3">
                                        <div class="w-2 h-2 rounded-full {{ $habit->streak > 0 ? 'bg-green-500' : 'bg-gray-300' }}"></div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $habit->name }}</p>
                                            <p class="text-xs text-gray-400">{{ $habit->category ?? 'Daily' }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs font-medium text-gray-500">{{ $habit->streak }} day streak</span>
                                        <span class="text-lg">🔥</span>
                                    </div>
                                </div>
                            @empty
                                <div class="p-8 text-center text-gray-400 text-sm">
                                    No habits tracked yet.
                                    <br>
                                    <a href="{{ route('habits.index') }}" class="text-blue-600 hover:underline mt-2 inline-block">Start your first habit</a>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>