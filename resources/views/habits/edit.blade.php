<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Habit: ' . $habit->name) }}
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
                    <form method="POST" action="{{ route('habits.update', $habit) }}" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <!-- Habit Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                Habit Name *
                            </label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   value="{{ old('name', $habit->name) }}"
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
                                <option value="Health" {{ old('category', $habit->category) == 'Health' ? 'selected' : '' }}>Health & Fitness</option>
                                <option value="Productivity" {{ old('category', $habit->category) == 'Productivity' ? 'selected' : '' }}>Productivity</option>
                                <option value="Learning" {{ old('category', $habit->category) == 'Learning' ? 'selected' : '' }}>Learning</option>
                                <option value="Mindfulness" {{ old('category', $habit->category) == 'Mindfulness' ? 'selected' : '' }}>Mindfulness</option>
                                <option value="Social" {{ old('category', $habit->category) == 'Social' ? 'selected' : '' }}>Social</option>
                                <option value="Creative" {{ old('category', $habit->category) == 'Creative' ? 'selected' : '' }}>Creative</option>
                                <option value="Finance" {{ old('category', $habit->category) == 'Finance' ? 'selected' : '' }}>Finance</option>
                                <option value="Other" {{ old('category', $habit->category) == 'Other' ? 'selected' : '' }}>Other</option>
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
                                      placeholder="Why is this habit important to you?">{{ old('description', $habit->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Habit Stats (Read-Only) -->
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                            <h4 class="font-semibold text-gray-900 mb-3">📊 Habit Statistics</h4>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-xs text-gray-600">Current Streak</p>
                                    <p class="text-2xl font-bold text-orange-600">{{ $habit->streak }} 🔥</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-600">Best Streak</p>
                                    <p class="text-2xl font-bold text-red-600">{{ $habit->longest_streak }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-600">Created</p>
                                    <p class="text-sm text-gray-700">{{ $habit->created_at->format('M d, Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-600">Last Completed</p>
                                    <p class="text-sm text-gray-700">
                                        @if($habit->last_completed)
                                            {{ $habit->last_completed->format('M d, Y') }}
                                        @else
                                            Not yet
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Status Toggle -->
                        <div class="flex items-center">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" 
                                   name="is_active" 
                                   id="is_active" 
                                   value="1"
                                   {{ $habit->is_active ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                            <label for="is_active" class="ml-2 text-sm font-medium text-gray-700">
                                Keep this habit active
                            </label>
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
                        <div class="flex items-center justify-between pt-4 border-t">
                            <div>
                                <button type="button" 
                                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition"
                                        onclick="return confirm('Are you sure you want to delete this habit? This action cannot be undone.') && document.getElementById('deleteForm').submit();">
                                    Delete Habit
                                </button>
                            </div>
                            <div class="flex gap-4">
                                <a href="{{ route('habits.index') }}" 
                                   class="px-4 py-2 text-gray-700 hover:text-gray-900">
                                    Cancel
                                </a>
                                <button type="submit" 
                                        class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                                    Save Changes
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Delete Form (Separate, Hidden) -->
                    <form id="deleteForm" method="POST" action="{{ route('habits.destroy', $habit) }}" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
