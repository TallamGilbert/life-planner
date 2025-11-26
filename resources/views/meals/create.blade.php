<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New Meal') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50/50 min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Breadcrumb -->
            <div class="mb-6">
                <a href="{{ route('meals.index') }}" class="flex items-center text-sm text-gray-500 hover:text-gray-900 transition">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    Back to Planner
                </a>
            </div>

            <!-- Main Card -->
            <div class="bg-white p-8 rounded-xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)]">
                
                <div class="mb-8 border-b border-gray-100 pb-4">
                    <h3 class="text-xl font-bold text-gray-900">Plan a Meal</h3>
                    <p class="text-sm text-gray-500 mt-1">Add a new item to your weekly menu.</p>
                </div>

                <form method="POST" action="{{ route('meals.store') }}" class="space-y-6">
                    @csrf

                    <!-- Meal Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Meal Name
                        </label>
                        <input type="text" 
                               name="name" 
                               id="name" 
                               value="{{ old('name') }}"
                               class="w-full rounded-lg border-gray-200 focus:border-gray-900 focus:ring-gray-900 transition shadow-sm placeholder-gray-400"
                               placeholder="e.g. Avocado Toast"
                               required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Grid for Type & Date -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Meal Type -->
                        <div>
                            <label for="meal_type" class="block text-sm font-medium text-gray-700 mb-2">
                                Meal Type
                            </label>
                            <div class="relative">
                                <select name="meal_type" 
                                        id="meal_type" 
                                        class="w-full rounded-lg border-gray-200 focus:border-gray-900 focus:ring-gray-900 transition shadow-sm appearance-none"
                                        required>
                                    <option value="">Select type</option>
                                    <option value="breakfast" {{ old('meal_type', request('type')) == 'breakfast' ? 'selected' : '' }}> Breakfast</option>
                                    <option value="lunch" {{ old('meal_type', request('type')) == 'lunch' ? 'selected' : '' }}> Lunch</option>
                                    <option value="dinner" {{ old('meal_type', request('type')) == 'dinner' ? 'selected' : '' }}>Dinner</option>
                                    <option value="snack" {{ old('meal_type', request('type')) == 'snack' ? 'selected' : '' }}> Snack</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                            @error('meal_type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Date -->
                        <div>
                            <label for="date" class="block text-sm font-medium text-gray-700 mb-2">
                                Scheduled Date
                            </label>
                            <input type="date" 
                                   name="date" 
                                   id="date" 
                                   value="{{ old('date', request('date', date('Y-m-d'))) }}"
                                   class="w-full rounded-lg border-gray-200 focus:border-gray-900 focus:ring-gray-900 transition shadow-sm text-gray-600"
                                   required>
                            @error('date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="border-t border-gray-100 my-6"></div>

                    <!-- Recipe & Ingredients Section -->
                    <div class="space-y-6">
                        <!-- Recipe -->
                        <div>
                            <label for="recipe" class="block text-sm font-medium text-gray-700 mb-2">
                                Instructions / Recipe <span class="text-gray-400 font-normal">(Optional)</span>
                            </label>
                            <textarea name="recipe" 
                                      id="recipe" 
                                      rows="4"
                                      class="w-full rounded-lg border-gray-200 focus:border-gray-900 focus:ring-gray-900 transition shadow-sm placeholder-gray-400"
                                      placeholder="Briefly describe how to prepare this meal...">{{ old('recipe') }}</textarea>
                            @error('recipe')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Ingredients -->
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <label for="ingredients" class="block text-sm font-medium text-gray-700">
                                    Ingredients
                                </label>
                                <span class="text-xs text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full font-medium">Synced to Shopping List</span>
                            </div>
                            <textarea name="ingredients" 
                                      id="ingredients" 
                                      rows="4"
                                      class="w-full rounded-lg border-gray-200 focus:border-gray-900 focus:ring-gray-900 transition shadow-sm placeholder-gray-400"
                                      placeholder="- 2 eggs&#10;- 1 slice bread&#10;- 1/2 avocado">{{ old('ingredients') }}</textarea>
                            <p class="text-xs text-gray-400 mt-2">Enter each ingredient on a new line.</p>
                            @error('ingredients')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Notes -->
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                            Notes <span class="text-gray-400 font-normal">(Optional)</span>
                        </label>
                        <textarea name="notes" 
                                  id="notes" 
                                  rows="2"
                                  class="w-full rounded-lg border-gray-200 focus:border-gray-900 focus:ring-gray-900 transition shadow-sm placeholder-gray-400"
                                  placeholder="Any extra details...">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-50">
                        <a href="{{ route('meals.index') }}" 
                           class="px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="px-6 py-2 bg-gray-900 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-gray-800 transition shadow-sm">
                            Add Meal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>