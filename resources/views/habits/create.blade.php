<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create New Habit') }}
            </h2>
            <a href="{{ route('habits.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
                ← Back to Habits
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('habits.store') }}" class="space-y-6">
                        @csrf

                        <!-- Habit Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                Habit Name *
                            </label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   value="{{ old('name') }}"
                                   class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500"
                                   placeholder="e.g., Morning Run, Read 30 Minutes, Drink 8 Glasses of Water"
                                   required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-1">
                                Category *
                            </label>
                            <select name="category" 
                                    id="category" 
                                    class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500"
                                    required>
                                <option value="">Select a category</option>
                                <option value="Health" {{ old('category') == 'Health' ? 'selected' : '' }}>Health & Fitness</option>
                                <option value="Productivity" {{ old('category') == 'Productivity' ? 'selected' : '' }}>Productivity</option>
                                <option value="Learning" {{ old('category') == 'Learning' ? 'selected' : '' }}>Learning</option>
                                <option value="Mindfulness" {{ old('category') == 'Mindfulness' ? 'selected' : '' }}>Mindfulness</option>
                                <option value="Social" {{ old('category') == 'Social' ? 'selected' : '' }}>Social</option>
                                <option value="Creative" {{ old('category') == 'Creative' ? 'selected' : '' }}>Creative</option>
                                <option value="Finance" {{ old('category') == 'Finance' ? 'selected' : '' }}>Finance</option>
                                <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('category')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                                Description (Optional)
                            </label>
                            <textarea name="description" 
                                      id="description" 
                                      rows="3"
                                      class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500"
                                      placeholder="Why is this habit important to you?">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Motivational Tips -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <h4 class="font-semibold text-blue-900 mb-2">💡 Tips for Success</h4>
                            <ul class="text-sm text-blue-800 space-y-1">
                                <li>• Start small - consistency beats intensity</li>
                                <li>• Check in at the same time every day</li>
                                <li>• Track your progress and celebrate milestones</li>
                                <li>• Don't break the chain! 🔥</li>
                            </ul>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center justify-end gap-4 pt-4 border-t">
                            <a href="{{ route('habits.index') }}" 
                               class="px-4 py-2 text-gray-700 hover:text-gray-900">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                                Create Habit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>