<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Analytics') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Page Header -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">Performance Insights</h3>
                    <p class="text-gray-500 text-sm mt-1">Visualize your financial health and habit consistency.</p>
                </div>
                <!-- Date Range Indicator (Static for now, but looks good) -->
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm text-gray-600 shadow-sm">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Last 6 Months
                </div>
            </div>

            <!-- SECTION 1: Budget Analytics -->
            <div class="bg-white rounded-xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900">Financial Overview</h3>
                </div>
                
                <div class="p-6">
                    <!-- 1.1 Summary Stats Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        @php
                            $totalIncome = Auth::user()->expenses()->where('type', 'income')->sum('amount');
                            $totalExpenses = Auth::user()->expenses()->where('type', 'expense')->sum('amount');
                            $balance = $totalIncome - $totalExpenses;
                            $avgMonthlyExpense = count($last6Months) > 0 
                                ? collect($last6Months)->avg('expenses') 
                                : 0;
                        @endphp

                        <!-- Income -->
                        <div class="p-4 rounded-xl bg-gray-50/50 border border-gray-100">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="p-2 bg-green-100 text-green-600 rounded-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path></svg>
                                </div>
                                <span class="text-sm font-medium text-gray-500">Total Income</span>
                            </div>
                            <p class="text-2xl font-bold text-gray-900">Ksh {{ number_format($totalIncome) }}</p>
                        </div>

                        <!-- Expenses -->
                        <div class="p-4 rounded-xl bg-gray-50/50 border border-gray-100">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="p-2 bg-red-100 text-red-600 rounded-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path></svg>
                                </div>
                                <span class="text-sm font-medium text-gray-500">Total Expenses</span>
                            </div>
                            <p class="text-2xl font-bold text-gray-900">Ksh {{ number_format($totalExpenses) }}</p>
                        </div>

                        <!-- Net Balance -->
                        <div class="p-4 rounded-xl bg-gray-50/50 border border-gray-100">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="p-2 bg-blue-100 text-blue-600 rounded-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <span class="text-sm font-medium text-gray-500">Net Balance</span>
                            </div>
                            <p class="text-2xl font-bold {{ $balance >= 0 ? 'text-gray-900' : 'text-red-600' }}">
                                Ksh {{ number_format($balance) }}
                            </p>
                        </div>

                        <!-- Avg Monthly -->
                        <div class="p-4 rounded-xl bg-gray-50/50 border border-gray-100">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="p-2 bg-purple-100 text-purple-600 rounded-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 002 2h2a2 2 0 002-2z"></path></svg>
                                </div>
                                <span class="text-sm font-medium text-gray-500">Avg Monthly Out</span>
                            </div>
                            <p class="text-2xl font-bold text-gray-900">Ksh {{ number_format($avgMonthlyExpense) }}</p>
                        </div>
                    </div>

                    <!-- 1.2 Charts Grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Pie Chart -->
                        <div class="bg-white">
                            <h4 class="text-sm font-bold text-gray-900 mb-4">Spending by Category</h4>
                            <div class="relative h-64 w-full">
                                <canvas id="expensesByCategoryChart"></canvas>
                            </div>
                        </div>

                        <!-- Line Chart -->
                        <div class="bg-white">
                            <h4 class="text-sm font-bold text-gray-900 mb-4">Income vs Expenses</h4>
                            <div class="relative h-64 w-full">
                                <canvas id="incomeVsExpensesChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION 2: Habit Analytics -->
            <div class="bg-white rounded-xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900">Habit Consistency</h3>
                </div>

                <div class="p-6">
                    <!-- 2.1 Summary Stats -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8">
                        @php
                            $totalHabits = Auth::user()->habits()->where('is_active', true)->count();
                            $totalStreakDays = Auth::user()->habits()->sum('streak');
                            $longestStreak = Auth::user()->habits()->max('longest_streak');
                            $avgStreak = $totalHabits > 0 ? round($totalStreakDays / $totalHabits, 1) : 0;
                        @endphp

                        <div class="text-center p-4 border-r border-gray-100 last:border-0">
                            <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Active Habits</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalHabits }}</p>
                        </div>
                        <div class="text-center p-4 border-r border-gray-100 last:border-0">
                            <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Total Checks</p>
                            <p class="text-3xl font-bold text-orange-500 mt-2">{{ $totalStreakDays }}</p>
                        </div>
                        <div class="text-center p-4 border-r border-gray-100 last:border-0">
                            <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Best Streak</p>
                            <p class="text-3xl font-bold text-red-500 mt-2">{{ $longestStreak }}</p>
                        </div>
                        <div class="text-center p-4">
                            <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Avg Streak</p>
                            <p class="text-3xl font-bold text-blue-600 mt-2">{{ $avgStreak }}</p>
                        </div>
                    </div>

                    <!-- 2.2 Charts -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 border-t border-gray-50 pt-8">
                        <div>
                            <h4 class="text-sm font-bold text-gray-900 mb-4">Current vs Best Streaks</h4>
                            <div class="relative h-64 w-full">
                                <canvas id="habitStreaksChart"></canvas>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-sm font-bold text-gray-900 mb-4">Completion Rate (30 Days)</h4>
                            <div class="relative h-64 w-full">
                                <canvas id="completionRateChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION 3: Smart Insights -->
            <div>
                <h3 class="text-lg font-bold text-gray-900 mb-4">AI Suggestions & Insights</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    @php
                        $savingsRate = $totalIncome > 0 ? (($totalIncome - $totalExpenses) / $totalIncome) * 100 : 0;
                        $topCategory = $expensesByCategory->sortByDesc('total')->first();
                        $avgCompletionRate = collect($last30Days)->avg('completion_rate');
                    @endphp

                    <!-- Card 1: Savings -->
                    <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm border-l-4 {{ $savingsRate >= 20 ? 'border-l-green-500' : 'border-l-orange-400' }}">
                        <h4 class="text-xs font-bold text-gray-400 uppercase">Savings Rate</h4>
                        <div class="flex items-end gap-2 mt-2">
                            <span class="text-2xl font-bold text-gray-900">{{ number_format($savingsRate, 1) }}%</span>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">
                            @if($savingsRate >= 20)
                                Excellent! You are building wealth effectively.
                            @else
                                Aim for 20% to build a stronger safety net.
                            @endif
                        </p>
                    </div>

                    <!-- Card 2: Top Spend -->
                    <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm border-l-4 border-l-blue-500">
                        <h4 class="text-xs font-bold text-gray-400 uppercase">Top Expense</h4>
                        @if($topCategory)
                            <div class="mt-2">
                                <span class="text-xl font-bold text-gray-900">{{ $topCategory->category }}</span>
                                <p class="text-xs text-gray-500 mt-1">Ksh {{ number_format($topCategory->total) }} spent</p>
                            </div>
                        @else
                            <p class="text-sm text-gray-500 mt-2">No data yet.</p>
                        @endif
                    </div>

                    <!-- Card 3: Consistency -->
                    <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm border-l-4 {{ $avgCompletionRate >= 70 ? 'border-l-purple-500' : 'border-l-yellow-400' }}">
                        <h4 class="text-xs font-bold text-gray-400 uppercase">Consistency Score</h4>
                        <div class="flex items-end gap-2 mt-2">
                            <span class="text-2xl font-bold text-gray-900">{{ number_format($avgCompletionRate, 1) }}%</span>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">
                            @if($avgCompletionRate >= 70)
                                You're crushing your daily goals!
                            @else
                                Try to check in more regularly.
                            @endif
                        </p>
                    </div>

                    <!-- Card 4: Next Goal -->
                    <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm border-l-4 border-l-gray-800">
                        <h4 class="text-xs font-bold text-gray-400 uppercase">Recommended Goal</h4>
                        <p class="text-sm font-medium text-gray-900 mt-2">
                            @if($totalHabits == 0)
                                Create your first habit
                            @elseif($avgStreak < 7)
                                Hit a 7-day streak
                            @elseif($longestStreak < 30)
                                Reach 30 days unbroken
                            @else
                                Increase savings by 5%
                            @endif
                        </p>
                        <p class="text-xs text-gray-500 mt-1">Based on current performance.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Chart.js Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Common Options for Clean Look
        Chart.defaults.font.family = "'Inter', sans-serif";
        Chart.defaults.color = '#6b7280';
        Chart.defaults.scale.grid.color = '#f3f4f6';
        
        // 1. Pie Chart
        const categoryCtx = document.getElementById('expensesByCategoryChart');
        if (categoryCtx) {
            new Chart(categoryCtx, {
                type: 'doughnut',
                data: {
                    labels: @json($expensesByCategory->pluck('category')),
                    datasets: [{
                        data: @json($expensesByCategory->pluck('total')),
                        backgroundColor: ['#111827', '#4b5563', '#9ca3af', '#d1d5db', '#3b82f6', '#ef4444', '#10b981', '#f59e0b'],
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'right', labels: { usePointStyle: true, boxWidth: 6 } }
                    },
                    cutout: '70%',
                }
            });
        }

        // 2. Line Chart (Income/Expense)
        const incomeCtx = document.getElementById('incomeVsExpensesChart');
        if (incomeCtx) {
            new Chart(incomeCtx, {
                type: 'line',
                data: {
                    labels: @json(collect($last6Months)->pluck('month')),
                    datasets: [
                        {
                            label: 'Income',
                            data: @json(collect($last6Months)->pluck('income')),
                            borderColor: '#10b981', // Green
                            backgroundColor: 'rgba(16, 185, 129, 0.05)',
                            borderWidth: 2,
                            tension: 0.3,
                            fill: true,
                            pointRadius: 0,
                            pointHoverRadius: 4
                        },
                        {
                            label: 'Expenses',
                            data: @json(collect($last6Months)->pluck('expenses')),
                            borderColor: '#111827', // Black (Gray-900)
                            backgroundColor: 'rgba(17, 24, 39, 0.05)',
                            borderWidth: 2,
                            tension: 0.3,
                            fill: true,
                            pointRadius: 0,
                            pointHoverRadius: 4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    plugins: { legend: { position: 'top', align: 'end', labels: { usePointStyle: true, boxWidth: 6 } } },
                    scales: { y: { beginAtZero: true, grid: { borderDash: [2, 4] } }, x: { grid: { display: false } } }
                }
            });
        }

        // 3. Bar Chart (Habits)
        const habitCtx = document.getElementById('habitStreaksChart');
        if (habitCtx) {
            new Chart(habitCtx, {
                type: 'bar',
                data: {
                    labels: @json(collect($habitProgress)->pluck('name')),
                    datasets: [
                        {
                            label: 'Current',
                            data: @json(collect($habitProgress)->pluck('current_streak')),
                            backgroundColor: '#111827',
                            borderRadius: 4
                        },
                        {
                            label: 'Best',
                            data: @json(collect($habitProgress)->pluck('longest_streak')),
                            backgroundColor: '#e5e7eb',
                            borderRadius: 4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true, grid: { borderDash: [2, 4] } }, x: { grid: { display: false } } }
                }
            });
        }

        // 4. Line Chart (Completion)
        const rateCtx = document.getElementById('completionRateChart');
        if (rateCtx) {
            new Chart(rateCtx, {
                type: 'line',
                data: {
                    labels: @json(collect($last30Days)->pluck('date')),
                    datasets: [{
                        label: 'Rate',
                        data: @json(collect($last30Days)->pluck('completion_rate')),
                        borderColor: '#8b5cf6', // Purple
                        borderWidth: 2,
                        tension: 0.1,
                        pointRadius: 0,
                        pointHoverRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: { 
                        y: { beginAtZero: true, max: 100, grid: { borderDash: [2, 4] } },
                        x: { display: false } // Hide x labels for cleaner look on daily data
                    }
                }
            });
        }
    </script>
</x-app-layout>