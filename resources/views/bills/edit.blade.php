<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Bill') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50/50 min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Breadcrumb -->
            <div class="mb-6">
                <a href="{{ route('bills.show', $bill) }}" class="flex items-center text-sm text-gray-500 hover:text-gray-900 transition">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    Back to Bill Details
                </a>
            </div>

            <!-- Main Card -->
            <div class="bg-white p-8 rounded-xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)]">
                
                <div class="mb-8 border-b border-gray-100 pb-4">
                    <h3 class="text-xl font-bold text-gray-900">Update Bill Details</h3>
                    <p class="text-sm text-gray-500 mt-1">Modify the basic information for this bill.</p>
                </div>

                <form method="POST" action="{{ route('bills.update', $bill) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Bill Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Bill Name
                        </label>
                        <input type="text" 
                               name="name" 
                               id="name" 
                               value="{{ old('name', $bill->name) }}"
                               class="w-full rounded-lg border-gray-200 focus:border-gray-900 focus:ring-gray-900 transition shadow-sm placeholder-gray-400"
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
                                <option value="">Select category</option>
                                <option value="Electronics" {{ old('category', $bill->category) == 'Electronics' ? 'selected' : '' }}>Electronics</option>
                                <option value="Furniture" {{ old('category', $bill->category) == 'Furniture' ? 'selected' : '' }}>Furniture</option>
                                <option value="Vehicle" {{ old('category', $bill->category) == 'Vehicle' ? 'selected' : '' }}>Vehicle</option>
                                <option value="Education" {{ old('category', $bill->category) == 'Education' ? 'selected' : '' }}>Education</option>
                                <option value="Medical" {{ old('category', $bill->category) == 'Medical' ? 'selected' : '' }}>Medical</option>
                                <option value="Rent" {{ old('category', $bill->category) == 'Rent' ? 'selected' : '' }}>Rent</option>
                                <option value="Utilities" {{ old('category', $bill->category) == 'Utilities' ? 'selected' : '' }}>Utilities</option>
                                <option value="Other" {{ old('category', $bill->category) == 'Other' ? 'selected' : '' }}>Other</option>
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

                    <!-- Notes -->
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                            Notes <span class="text-gray-400 font-normal">(Optional)</span>
                        </label>
                        <textarea name="notes" 
                                  id="notes" 
                                  rows="3"
                                  class="w-full rounded-lg border-gray-200 focus:border-gray-900 focus:ring-gray-900 transition shadow-sm placeholder-gray-400"
                                  placeholder="Add any specific details about this bill...">{{ old('notes', $bill->notes) }}</textarea>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Read-only Info Block -->
                    <div class="bg-blue-50/50 rounded-lg border border-blue-100 p-4">
                        <div class="flex items-start gap-3">
                            <div class="p-1 bg-blue-100 rounded text-blue-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-sm font-bold text-gray-900 mb-2">Locked Payment Details</h4>
                                <div class="grid grid-cols-3 gap-4 text-sm">
                                    <div>
                                        <p class="text-xs text-gray-500">Total Amount</p>
                                        <p class="font-medium text-gray-900">Ksh {{ number_format($bill->total_amount, 2) }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Installments</p>
                                        <p class="font-medium text-gray-900">{{ $bill->total_installments }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Frequency</p>
                                        <p class="font-medium text-gray-900">{{ ucfirst($bill->frequency) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-between pt-6 border-t border-gray-50">
                        <!-- Delete Button -->
                        <button type="button"
                                onclick="if(confirm('Are you sure you want to delete this bill? All payment history will be lost.')) document.getElementById('delete-form').submit();"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-red-200 rounded-lg text-sm font-medium text-red-600 hover:bg-red-50 hover:border-red-300 transition shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            Delete
                        </button>

                        <div class="flex items-center gap-3">
                            <a href="{{ route('bills.show', $bill) }}" 
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
        </div>
    </div>

    <!-- Hidden Delete Form -->
    <form id="delete-form" 
          method="POST" 
          action="{{ route('bills.destroy', $bill) }}" 
          class="hidden">
        @csrf
        @method('DELETE')
    </form>
</x-app-layout>