

<x-app-layout>
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Analytics & Insights') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Budget Analytics Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                        <span></span> Budget Analytics
                    </h3>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Spending by Category (Pie Chart) -->
                        <div>
                            <h4 class="text-sm font-medium text-gray-700 mb-3">Spending by Category</h4>
                            <div class="bg-gray-50 rounded-lg p-4" style="height: 300px;">
                                <canvas id="expensesByCategoryChart"></canvas>
                            </div>
                        </div>

                        <!-- Income vs Expenses (Line Chart) -->
                        <div>
                            <h4 class="text-sm font-medium text-gray-700 mb-3">Income vs Expenses (Last 6 Months)</h4>
                            <div class="bg-gray-50 rounded-lg p-4" style="height: 300px;">
                                <canvas id="incomeVsExpensesChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Summary Stats -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6">
                        @php
                            $totalIncome = Auth::user()->expenses()->where('type', 'income')->sum('amount');
                            $totalExpenses = Auth::user()->expenses()->where('type', 'expense')->sum('amount');
                            $balance = $totalIncome - $totalExpenses;
                            $avgMonthlyExpense = count($last6Months) > 0 
                                ? collect($last6Months)->avg('expenses') 
                                : 0;
                        @endphp

                        <div class="bg-green-50 p-4 rounded-lg">
                            <p class="text-xs text-green-600 font-medium">Total Income</p>
                            <p class="text-2xl font-bold text-green-700">Ksh {{ number_format($totalIncome, 2) }}</p>
                        </div>

                        <div class="bg-red-50 p-4 rounded-lg">
                            <p class="text-xs text-red-600 font-medium">Total Expenses</p>
                            <p class="text-2xl font-bold text-red-700">Ksh {{ number_format($totalExpenses, 2) }}</p>
                        </div>

                        <div class="bg-blue-50 p-4 rounded-lg">
                            <p class="text-xs text-blue-600 font-medium">Net Balance</p>
                            <p class="text-2xl font-bold {{ $balance >= 0 ? 'text-blue-700' : 'text-red-700' }}">
                                Ksh {{ number_format($balance, 2) }}
                            </p>
                        </div>

                        <div class="bg-purple-50 p-4 rounded-lg">
                            <p class="text-xs text-purple-600 font-medium">Avg Monthly Spending</p>
                            <p class="text-2xl font-bold text-purple-700">Ksh {{ number_format($avgMonthlyExpense, 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Habit Analytics Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                        <span></span> Habit Analytics
                    </h3>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Habit Streaks (Bar Chart) -->
                        <div>
                            <h4 class="text-sm font-medium text-gray-700 mb-3">Current vs Best Streaks</h4>
                            <div class="bg-gray-50 rounded-lg p-4" style="height: 300px;">
                                <canvas id="habitStreaksChart"></canvas>
                            </div>
                        </div>

                        <!-- Completion Rate (Line Chart) -->
                        <div>
                            <h4 class="text-sm font-medium text-gray-700 mb-3">Daily Completion Rate (Last 30 Days)</h4>
                            <div class="bg-gray-50 rounded-lg p-4" style="height: 300px;">
                                <canvas id="completionRateChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Habit Summary -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6">
                        @php
                            $totalHabits = Auth::user()->habits()->where('is_active', true)->count();
                            $totalStreakDays = Auth::user()->habits()->sum('streak');
                            $longestStreak = Auth::user()->habits()->max('longest_streak');
                            $avgStreak = $totalHabits > 0 ? round($totalStreakDays / $totalHabits, 1) : 0;
                        @endphp

                        <div class="bg-green-50 p-4 rounded-lg">
                            <p class="text-xs text-green-600 font-medium">Active Habits</p>
                            <p class="text-2xl font-bold text-green-700">{{ $totalHabits }}</p>
                        </div>

                        <div class="bg-orange-50 p-4 rounded-lg">
                            <p class="text-xs text-orange-600 font-medium">Total Streak Days</p>
                            <p class="text-2xl font-bold text-orange-700">{{ $totalStreakDays }}</p>
                        </div>

                        <div class="bg-red-50 p-4 rounded-lg">
                            <p class="text-xs text-red-600 font-medium">Best Streak</p>
                            <p class="text-2xl font-bold text-red-700">{{ $longestStreak }} 🔥</p>
                        </div>

                        <div class="bg-blue-50 p-4 rounded-lg">
                            <p class="text-xs text-blue-600 font-medium">Avg Streak</p>
                            <p class="text-2xl font-bold text-blue-700">{{ $avgStreak }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Insights & Tips -->
            <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                    <span>💡</span> Insights & Tips
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @php
                        $savingsRate = $totalIncome > 0 ? (($totalIncome - $totalExpenses) / $totalIncome) * 100 : 0;
                        $topCategory = $expensesByCategory->sortByDesc('total')->first();
                    @endphp

                    <div class="bg-white rounded-lg p-4">
                        <h4 class="font-semibold text-gray-900 mb-2">💰 Savings Rate</h4>
                        <p class="text-3xl font-bold {{ $savingsRate >= 20 ? 'text-green-600' : 'text-orange-600' }}">
                            {{ number_format($savingsRate, 1) }}%
                        </p>
                        <p class="text-sm text-gray-600 mt-2">
                            @if($savingsRate >= 20)
                                Great job! You're saving well.
                            @elseif($savingsRate > 0)
                                Consider increasing your savings rate to 20%+
                            @else
                                Try to reduce expenses and build savings.
                            @endif
                        </p>
                    </div>

                    <div class="bg-white rounded-lg p-4">
                        <h4 class="font-semibold text-gray-900 mb-2">📊 Top Expense Category</h4>
                        @if($topCategory)
                            <p class="text-2xl font-bold text-blue-600">{{ $topCategory->category }}</p>
                            <p class="text-sm text-gray-600 mt-2">
                                Ksh {{ number_format($topCategory->total, 2) }} spent
                            </p>
                        @else
                            <p class="text-gray-500">No expenses tracked yet</p>
                        @endif
                    </div>

                    <div class="bg-white rounded-lg p-4">
                        <h4 class="font-semibold text-gray-900 mb-2">🔥 Habit Consistency</h4>
                        @php
                            $avgCompletionRate = collect($last30Days)->avg('completion_rate');
                        @endphp
                        <p class="text-3xl font-bold {{ $avgCompletionRate >= 70 ? 'text-green-600' : 'text-orange-600' }}">
                            {{ number_format($avgCompletionRate, 1) }}%
                        </p>
                        <p class="text-sm text-gray-600 mt-2">
                            @if($avgCompletionRate >= 70)
                                Excellent consistency! Keep it up!
                            @else
                                Try to check in more regularly for better results.
                            @endif
                        </p>
                    </div>

                    <div class="bg-white rounded-lg p-4">
                        <h4 class="font-semibold text-gray-900 mb-2">🎯 Goal Suggestion</h4>
                        <p class="text-sm text-gray-700">
                            @if($totalHabits == 0)
                                Start with 1-2 habits to build consistency
                            @elseif($avgStreak < 7)
                                Focus on reaching a 7-day streak on each habit
                            @elseif($longestStreak < 30)
                                Challenge yourself to reach a 30-day streak!
                            @else
                                Amazing! Consider adding new challenging habits
                            @endif
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Chart.js Scripts -->
    <script>
        // Expenses by Category (Pie Chart)
        const categoryData = @json($expensesByCategory);
        const categoryLabels = categoryData.map(item => item.category);
        const categoryAmounts = categoryData.map(item => parseFloat(item.total));

        if (categoryLabels.length > 0) {
            new Chart(document.getElementById('expensesByCategoryChart'), {
                type: 'doughnut',
                data: {
                    labels: categoryLabels,
                    datasets: [{
                        data: categoryAmounts,
                        backgroundColor: [
                            '#3b82f6', '#ef4444', '#10b981', '#f59e0b', 
                            '#8b5cf6', '#ec4899', '#06b6d4', '#84cc16'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom' }
                    }
                }
            });
        }

        // Income vs Expenses (Line Chart)
        const monthlyData = @json($last6Months);
        const monthLabels = monthlyData.map(item => item.month);
        const incomeData = monthlyData.map(item => parseFloat(item.income));
        const expenseData = monthlyData.map(item => parseFloat(item.expenses));

        new Chart(document.getElementById('incomeVsExpensesChart'), {
            type: 'line',
            data: {
                labels: monthLabels,
                datasets: [
                    {
                        label: 'Income',
                        data: incomeData,
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        tension: 0.4
                    },
                    {
                        label: 'Expenses',
                        data: expenseData,
                        borderColor: '#ef4444',
                        backgroundColor: 'rgba(239, 68, 68, 0.1)',
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        // Habit Streaks (Bar Chart)
        const habitData = @json($habitProgress);
        const habitNames = habitData.map(item => item.name);
        const currentStreaks = habitData.map(item => item.current_streak);
        const longestStreaks = habitData.map(item => item.longest_streak);

        if (habitNames.length > 0) {
            new Chart(document.getElementById('habitStreaksChart'), {
                type: 'bar',
                data: {
                    labels: habitNames,
                    datasets: [
                        {
                            label: 'Current Streak',
                            data: currentStreaks,
                            backgroundColor: '#f59e0b'
                        },
                        {
                            label: 'Best Streak',
                            data: longestStreaks,
                            backgroundColor: '#ef4444'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom' }
                    },
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        }

        // Completion Rate (Line Chart)
        const dailyData = @json($last30Days);
        const dateLabels = dailyData.map(item => item.date);
        const completionRates = dailyData.map(item => parseFloat(item.completion_rate));

        new Chart(document.getElementById('completionRateChart'), {
            type: 'line',
            data: {
                labels: dateLabels,
                datasets: [{
                    label: 'Completion Rate (%)',
                    data: completionRates,
                    borderColor: '#8b5cf6',
                    backgroundColor: 'rgba(139, 92, 246, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                },
                scales: {
                    y: { 
                        beginAtZero: true,
                        max: 100
                    }
                }
            }
        });
    </script>
</x-app-layout>