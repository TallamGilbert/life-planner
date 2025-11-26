<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Habit') }}
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
                    <h3 class="text-xl font-bold text-gray-900">Manage Habit</h3>
                    <p class="text-sm text-gray-500 mt-1">Update details or change your tracking preferences.</p>
                </div>

                <form method="POST" action="{{ route('habits.update', $habit) }}" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    <!-- Habit Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Habit Name
                        </label>
                        <input type="text" 
                               name="name" 
                               id="name" 
                               value="{{ old('name', $habit->name) }}"
                               class="w-full rounded-lg border-gray-200 focus:border-gray-900 focus:ring-gray-900 transition shadow-sm placeholder-gray-400"
                               placeholder="e.g. Read 10 pages"
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
                                    class="w-full rounded-lg border-gray-200 focus:border-gray-900 focus:ring-gray-900 transition shadow-sm appearance-none">
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
                                  placeholder="Why is this habit important?">{{ old('description', $habit->description) }}</textarea>
                    </div>

                    <!-- Status Toggle -->
                    <div class="flex items-center gap-3 p-4 border border-gray-100 rounded-lg bg-gray-50/50">
                        <div class="flex items-center h-5">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" 
                                   name="is_active" 
                                   id="is_active" 
                                   value="1"
                                   {{ $habit->is_active ? 'checked' : '' }}
                                   class="w-4 h-4 rounded border-gray-300 text-gray-900 focus:ring-gray-900 transition">
                        </div>
                        <div>
                            <label for="is_active" class="text-sm font-medium text-gray-900">Active Status</label>
                            <p class="text-xs text-gray-500">Uncheck to archive this habit without deleting history.</p>
                        </div>
                    </div>

                    <!-- Habit Stats (Read-only) -->
                    <div class="bg-white rounded-lg border border-gray-100 p-5 mt-4">
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-4">Current Progress</h4>
                        <div class="grid grid-cols-2 gap-6">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-orange-50 rounded-lg text-orange-500">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd"></path></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Current Streak</p>
                                    <p class="font-bold text-gray-900">{{ $habit->streak }} Days</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-gray-50 rounded-lg text-gray-500">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Last Completed</p>
                                    <p class="font-bold text-gray-900">{{ $habit->last_completed ? $habit->last_completed->format('M d') : 'Never' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Motivational Tip (Subtle) -->
                    <div class="flex gap-3 items-start p-4 bg-yellow-50/50 border border-yellow-100 rounded-lg">
                        <span class="text-lg">💡</span>
                        <div>
                            <p class="text-sm font-medium text-yellow-800">Pro Tip</p>
                            <p class="text-xs text-yellow-700 mt-0.5">Consistency beats intensity. It's better to do a little bit every day than a lot once a week.</p>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-between pt-6 border-t border-gray-50">
                        <button type="button" 
                                onclick="if(confirm('Are you sure you want to delete this habit?')) document.getElementById('deleteForm').submit();"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-red-200 rounded-lg text-sm font-medium text-red-600 hover:bg-red-50 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            Delete
                        </button>

                        <div class="flex gap-3">
                            <a href="{{ route('habits.index') }}" 
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

                <!-- Hidden Delete Form -->
                <form id="deleteForm" method="POST" action="{{ route('habits.destroy', $habit) }}" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </div>
</x-app-layout>