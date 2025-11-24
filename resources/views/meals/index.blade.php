<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Meal Planner
            </h2>
            <div class="flex gap-3">
                <a href="{{ route('meals.shopping-list') }}" 
                   class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition">
                    Shopping List
                </a>
                <a href="{{ route('meals.create') }}" 
                   class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    + Add Meal
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Week Navigation -->
            <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-semibold">
                        Week of {{ $startOfWeek->format('M d') }} - {{ $endOfWeek->format('M d, Y') }}
                    </h3>
                    <div class="flex gap-2">
                        <button class="px-3 py-1 text-sm bg-gray-100 rounded hover:bg-gray-200">
                            ← Previous Week
                        </button>
                        <button class="px-3 py-1 text-sm bg-gray-100 rounded hover:bg-gray-200">
                            Next Week →
                        </button>
                    </div>
                </div>
            </div>

            <!-- Weekly Calendar Grid -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="grid grid-cols-8 border-b bg-gray-50">
                    <div class="p-3 font-semibold text-gray-700">Meal Type</div>
                    @for($i = 0; $i < 7; $i++)
                        @php
                            $day = $startOfWeek->copy()->addDays($i);
                            $isToday = $day->isToday();
                        @endphp
                        <div class="p-3 font-semibold text-center {{ $isToday ? 'bg-blue-100 text-blue-900' : 'text-gray-700' }}">
                            <div class="text-xs">{{ $day->format('D') }}</div>
                            <div class="text-lg">{{ $day->format('j') }}</div>
                        </div>
                    @endfor
                </div>

                @foreach(['breakfast', 'lunch', 'dinner', 'snack'] as $mealType)
                    <div class="grid grid-cols-8 border-b hover:bg-gray-50">
                        <div class="p-3 font-medium text-gray-700 bg-gray-50 border-r flex items-center">
                            <span class="capitalize">{{ $mealType }}</span>
                        </div>
                        
                        @for($i = 0; $i < 7; $i++)
                            @php
                                $day = $startOfWeek->copy()->addDays($i);
                                $dateKey = $day->format('Y-m-d');
                                $dayMeals = isset($mealsByDate[$dateKey]) 
                                    ? $mealsByDate[$dateKey]->where('meal_type', $mealType) 
                                    : collect([]);
                            @endphp
                            
                            <div class="p-2 border-r min-h-[80px] relative group">
                                @if($dayMeals->count() > 0)
                                    @foreach($dayMeals as $meal)
                                        <div class="bg-purple-50 border border-purple-200 rounded p-2 mb-1 hover:bg-purple-100 cursor-pointer">
                                            <a href="{{ route('meals.edit', $meal) }}" class="block">
                                                <p class="text-xs font-medium text-purple-900 truncate">
                                                    {{ $meal->name }}
                                                </p>
                                                @if($meal->recipe)
                                                    <p class="text-xs text-purple-600 truncate">
                                                        {{ Str::limit($meal->recipe, 30) }}
                                                    </p>
                                                @endif
                                            </a>
                                        </div>
                                    @endforeach
                                @else
                                    <a href="{{ route('meals.create', ['date' => $dateKey, 'type' => $mealType]) }}" 
                                       class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 bg-blue-50 transition">
                                        <span class="text-blue-600 text-2xl">+</span>
                                    </a>
                                @endif
                            </div>
                        @endfor
                    </div>
                @endforeach
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                @php
                    $totalMeals = Auth::user()->meals()
                        ->whereBetween('date', [$startOfWeek, $endOfWeek])
                        ->count();
                    $mealsWithRecipes = Auth::user()->meals()
                        ->whereBetween('date', [$startOfWeek, $endOfWeek])
                        ->whereNotNull('recipe')
                        ->count();
                    $totalPossible = 28; // 7 days × 4 meal types
                @endphp

                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <p class="text-sm text-gray-600">Meals Planned</p>
                    <p class="text-3xl font-bold text-purple-600">{{ $totalMeals }}/{{ $totalPossible }}</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <p class="text-sm text-gray-600">With Recipes</p>
                    <p class="text-3xl font-bold text-blue-600">{{ $mealsWithRecipes }}</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <p class="text-sm text-gray-600">Completion Rate</p>
                    <p class="text-3xl font-bold text-green-600">{{ $totalPossible > 0 ? round(($totalMeals / $totalPossible) * 100) : 0 }}%</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
