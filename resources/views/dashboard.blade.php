<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Demo Mode Banner -->
            @if(auth()->user()->is_demo)
                <div class="bg-gradient-to-br from-yellow-400 to-orange-500 rounded-xl shadow-lg p-6 mb-8 text-white relative overflow-hidden">
                    <!-- Decorative background circle -->
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                    
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 relative z-10">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 md:w-16 md:h-16 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm shrink-0">
                                <svg class="w-6 h-6 md:w-8 md:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg md:text-xl font-bold">Demo Mode Active</h3>
                                <p class="text-white/90 text-sm md:text-base" id="demo-timer">
                                    Time remaining: <span class="font-bold bg-white/20 px-2 py-0.5 rounded text-white">{{ number_format(auth()->user()->getDemoTimeRemaining(), 2) }} min
</span>
                                </p>
                            </div>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                            <button onclick="document.getElementById('convert-modal').classList.remove('hidden')"
                                    class="text-center bg-white text-orange-600 px-6 py-2.5 rounded-lg font-semibold hover:bg-orange-50 transition shadow-sm">
                                Keep My Data
                            </button>
                            <form method="POST" action="{{ route('demo.end') }}" class="w-full md:w-auto">
                                @csrf
                                <button type="submit" 
                                        class="w-full text-center bg-black/20 backdrop-blur-sm text-white px-6 py-2.5 rounded-lg font-semibold hover:bg-black/30 transition border border-white/10">
                                    End Demo
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Welcome & Actions Section -->
            <div class="mb-8 flex flex-col md:flex-row md:items-end md:justify-between gap-6">
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">Welcome back, {{ auth()->user()->name }}</h3>
                    <p class="text-gray-500 mt-1">Here's what's happening in your life today.</p>
                </div>
                
                <!-- Quick Actions -->
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('expenses.index') }}" class="group inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-700 hover:border-gray-300 hover:text-gray-900 hover:bg-gray-50 transition shadow-sm">
                        <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Add Expense
                    </a>
                    <a href="{{ route('habits.index') }}" class="group inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-700 hover:border-gray-300 hover:text-gray-900 hover:bg-gray-50 transition shadow-sm">
                        <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Check-in Habit
                    </a>
                    <a href="{{ route('meals.index') }}" class="group inline-flex items-center gap-2 px-4 py-2.5 bg-gray-900 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-gray-800 transition shadow-sm">
                        <svg class="w-4 h-4 text-gray-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        Plan Meal
                    </a>
                </div>
            </div>

            <!-- Stats Overview Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                
                <!-- Card 1: Budget -->
                @php
                    $totalIncome = auth()->user()->expenses()->where('type', 'income')->sum('amount');
                    $totalExpenses = auth()->user()->expenses()->where('type', 'expense')->sum('amount');
                    $balance = $totalIncome - $totalExpenses;
                @endphp
                <div class="bg-white p-6 rounded-xl border border-gray-200/60 shadow-sm hover:shadow-md transition duration-200">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wide">Total Balance</h4>
                        <div class="p-2.5 bg-blue-50 text-blue-600 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                    <p class="text-2xl font-bold text-gray-900 tracking-tight">Ksh {{ number_format($balance) }}</p>
                    <div class="mt-4 flex items-center justify-between text-xs font-medium">
                        <div class="flex items-center gap-1 text-green-700 bg-green-50 px-2.5 py-1 rounded-md">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                            {{ number_format($totalIncome) }}
                        </div>
                        <div class="flex items-center gap-1 text-red-700 bg-red-50 px-2.5 py-1 rounded-md">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                            {{ number_format($totalExpenses) }}
                        </div>
                    </div>
                </div>
                
                <!-- Card 2: Habits -->
                @php
                    $activeHabits = auth()->user()->habits()->where('is_active', true)->count();
                    $longestStreak = auth()->user()->habits()->max('longest_streak');
                @endphp
                <div class="bg-white p-6 rounded-xl border border-gray-200/60 shadow-sm hover:shadow-md transition duration-200">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wide">Active Habits</h4>
                        <div class="p-2.5 bg-purple-50 text-purple-600 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                    </div>
                    <p class="text-2xl font-bold text-gray-900 tracking-tight">{{ $activeHabits }}</p>
                    <div class="mt-4 flex items-center gap-2 text-xs">
                        <span class="text-gray-500">Best Streak:</span>
                        <span class="font-semibold text-gray-900">{{ $longestStreak ?? 0 }} days 🔥</span>
                    </div>
                </div>
                
                <!-- Card 3: Meals -->
                @php
                    $mealsThisWeek = auth()->user()->meals()
                        ->whereBetween('date', [now()->startOfWeek(), now()->endOfWeek()])
                        ->count();
                    $mealsToday = auth()->user()->meals()
                        ->whereDate('date', today())
                        ->count();
                    $mealProgress = min(($mealsThisWeek / 21) * 100, 100);
                @endphp
                <div class="bg-white p-6 rounded-xl border border-gray-200/60 shadow-sm hover:shadow-md transition duration-200">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wide">Weekly Meals</h4>
                        <div class="p-2.5 bg-orange-50 text-orange-600 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    </div>
                    <p class="text-2xl font-bold text-gray-900 tracking-tight">{{ $mealsThisWeek }} <span class="text-sm font-normal text-gray-400">/ 21</span></p>
                    <div class="mt-4 w-full bg-gray-100 rounded-full h-2">
                        <div class="bg-orange-500 h-2 rounded-full transition-all duration-500" style="width: {{ $mealProgress }}%"></div>
                    </div>
                    <p class="mt-2 text-xs text-gray-500">Today: <span class="font-medium text-gray-700">{{ $mealsToday }} planned</span></p>
                </div>

                <!-- Card 4: Bills -->
                @php
                    $activeBills = auth()->user()->bills()->where('is_active', true)->get();
                    $totalOwed = $activeBills->sum(function($bill) {
                        return $bill->total_amount - $bill->paid_amount;
                    });
                @endphp
                <div class="bg-white p-6 rounded-xl border border-gray-200/60 shadow-sm hover:shadow-md transition duration-200">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wide">Outstanding Bills</h4>
                        <div class="p-2.5 bg-red-50 text-red-600 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                    </div>
                    <p class="text-2xl font-bold text-gray-900 tracking-tight">{{ $activeBills->count() }} <span class="text-sm font-normal text-gray-400">active</span></p>
                    <p class="mt-4 text-xs font-medium text-gray-500">
                        Total Owed: <span class="text-gray-900 font-bold">Ksh {{ number_format($totalOwed) }}</span>
                    </p>
                </div>
            </div>

            <!-- Content Split -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                
                <!-- Left Column -->
                <div class="space-y-8">
                    
                    <!-- Recent Expenses -->
                    <div class="bg-white rounded-xl border border-gray-200/60 shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                            <h4 class="font-bold text-gray-800">Recent Transactions</h4>
                            <a href="{{ route('expenses.index') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-800 transition">View All</a>
                        </div>
                        <div class="divide-y divide-gray-50">
                            @forelse(auth()->user()->expenses()->latest()->take(5)->get() as $expense)
                                <div class="p-4 flex justify-between items-center hover:bg-gray-50 transition group cursor-default">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0 {{ $expense->type === 'income' ? 'bg-green-50 text-green-600' : 'bg-gray-100 text-gray-600' }}">
                                            @if($expense->type === 'income')
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path></svg>
                                            @else
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path></svg>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-900">{{ $expense->name }}</p>
                                            <p class="text-xs text-gray-500 mt-0.5">{{ $expense->date->format('M d') }} • {{ $expense->category }}</p>
                                        </div>
                                    </div>
                                    <span class="text-sm font-bold whitespace-nowrap {{ $expense->type === 'income' ? 'text-green-600' : 'text-gray-900' }}">
                                        {{ $expense->type === 'income' ? '+' : '-' }} Ksh {{ number_format($expense->amount) }}
                                    </span>
                                </div>
                            @empty
                                <div class="p-12 text-center">
                                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gray-100 mb-3">
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <p class="text-gray-500 text-sm">No recent transactions recorded.</p>
                                </div>
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
                        <div class="bg-white rounded-xl border border-gray-200/60 shadow-sm overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                                <h4 class="font-bold text-gray-800 flex items-center gap-2">
                                    Due Soon
                                    <span class="bg-red-100 text-red-700 text-[10px] px-2 py-0.5 rounded-full uppercase tracking-wide">Action Required</span>
                                </h4>
                            </div>
                            <div class="divide-y divide-gray-50">
                                @foreach($upcomingBills as $bill)
                                    <div class="p-4 flex justify-between items-center group hover:bg-red-50/20 transition">
                                        <div>
                                            <p class="text-sm font-semibold text-gray-900">{{ $bill->name }}</p>
                                            <div class="flex items-center gap-2 mt-1">
                                                <span class="text-xs text-gray-500">Due <span class="{{ $bill->is_overdue ? 'text-red-600 font-bold' : '' }}">{{ $bill->next_due_date->format('M d') }}</span></span>
                                                @if($bill->is_overdue)
                                                    <span class="px-1.5 py-0.5 rounded text-[10px] font-bold bg-red-100 text-red-600">OVERDUE</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-4">
                                            <span class="text-sm font-bold text-gray-900">Ksh {{ number_format($bill->installment_amount) }}</span>
                                            <!-- UX Fix: Button visible by default on mobile, opacity on desktop -->
                                            <a href="{{ route('bills.show', $bill) }}" class="opacity-100 lg:opacity-0 lg:group-hover:opacity-100 transition px-3 py-1.5 text-xs font-semibold bg-gray-900 text-white rounded-md hover:bg-gray-800 focus:opacity-100">Pay</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Right Column (Habits) -->
                <div>
                    <div class="bg-white rounded-xl border border-gray-200/60 shadow-sm overflow-hidden h-full flex flex-col">
                        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                            <h4 class="font-bold text-gray-800">Habit Tracker</h4>
                            <a href="{{ route('habits.index') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-800 transition">Manage</a>
                        </div>
                        <div class="p-4 flex-1">
                            @forelse(auth()->user()->habits()->where('is_active', true)->take(6)->get() as $habit)
                                <div class="p-3 mb-2 rounded-lg border border-gray-100 bg-white hover:border-blue-200 hover:bg-blue-50/20 transition flex justify-between items-center group">
                                    <div class="flex items-center gap-3">
                                        <div class="w-2.5 h-2.5 rounded-full {{ $habit->streak > 0 ? 'bg-green-500 ring-2 ring-green-100' : 'bg-gray-300' }}"></div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-900">{{ $habit->name }}</p>
                                            <p class="text-[11px] text-gray-400 uppercase tracking-wider">{{ $habit->category ?? 'Daily' }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs font-medium text-gray-500">{{ $habit->streak }} day streak</span>
                                        <span class="text-lg opacity-75 group-hover:opacity-100 transition group-hover:scale-110">🔥</span>
                                    </div>
                                </div>
                            @empty
                                <div class="h-full flex flex-col items-center justify-center p-8 text-center">
                                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                    </div>
                                    <p class="text-gray-500 text-sm">No active habits tracked.</p>
                                    <a href="{{ route('habits.index') }}" class="mt-4 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition shadow-sm">Start a Habit</a>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <!-- Convert Demo Modal -->
    @if(auth()->user()->is_demo)
    <div id="convert-modal" 
         class="hidden fixed inset-0 z-50 overflow-y-auto"
         aria-labelledby="modal-title" 
         role="dialog" 
         aria-modal="true">
        
        <!-- Backdrop with blur -->
        <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity"></div>

        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md border border-gray-100">
                
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <div class="text-center">
                        <div class="mx-auto flex h-16 w-16 flex-shrink-0 items-center justify-center rounded-full bg-green-100 mb-4">
                            <svg class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold leading-6 text-gray-900" id="modal-title">Keep Your Data!</h3>
                        <p class="mt-2 text-sm text-gray-500">Create a permanent account to save your dashboard, expenses, and habits.</p>
                    </div>

                    <form method="POST" action="{{ route('demo.convert') }}" class="mt-6 space-y-4">
                        @csrf
                        <div>
                            <label for="convert_name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                            <input type="text" name="name" id="convert_name" required
                                   class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm"
                                   placeholder="John Doe">
                        </div>

                        <div>
                            <label for="convert_email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                            <input type="email" name="email" id="convert_email" required
                                   class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm"
                                   placeholder="you@example.com">
                        </div>

                        <div>
                            <label for="convert_password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                            <input type="password" name="password" id="convert_password" required
                                   class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm"
                                   placeholder="••••••••">
                        </div>

                        <div>
                            <label for="convert_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="convert_password_confirmation" required
                                   class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm"
                                   placeholder="••••••••">
                        </div>

                        <div class="mt-8 flex flex-col-reverse sm:flex-row gap-3">
                            <button type="button" 
                                    onclick="document.getElementById('convert-modal').classList.add('hidden')"
                                    class="inline-flex w-full justify-center rounded-lg bg-white px-3 py-2.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:w-auto sm:flex-1">
                                Cancel
                            </button>
                            <button type="submit" 
                                    class="inline-flex w-full justify-center rounded-lg bg-gray-900 px-3 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-gray-800 sm:w-auto sm:flex-1">
                                Create Account
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Auto-update timer -->
    <script>
        setInterval(function() {
            fetch('{{ route("demo.time-remaining") }}')
                .then(response => response.json())
                .then(data => {
                    const timerElement = document.querySelector('#demo-timer span');
                    if (timerElement) {
                        timerElement.textContent = data.minutes + ' min';
                    }
                    if (data.minutes <= 0) {
                        window.location.href = '{{ route("demo.end") }}';
                    }
                })
                .catch(error => console.error('Error:', error));
        }, 60000); 
    </script>
    @endif
</x-app-layout>