<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Habits') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Success/Info Messages -->
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
                     class="mb-6 bg-gray-900 text-white px-4 py-3 rounded-xl shadow-lg flex justify-between items-center transform transition-all duration-500">
                    <span>{{ session('success') }}</span>
                    <button @click="show = false" class="text-gray-400 hover:text-white">&times;</button>
                </div>
            @endif

            <!-- Page Header & Actions -->
            <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">Habit Tracker</h3>
                    <p class="text-gray-500 text-sm mt-1">Consistency is the key to progress.</p>
                </div>
                
                <a href="{{ route('habits.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-900 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-gray-800 transition shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    New Habit
                </a>
            </div>

            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                @php
                    $totalHabits = $habits->count();
                    $totalStreak = $habits->sum('streak');
                    $longestStreak = $habits->max('longest_streak') ?? 0;
                    $checkedInToday = $habits->filter(function($habit) {
                        return $habit->last_completed && $habit->last_completed->isToday();
                    })->count();
                @endphp

                <!-- Active Habits -->
                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)]">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="text-sm font-medium text-gray-500">Active Habits</h4>
                        <div class="p-2 bg-gray-50 rounded-lg text-gray-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        </div>
                    </div>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalHabits }}</p>
                </div>

                <!-- Checked In -->
                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)]">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="text-sm font-medium text-gray-500">Done Today</h4>
                        <div class="p-2 bg-gray-50 rounded-lg text-blue-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                    <p class="text-2xl font-bold text-gray-900">{{ $checkedInToday }} <span class="text-sm text-gray-400 font-normal">/ {{ $totalHabits }}</span></p>
                </div>

                <!-- Total Streak -->
                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)]">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="text-sm font-medium text-gray-500">Total Check-ins</h4>
                        <div class="p-2 bg-gray-50 rounded-lg text-orange-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                    </div>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalStreak }}</p>
                </div>

                <!-- Best Streak -->
                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)]">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="text-sm font-medium text-gray-500">Best Streak</h4>
                        <div class="p-2 bg-gray-50 rounded-lg text-purple-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                        </div>
                    </div>
                    <p class="text-2xl font-bold text-gray-900">{{ $longestStreak }} <span class="text-sm text-gray-400 font-normal">days</span></p>
                </div>
            </div>

            <!-- Habits Grid -->
            @if($habits->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($habits as $habit)
                        @php
                            $completedToday = $habit->last_completed && $habit->last_completed->isToday();
                        @endphp
                        
                        <!-- Habit Card -->
                        <div class="group bg-white rounded-xl border {{ $completedToday ? 'border-green-200 bg-green-50/30' : 'border-gray-100' }} shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] hover:shadow-md transition duration-200 flex flex-col h-full">
                            
                            <!-- Card Header -->
                            <div class="p-6 pb-2 flex justify-between items-start">
                                <div>
                                    <span class="inline-block px-2 py-1 text-[10px] uppercase tracking-wider font-semibold rounded-md {{ $completedToday ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                        {{ $habit->category ?? 'General' }}
                                    </span>
                                    <h3 class="text-lg font-bold text-gray-900 mt-2">{{ $habit->name }}</h3>
                                </div>

                                <!-- Dropdown Menu -->
                                <div class="relative" x-data="{ open: false }">
                                    <button @click="open = !open" class="p-1 rounded-full text-gray-300 hover:text-gray-600 hover:bg-gray-100 transition">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path></svg>
                                    </button>
                                    <div x-show="open" 
                                         @click.away="open = false"
                                         class="absolute right-0 mt-2 w-32 bg-white rounded-lg shadow-xl border border-gray-100 py-1 z-20"
                                         style="display: none;">
                                        <a href="{{ route('habits.edit', $habit) }}" class="block px-4 py-2 text-xs text-gray-700 hover:bg-gray-50">Edit</a>
                                        <form method="POST" action="{{ route('habits.archive', $habit) }}">
                                            @csrf
                                            <button type="submit" class="block w-full text-left px-4 py-2 text-xs text-red-600 hover:bg-red-50">Archive</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Description & Stats -->
                            <div class="px-6 flex-1">
                                @if($habit->description)
                                    <p class="text-xs text-gray-500 line-clamp-2 mb-4">{{ $habit->description }}</p>
                                @endif
                                
                                <div class="flex items-center gap-4 mt-2 mb-4">
                                    <div class="flex items-center gap-1.5">
                                        <span class="text-orange-500"></span>
                                        <span class="text-sm font-bold text-gray-900">{{ $habit->streak }}</span>
                                    </div>
                                    <div class="text-xs text-gray-400">
                                        Best: <span class="text-gray-600">{{ $habit->longest_streak }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Footer -->
                            <div class="p-6 pt-2 mt-auto">
                                @if($completedToday)
                                    <div class="w-full py-2.5 rounded-lg bg-white border border-green-200 text-green-700 flex items-center justify-center gap-2 text-sm font-medium cursor-default">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        Completed
                                    </div>
                                @else
                                    <form method="POST" action="{{ route('habits.checkin', $habit) }}">
                                        @csrf
                                        <button type="submit" class="w-full py-2.5 rounded-lg border border-gray-200 bg-white text-gray-700 hover:border-gray-900 hover:text-gray-900 hover:bg-gray-50 transition flex items-center justify-center gap-2 text-sm font-medium">
                                            <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-900 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            Check In
                                        </button>
                                    </form>
                                @endif
                                <p class="text-[10px] text-gray-300 text-center mt-2">
                                    {{ $habit->last_completed ? 'Last: ' . $habit->last_completed->diffForHumans() : 'No history' }}
                                </p>
                            </div>

                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white rounded-xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] p-12 text-center">
                    <div class="mx-auto w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">No habits tracked yet</h3>
                    <p class="text-gray-500 text-sm mt-1 max-w-sm mx-auto">Start small. Add a daily habit you want to build and track your consistency.</p>
                    <a href="{{ route('habits.create') }}" class="mt-6 inline-flex items-center gap-2 px-5 py-2.5 bg-gray-900 text-white rounded-lg text-sm font-medium hover:bg-gray-800 transition">
                        Create First Habit
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>