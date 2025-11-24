<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('My Habits') }}
            </h2>
            <a href="{{ route('habits.create') }}" 
               class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                + New Habit
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Success/Info Messages -->
            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('info'))
                <div class="mb-6 bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-lg">
                    {{ session('info') }}
                </div>
            @endif

            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                @php
                    $totalHabits = $habits->count();
                    $totalStreak = $habits->sum('streak');
                    $longestStreak = $habits->max('longest_streak');
                    $checkedInToday = $habits->filter(function($habit) {
                        return $habit->last_completed && $habit->last_completed->isToday();
                    })->count();
                @endphp

                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <p class="text-sm text-gray-600">Active Habits</p>
                    <p class="text-3xl font-bold text-green-600">{{ $totalHabits }}</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <p class="text-sm text-gray-600">Checked In Today</p>
                    <p class="text-3xl font-bold text-blue-600">{{ $checkedInToday }}</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <p class="text-sm text-gray-600">Total Streak Days</p>
                    <p class="text-3xl font-bold text-orange-600">{{ $totalStreak }}</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <p class="text-sm text-gray-600">Best Streak</p>
                    <p class="text-3xl font-bold text-red-600">{{ $longestStreak }} 🔥</p>
                </div>
            </div>

            <!-- Habits Grid -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($habits->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($habits as $habit)
                                @php
                                    $completedToday = $habit->last_completed && $habit->last_completed->isToday();
                                    $canCheckIn = !$completedToday;
                                @endphp
                                
                                <div class="border rounded-lg p-6 hover:shadow-lg transition {{ $completedToday ? 'bg-green-50 border-green-300' : 'bg-white' }}">
                                    <!-- Habit Header -->
                                    <div class="flex justify-between items-start mb-4">
                                        <div class="flex-1">
                                            <h3 class="text-lg font-semibold text-gray-900">{{ $habit->name }}</h3>
                                            <span class="inline-block mt-1 px-2 py-1 text-xs bg-gray-100 text-gray-700 rounded">
                                                {{ $habit->category }}
                                            </span>
                                        </div>
                                        
                                        <!-- Dropdown Menu -->
                                        <div class="relative" x-data="{ open: false }">
                                            <button @click="open = !open" class="text-gray-400 hover:text-gray-600">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
                                                </svg>
                                            </button>
                                            <div x-show="open" 
                                                 @click.away="open = false"
                                                 class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-1 z-10">
                                                <a href="{{ route('habits.edit', $habit) }}" 
                                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                    Edit
                                                </a>
                                                <form method="POST" action="{{ route('habits.archive', $habit) }}">
                                                    @csrf
                                                    <button type="submit" 
                                                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                        Archive
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Description -->
                                    @if($habit->description)
                                        <p class="text-sm text-gray-600 mb-4">{{ $habit->description }}</p>
                                    @endif

                                    <!-- Streak Info -->
                                    <div class="mb-4">
                                        <div class="flex justify-between items-center mb-2">
                                            <span class="text-sm text-gray-600">Current Streak</span>
                                            <span class="text-2xl font-bold text-orange-600">{{ $habit->streak }} 🔥</span>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <span class="text-sm text-gray-600">Best Streak</span>
                                            <span class="text-sm font-semibold text-gray-700">{{ $habit->longest_streak }} days</span>
                                        </div>
                                    </div>

                                    <!-- Last Completed -->
                                    @if($habit->last_completed)
                                        <p class="text-xs text-gray-500 mb-4">
                                            Last completed: {{ $habit->last_completed->diffForHumans() }}
                                        </p>
                                    @else
                                        <p class="text-xs text-gray-500 mb-4">
                                            Not completed yet
                                        </p>
                                    @endif

                                    <!-- Check-in Button -->
                                    @if($canCheckIn)
                                        <form method="POST" action="{{ route('habits.checkin', $habit) }}">
                                            @csrf
                                            <button type="submit" 
                                                    class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition font-semibold">
                                                ✓ Check In Today
                                            </button>
                                        </form>
                                    @else
                                        <div class="w-full bg-green-100 text-green-800 py-2 rounded-lg text-center font-semibold">
                                            ✓ Completed Today!
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                            </svg>
                            <p class="mt-4 text-gray-600">No habits yet. Start building better habits today!</p>
                            <a href="{{ route('habits.create') }}" 
                               class="mt-4 inline-block bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
                                Create Your First Habit
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>