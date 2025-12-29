<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New Habit') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50/50 min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Breadcrumb -->
            <div class="mb-6">
                <a href="{{ route('habits.index') }}" class="flex items-center text-sm text-gray-500 hover:text-gray-900 transition">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    Back to Habits
                </a>
            </div>

            <!-- Main Card -->
            <div class="bg-white p-8 rounded-xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)]">
                
                <div class="mb-8 border-b border-gray-100 pb-4">
                    <h3 class="text-xl font-bold text-gray-900">Start a New Habit</h3>
                    <p class="text-sm text-gray-500 mt-1">Build consistency by tracking small daily wins.</p>
                </div>

                <form method="POST" action="{{ route('habits.store') }}" class="space-y-6">
                    @csrf

                    <!-- Habit Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Habit Name
                        </label>
                        <input type="text" 
                               name="name" 
                               id="name" 
                               value="{{ old('name') }}"
                               class="w-full rounded-lg border-gray-200 focus:border-gray-900 focus:ring-gray-900 transition shadow-sm placeholder-gray-400"
                               placeholder="e.g. Morning Run, Read 30 Minutes"
                               required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                            Category
                        </label>
                        <div class="relative">
                            <select name="category" 
                                    id="category" 
                                    class="w-full rounded-lg border-gray-200 focus:border-gray-900 focus:ring-gray-900 transition shadow-sm appearance-none"
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
                            <!-- Custom Chevron -->
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                        @error('category')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Description <span class="text-gray-400 font-normal">(Optional)</span>
                        </label>
                        <textarea name="description" 
                                  id="description" 
                                  rows="3"
                                  class="w-full rounded-lg border-gray-200 focus:border-gray-900 focus:ring-gray-900 transition shadow-sm placeholder-gray-400"
                                  placeholder="Why is this habit important to you?">{{ old('description') }}</textarea>
                    </div>

                    <!-- Subtle Tips Section -->
                    <div class="flex gap-3 items-start p-4 bg-gray-50 rounded-lg border border-gray-100">
                        <span class="text-lg"></span>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Tips for Success</p>
                            <ul class="text-xs text-gray-500 mt-1 space-y-1 list-disc list-inside">
                                <li>Start small - consistency beats intensity</li>
                                <li>Check in at the same time every day</li>
                                <li>Don't break the chain!</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-50">
                        <a href="{{ route('habits.index') }}" 
                           class="px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="px-6 py-2 bg-gray-900 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-gray-800 transition shadow-sm">
                            Create Habit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>