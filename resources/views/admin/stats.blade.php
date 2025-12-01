<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-indigo-50 text-indigo-600 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                </div>
                <h2 class="font-semibold text-xl text-gray-900 tracking-tight leading-tight">
                    System Analytics
                </h2>
            </div>
            <a href="{{ route('admin.dashboard') }}" 
               class="group flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-gray-900 transition bg-white px-4 py-2 rounded-full border border-gray-200 shadow-sm hover:shadow-md">
                <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Overview
            </a>
        </div>
    </x-slot>

    <div class="py-10 bg-gray-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- User Growth Chart -->
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)]">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="font-bold text-gray-900">User Growth</h3>
                        <p class="text-sm text-gray-500 mt-1">New registrations over the last 6 months</p>
                    </div>
                    <span class="px-3 py-1 bg-blue-50 text-blue-700 text-xs font-bold rounded-full border border-blue-100">Live Data</span>
                </div>
                <div class="relative w-full" style="height: 350px;">
                    <canvas id="userGrowthChart"></canvas>
                </div>
            </div>

            <!-- Expenses by Category Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Chart Column -->
                <div class="lg:col-span-2 bg-white p-6 rounded-2xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)]">
                    <h3 class="font-bold text-gray-900 mb-6">Expenses Distribution</h3>
                    <div class="relative w-full flex items-center justify-center" style="height: 350px;">
                        <canvas id="expensesCategoryChart"></canvas>
                    </div>
                </div>

                <!-- Breakdown Column -->
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] flex flex-col h-full">
                    <h3 class="font-bold text-gray-900 mb-6">Category Details</h3>
                    <div class="space-y-3 overflow-y-auto max-h-[350px] pr-2 custom-scrollbar">
                        @foreach($expenses_by_category as $category)
                            <div class="flex justify-between items-center p-3 rounded-xl bg-gray-50 border border-gray-100 hover:bg-white hover:shadow-sm hover:border-gray-200 transition group">
                                <div class="flex items-center gap-3">
                                    <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                                    <span class="font-medium text-gray-700 text-sm">{{ $category->category }}</span>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-gray-900 text-sm">Ksh {{ number_format($category->total) }}</p>
                                    <p class="text-[10px] text-gray-400 group-hover:text-gray-500 transition">{{ $category->count }} txns</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Popular Habits -->
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)]">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="font-bold text-gray-900">Habit Trends</h3>
                        <p class="text-sm text-gray-500 mt-1">Most popular habit categories among users</p>
                    </div>
                    <div class="p-2 bg-green-50 text-green-600 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    </div>
                </div>
                <div class="relative w-full" style="height: 300px;">
                    <canvas id="habitsChart"></canvas>
                </div>
            </div>

        </div>
    </div>

    <!-- Chart.js Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js"></script>
    <script>
        // Common options for clean, minimal charts
        Chart.defaults.font.family = "'Figtree', sans-serif";
        Chart.defaults.color = '#6b7280';
        Chart.defaults.scale.grid.color = '#f3f4f6';
        
        window.chartData = {
            userGrowth: {
                labels: @json($users_by_month->pluck('month')),
                datasets: [{
                    label: 'New Users',
                    data: @json($users_by_month->pluck('count')),
                    borderColor: '#4f46e5', // Indigo-600
                    backgroundColor: (context) => {
                        const ctx = context.chart.ctx;
                        const gradient = ctx.createLinearGradient(0, 0, 0, 300);
                        gradient.addColorStop(0, 'rgba(79, 70, 229, 0.2)');
                        gradient.addColorStop(1, 'rgba(79, 70, 229, 0)');
                        return gradient;
                    },
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#4f46e5',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            expenses: {
                labels: @json($expenses_by_category->pluck('category')),
                datasets: [{
                    data: @json($expenses_by_category->pluck('total')),
                    backgroundColor: [
                        '#3b82f6', '#6366f1', '#8b5cf6', '#ec4899', 
                        '#f43f5e', '#f97316', '#10b981', '#14b8a6'
                    ],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            habits: {
                labels: @json($popular_habits->pluck('category')),
                datasets: [{
                    label: 'Active Habits',
                    data: @json($popular_habits->pluck('count')),
                    backgroundColor: '#10b981',
                    borderRadius: 6,
                    barPercentage: 0.6,
                    categoryPercentage: 0.8
                }]
            }
        };
    </script>
    <script src="{{ asset('js/admin/stats.js') }}"></script>
</x-app-layout>