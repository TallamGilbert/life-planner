<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Meal Planner') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50/50 min-h-screen">
        <div class="max-w-[90rem] mx-auto sm:px-6 lg:px-8"> <!-- Wider container for calendar -->
            
            <!-- Success Message Toast -->
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
                     class="fixed top-4 right-4 z-50 bg-gray-900 text-white px-4 py-3 rounded-xl shadow-lg flex items-center gap-3 transform transition-all duration-500">
                    <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Header & Actions -->
            <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">Weekly Menu</h3>
                    <p class="text-gray-500 text-sm mt-1">Plan your nutrition and manage groceries.</p>
                </div>
                
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('meals.shopping-list') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-black transition shadow-sm">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        Shopping List
                    </a>
                    <a href="{{ route('meals.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-900 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-gray-800 transition shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Add Meal
                    </a>
                </div>
            </div>

            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                @php
                    $totalMeals = Auth::user()->meals()
                        ->whereBetween('date', [$startOfWeek, $endOfWeek])
                        ->count();
                    $mealsWithRecipes = Auth::user()->meals()
                        ->whereBetween('date', [$startOfWeek, $endOfWeek])
                        ->whereNotNull('recipe')
                        ->count();
                    $totalPossible = 28; // 4 meals x 7 days
                    $completionRate = $totalPossible > 0 ? round(($totalMeals / $totalPossible) * 100) : 0;
                @endphp

                <!-- Planned Card -->
                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)]">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="text-sm font-medium text-gray-500">Weekly Coverage</h4>
                        <div class="p-2 bg-gray-50 rounded-lg text-gray-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        </div>
                    </div>
                    <div class="flex items-end gap-2">
                        <p class="text-2xl font-bold text-gray-900">{{ $totalMeals }}</p>
                        <span class="text-sm text-gray-400 mb-1">/ {{ $totalPossible }} meals</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-1 mt-3">
                        <div class="bg-gray-900 h-1 rounded-full" style="width: {{ $completionRate }}%"></div>
                    </div>
                </div>

                <!-- Recipes Card -->
                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)]">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="text-sm font-medium text-gray-500">Recipes Ready</h4>
                        <div class="p-2 bg-gray-50 rounded-lg text-gray-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                    </div>
                    <p class="text-2xl font-bold text-gray-900">{{ $mealsWithRecipes }}</p>
                    <p class="text-xs text-gray-400 mt-1">Meals with attached instructions</p>
                </div>

                <!-- Navigation Card -->
                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] flex flex-col justify-center">
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="text-sm font-medium text-gray-500">Viewing Schedule</h4>
                    </div>
                    <div class="flex items-center justify-between bg-gray-50 p-2 rounded-lg">
                        <a href="{{ request()->fullUrlWithQuery(['date' => $startOfWeek->copy()->subWeek()->format('Y-m-d')]) }}" class="p-2 hover:bg-white hover:shadow-sm rounded-md transition text-gray-500 hover:text-gray-900">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        </a>
                        <span class="text-sm font-bold text-gray-900">
                            {{ $startOfWeek->format('M d') }} - {{ $endOfWeek->format('M d') }}
                        </span>
                        <a href="{{ request()->fullUrlWithQuery(['date' => $startOfWeek->copy()->addWeek()->format('Y-m-d')]) }}" class="p-2 hover:bg-white hover:shadow-sm rounded-md transition text-gray-500 hover:text-gray-900">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Calendar Grid -->
            <div class="bg-white rounded-xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] overflow-hidden">
                <div class="overflow-x-auto">
                    <div class="min-w-[1000px]"> <!-- Enforce minimum width to prevent squishing -->
                        
                        <!-- Header Row (Days) -->
                        <div class="grid grid-cols-8 border-b border-gray-100 bg-gray-50/50">
                            <div class="p-4 text-xs font-bold text-gray-400 uppercase tracking-wider">
                                Meal Type
                            </div>
                            @for($i = 0; $i < 7; $i++)
                                @php
                                    $day = $startOfWeek->copy()->addDays($i);
                                    $isToday = $day->isToday();
                                @endphp
                                <div class="p-4 text-center border-l border-gray-100 {{ $isToday ? 'bg-gray-100/50' : '' }}">
                                    <p class="text-xs font-medium uppercase {{ $isToday ? 'text-gray-900' : 'text-gray-400' }}">
                                        {{ $day->format('D') }}
                                    </p>
                                    <div class="mt-1 inline-flex items-center justify-center w-8 h-8 rounded-full {{ $isToday ? 'bg-gray-900 text-white shadow-sm' : 'text-gray-900 font-bold' }}">
                                        {{ $day->format('j') }}
                                    </div>
                                </div>
                            @endfor
                        </div>

                        <!-- Rows (Meal Types) -->
                        @foreach(['breakfast', 'lunch', 'dinner', 'snack'] as $mealType)
                            <div class="grid grid-cols-8 border-b border-gray-50 group/row">
                                <!-- Row Header -->
                                <div class="p-4 flex items-center bg-gray-50/30 text-xs font-bold text-gray-500 uppercase tracking-wide">
                                    {{ $mealType }}
                                </div>
                                
                                <!-- Cells -->
                                @for($i = 0; $i < 7; $i++)
                                    @php
                                        $day = $startOfWeek->copy()->addDays($i);
                                        $dateKey = $day->format('Y-m-d');
                                        $isToday = $day->isToday();
                                        $dayMeals = isset($mealsByDate[$dateKey]) 
                                            ? $mealsByDate[$dateKey]->where('meal_type', $mealType) 
                                            : collect([]);
                                    @endphp
                                    
                                    <div class="relative p-2 min-h-[120px] border-l border-gray-100 hover:bg-gray-50/50 transition duration-150 {{ $isToday ? 'bg-gray-50/30' : '' }} group/cell">
                                        
                                        @if($dayMeals->count() > 0)
                                            <!-- Meal Items -->
                                            <div class="space-y-2">
                                                @foreach($dayMeals as $meal)
                                                    <a href="{{ route('meals.edit', $meal) }}" class="block group/card">
                                                        <div class="bg-white p-3 rounded-lg border border-gray-200 shadow-sm hover:border-gray-400 hover:shadow-md transition duration-200">
                                                            <div class="flex justify-between items-start">
                                                                <p class="text-sm font-semibold text-gray-900 line-clamp-2">
                                                                    {{ $meal->name }}
                                                                </p>
                                                            </div>
                                                            @if($meal->recipe)
                                                                <div class="mt-2 flex items-center gap-1 text-[10px] text-gray-500">
                                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                                    <span>Recipe</span>
                                                                </div>
                                                            @endif
                                                            <!-- Hover Icon (Only visible on card hover) -->
                                                            <div class="hidden group-hover/card:block absolute top-1 right-1">
                                                                <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                                            </div>
                                                        </div>
                                                    </a>
                                                @endforeach
                                            </div>
                                            
                                            <!-- Tiny Add Button (visible on hover if meals exist) -->
                                            <a href="{{ route('meals.create', ['date' => $dateKey, 'type' => $mealType]) }}" 
                                               class="opacity-0 group-hover/cell:opacity-100 absolute bottom-1 right-1 p-1 text-gray-400 hover:text-gray-900 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                            </a>
                                        @else
                                            <!-- Empty State -->
                                            <a href="{{ route('meals.create', ['date' => $dateKey, 'type' => $mealType]) }}" 
                                               class="absolute inset-2 border border-dashed border-gray-200 rounded-lg flex flex-col items-center justify-center text-gray-300 hover:text-gray-600 hover:border-gray-400 hover:bg-white transition duration-200 group/empty">
                                                <svg class="w-6 h-6 mb-1 opacity-0 group-hover/empty:opacity-100 transition-opacity transform group-hover/empty:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                                <span class="text-xs font-medium opacity-0 group-hover/empty:opacity-100 transition-opacity">Add</span>
                                            </a>
                                        @endif
                                    </div>
                                @endfor
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <div class="mt-6 text-center">
                <p class="text-xs text-gray-400">
                    Pro Tip: Click on any empty slot to quickly add a meal for that specific day and time.
                </p>
            </div>

        </div>
    </div>
</x-app-layout>