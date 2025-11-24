<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Add Meal
            </h2>
            <a href="{{ route('meals.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
                ← Back to Meal Planner
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('meals.store') }}" class="space-y-6">
                        @csrf

                        <!-- Meal Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                Meal Name *
                            </label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   value="{{ old('name') }}"
                                   class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500"
                                   placeholder="e.g., Grilled Chicken Salad, Oatmeal with Berries"
                                   required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Meal Type and Date -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Meal Type -->
                            <div>
                                <label for="meal_type" class="block text-sm font-medium text-gray-700 mb-1">
                                    Meal Type *
                                </label>
                                <select name="meal_type" 
                                        id="meal_type" 
                                        class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500"
                                        required>
                                    <option value="">Select type</option>
                                    <option value="breakfast" {{ old('meal_type', request('type')) == 'breakfast' ? 'selected' : '' }}>🍳 Breakfast</option>
                                    <option value="lunch" {{ old('meal_type', request('type')) == 'lunch' ? 'selected' : '' }}>🍱 Lunch</option>
                                    <option value="dinner" {{ old('meal_type', request('type')) == 'dinner' ? 'selected' : '' }}>🍽️ Dinner</option>
                                    <option value="snack" {{ old('meal_type', request('type')) == 'snack' ? 'selected' : '' }}>🍿 Snack</option>
                                </select>
                                @error('meal_type')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Date -->
                            <div>
                                <label for="date" class="block text-sm font-medium text-gray-700 mb-1">
                                    Date *
                                </label>
                                <input type="date" 
                                       name="date" 
                                       id="date" 
                                       value="{{ old('date', request('date', date('Y-m-d'))) }}"
                                       class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500"
                                       required>
                                @error('date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Recipe -->
                        <div>
                            <label for="recipe" class="block text-sm font-medium text-gray-700 mb-1">
                                Recipe / Instructions (Optional)
                            </label>
                            <textarea name="recipe" 
                                      id="recipe" 
                                      rows="4"
                                      class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500"
                                      placeholder="How to prepare this meal...">{{ old('recipe') }}</textarea>
                            @error('recipe')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Ingredients -->
                        <div>
                            <label for="ingredients" class="block text-sm font-medium text-gray-700 mb-1">
                                Ingredients (Optional)
                            </label>
                            <textarea name="ingredients" 
                                      id="ingredients" 
                                      rows="4"
                                      class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500"
                                      placeholder="List ingredients, one per line...&#10;- 2 chicken breasts&#10;- 1 cup rice&#10;- 2 tbsp olive oil">{{ old('ingredients') }}</textarea>
                            <p class="mt-1 text-xs text-gray-500">Tip: These will appear in your shopping list</p>
                            @error('ingredients')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Notes -->
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">
                                Notes (Optional)
                            </label>
                            <textarea name="notes" 
                                      id="notes" 
                                      rows="2"
                                      class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500"
                                      placeholder="Any additional notes...">{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center justify-end gap-4 pt-4 border-t">
                            <a href="{{ route('meals.index') }}" 
                               class="px-4 py-2 text-gray-700 hover:text-gray-900">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                                Add Meal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>