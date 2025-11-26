<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Meal') }}
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
                    <h3 class="text-xl font-bold text-gray-900">Update Meal Details</h3>
                    <p class="text-sm text-gray-500 mt-1">Modify the menu item, ingredients, or schedule.</p>
                </div>

                <form method="POST" action="{{ route('meals.update', $meal) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Meal Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Meal Name
                        </label>
                        <input type="text" 
                               name="name" 
                               id="name" 
                               value="{{ old('name', $meal->name) }}"
                               class="w-full rounded-lg border-gray-200 focus:border-gray-900 focus:ring-gray-900 transition shadow-sm placeholder-gray-400"
                               placeholder="e.g. Grilled Chicken Salad"
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
                                    <option value="breakfast" {{ old('meal_type', $meal->meal_type) == 'breakfast' ? 'selected' : '' }}> Breakfast</option>
                                    <option value="lunch" {{ old('meal_type', $meal->meal_type) == 'lunch' ? 'selected' : '' }}> Lunch</option>
                                    <option value="dinner" {{ old('meal_type', $meal->meal_type) == 'dinner' ? 'selected' : '' }}> Dinner</option>
                                    <option value="snack" {{ old('meal_type', $meal->meal_type) == 'snack' ? 'selected' : '' }}> Snack</option>
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
                                   value="{{ old('date', $meal->date->format('Y-m-d')) }}"
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
                                      placeholder="Briefly describe how to prepare this... (e.g., Preheat oven to 400°F)">{{ old('recipe', $meal->recipe) }}</textarea>
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
                                      placeholder="- 2 chicken breasts&#10;- 1 cup rice&#10;- Olive oil">{{ old('ingredients', $meal->ingredients) }}</textarea>
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
                                  placeholder="Any extra details...">{{ old('notes', $meal->notes) }}</textarea>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-between pt-6 border-t border-gray-50">
                        <!-- Delete Button -->
                        <button type="button"
                                onclick="if(confirm('Are you sure you want to delete this meal?')) document.getElementById('delete-form').submit();"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-red-200 rounded-lg text-sm font-medium text-red-600 hover:bg-red-50 hover:border-red-300 transition shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            Delete
                        </button>

                        <div class="flex items-center gap-3">
                            <a href="{{ route('meals.index') }}" 
                               class="px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="px-6 py-2 bg-gray-900 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-gray-800 transition shadow-sm">
                                Save Changes
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Hidden Delete Form -->
            <form id="delete-form" 
                  method="POST" 
                  action="{{ route('meals.destroy', $meal) }}" 
                  class="hidden">
                @csrf
                @method('DELETE')
            </form>
            
        </div>
    </div>
</x-app-layout>