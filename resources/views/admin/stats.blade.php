<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 tracking-tight">
                    System Analytics
                </h2>
                <p class="text-sm text-gray-500 mt-1">Real-time data insights and platform trends</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" 
               class="group inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-700 hover:border-gray-300 hover:text-gray-900 hover:bg-gray-50 transition shadow-sm">
                <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- User Growth Chart -->
            <div class="bg-white p-6 md:p-8 rounded-2xl border border-gray-200/60 shadow-sm">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-8 gap-4">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">User Acquisition</h3>
                        <p class="text-sm text-gray-500">Registration trends over the last 6 months</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="text-right">
                            <p class="text-xs text-gray-400 uppercase font-bold tracking-wider">This Month</p>
                            <p class="text-xl font-bold text-gray-900">{{ $users_by_month->last()->count ?? 0 }}</p>
                        </div>
                        <div class="w-px h-8 bg-gray-100"></div>
                        <div class="text-right">
                            <p class="text-xs text-gray-400 uppercase font-bold tracking-wider">Total Growth</p>
                            <p class="text-xl font-bold text-indigo-600">+{{ $users_by_month->sum('count') }}</p>
                        </div>
                    </div>
                </div>
                <div class="relative w-full h-[350px]">
                    <canvas id="userGrowthChart"></canvas>
                </div>
            </div>

            <!-- Expenses Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Chart Column -->
                <div class="lg:col-span-2 bg-white p-6 md:p-8 rounded-2xl border border-gray-200/60 shadow-sm flex flex-col">
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Expenses Distribution</h3>
                    <p class="text-sm text-gray-500 mb-6">Spending breakdown by category</p>
                    
                    <div class="relative flex-1 min-h-[300px] flex items-center justify-center">
                        <canvas id="expensesCategoryChart"></canvas>
                    </div>
                </div>

                <!-- Breakdown Column -->
                <div class="bg-white p-6 md:p-8 rounded-2xl border border-gray-200/60 shadow-sm flex flex-col h-full">
                    <h3 class="text-lg font-bold text-gray-900 mb-6">Category Details</h3>
                    <div class="flex-1 overflow-y-auto pr-2 space-y-3 custom-scrollbar max-h-[400px]">
                        @foreach($expenses_by_category as $index => $category)
                            <div class="flex justify-between items-center p-3 rounded-xl hover:bg-gray-50 border border-transparent hover:border-gray-100 transition group">
                                <div class="flex items-center gap-3">
                                    <div class="w-2.5 h-2.5 rounded-full" style="background-color: {{ ['#3b82f6', '#6366f1', '#8b5cf6', '#ec4899', '#f43f5e', '#f97316', '#10b981', '#14b8a6'][$index % 8] }}"></div>
                                    <div>
                                        <p class="font-medium text-gray-900 text-sm">{{ $category->category }}</p>
                                        <p class="text-[10px] text-gray-400">{{ $category->count }} Transactions</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-gray-900 text-sm">Ksh {{ number_format($category->total) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-6 pt-4 border-t border-gray-100">
                        <div class="flex justify-between items-center">
                            <span class="text-xs font-bold text-gray-500 uppercase">Total Volume</span>
                            <span class="text-lg font-bold text-gray-900">Ksh {{ number_format($expenses_by_category->sum('total')) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Popular Habits -->
            <div class="bg-white p-6 md:p-8 rounded-2xl border border-gray-200/60 shadow-sm">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Habit Trends</h3>
                        <p class="text-sm text-gray-500">Most active habit categories among users</p>
                    </div>
                    <div class="hidden sm:flex items-center gap-2 text-sm text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-100">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        <span class="font-medium">Engagement High</span>
                    </div>
                </div>
                <div class="relative w-full h-[300px]">
                    <canvas id="habitsChart"></canvas>
                </div>
            </div>

        </div>
    </div>

    <!-- Chart.js Integration -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Global Defaults for Modern Look
            Chart.defaults.font.family = "'Figtree', sans-serif";
            Chart.defaults.color = '#64748b'; // Slate 500
            Chart.defaults.scale.grid.color = '#f1f5f9'; // Slate 100
            Chart.defaults.plugins.tooltip.backgroundColor = '#1e293b'; // Slate 800
            Chart.defaults.plugins.tooltip.padding = 10;
            Chart.defaults.plugins.tooltip.cornerRadius = 8;
            Chart.defaults.plugins.tooltip.displayColors = false;

            // 1. User Growth Chart (Line with Gradient)
            const ctxGrowth = document.getElementById('userGrowthChart').getContext('2d');
            const gradientGrowth = ctxGrowth.createLinearGradient(0, 0, 0, 300);
            gradientGrowth.addColorStop(0, 'rgba(79, 70, 229, 0.15)'); // Indigo
            gradientGrowth.addColorStop(1, 'rgba(79, 70, 229, 0)');

            new Chart(ctxGrowth, {
                type: 'line',
                data: {
                    labels: @json($users_by_month->pluck('month')),
                    datasets: [{
                        label: 'New Users',
                        data: @json($users_by_month->pluck('count')),
                        borderColor: '#4f46e5', // Indigo 600
                        backgroundColor: gradientGrowth,
                        borderWidth: 2,
                        tension: 0.4, // Smooth curves
                        fill: true,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#4f46e5',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { borderDash: [4, 4] },
                            border: { display: false }
                        },
                        x: {
                            grid: { display: false },
                            border: { display: false }
                        }
                    }
                }
            });

            // 2. Expenses Chart (Doughnut)
            const ctxExpenses = document.getElementById('expensesCategoryChart').getContext('2d');
            new Chart(ctxExpenses, {
                type: 'doughnut',
                data: {
                    labels: @json($expenses_by_category->pluck('category')),
                    datasets: [{
                        data: @json($expenses_by_category->pluck('total')),
                        backgroundColor: [
                            '#3b82f6', '#6366f1', '#8b5cf6', '#ec4899', 
                            '#f43f5e', '#f97316', '#10b981', '#14b8a6'
                        ],
                        borderWidth: 0,
                        hoverOffset: 10
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '75%', // Thinner ring
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { usePointStyle: true, padding: 20, boxWidth: 8 }
                        }
                    }
                }
            });

            // 3. Habits Chart (Bar)
            const ctxHabits = document.getElementById('habitsChart').getContext('2d');
            new Chart(ctxHabits, {
                type: 'bar',
                data: {
                    labels: @json($popular_habits->pluck('category')),
                    datasets: [{
                        label: 'Active Habits',
                        data: @json($popular_habits->pluck('count')),
                        backgroundColor: '#10b981', // Emerald 500
                        borderRadius: 6,
                        barPercentage: 0.5,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { borderDash: [4, 4] },
                            border: { display: false }
                        },
                        x: {
                            grid: { display: false },
                            border: { display: false }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>