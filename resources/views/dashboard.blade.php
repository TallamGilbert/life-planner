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
                    <h3 class="text-2xl font-bold mb-4">Welcome to Life Planner!</h3>
                    
                    <!-- Dashboard Overview Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                        <!-- Budget Card -->
                        <div class="bg-blue-50 p-6 rounded-lg">
                            <h4 class="text-lg font-semibold text-blue-900">Budget</h4>
                            <p class="text-3xl font-bold text-blue-600 mt-2">$0.00</p>
                            <p class="text-sm text-gray-600 mt-2">This month's balance</p>
                        </div>
                        
                        <!-- Streaks Card -->
                        <div class="bg-green-50 p-6 rounded-lg">
                            <h4 class="text-lg font-semibold text-green-900">Active Streaks</h4>
                            <p class="text-3xl font-bold text-green-600 mt-2">0</p>
                            <p class="text-sm text-gray-600 mt-2">Habits tracked</p>
                        </div>
                        
                        <!-- Meals Card -->
                        <div class="bg-purple-50 p-6 rounded-lg">
                            <h4 class="text-lg font-semibold text-purple-900">Meals Planned</h4>
                            <p class="text-3xl font-bold text-purple-600 mt-2">0</p>
                            <p class="text-sm text-gray-600 mt-2">This week</p>
                        </div>
                    </div>
                    
                    <!-- Quick Actions -->
                    <div class="mt-8">
                        <h4 class="text-lg font-semibold mb-4">Quick Actions</h4>
                        <div class="flex gap-4">
                            <a href="#" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                Add Expense
                            </a>
                            <a href="#" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                                Check-in Habit
                            </a>
                            <a href="#" class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">
                                Plan Meal
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>