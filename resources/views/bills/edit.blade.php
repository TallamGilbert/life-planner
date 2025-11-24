<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Bill
            </h2>
            <a href="{{ route('bills.show', $bill) }}" class="text-sm text-gray-600 hover:text-gray-900">
                ← Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('bills.update', $bill) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Bill Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                Bill Name *
                            </label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   value="{{ old('name', $bill->name) }}"
                                   class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                   required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-1">
                                Category (Optional)
                            </label>
                            <select name="category" 
                                    id="category" 
                                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
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
                            @error('category')
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
                                      rows="3"
                                      class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">{{ old('notes', $bill->notes) }}</textarea>
                            @error('notes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Read-only Info -->
                        <div class="bg-gray-50 rounded-lg p-4 space-y-2">
                            <p class="text-sm text-gray-600">
                                <span class="font-medium">Total Amount:</span> ${{ number_format($bill->total_amount, 2) }}
                            </p>
                            <p class="text-sm text-gray-600">
                                <span class="font-medium">Installments:</span> {{ $bill->total_installments }}
                            </p>
                            <p class="text-sm text-gray-600">
                                <span class="font-medium">Frequency:</span> {{ ucfirst($bill->frequency) }}
                            </p>
                            <p class="text-xs text-gray-500 mt-2">
                                Note: Payment details cannot be edited after creation. Only name, category, and notes can be updated.
                            </p>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center justify-between pt-4 border-t">
                            <!-- Delete Button -->
                            <div>
                                <button type="button"
                                        onclick="if(confirm('Are you sure you want to delete this bill? All payment history will be lost.')) document.getElementById('delete-form').submit();"
                                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                                    Delete Bill
                                </button>
                            </div>

                            <div class="flex items-center gap-4">
                                <a href="{{ route('bills.show', $bill) }}" 
                                   class="px-4 py-2 text-gray-700 hover:text-gray-900">
                                    Cancel
                                </a>
                                <button type="submit" 
                                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                                    Update Bill
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Form (Hidden) -->
    <form id="delete-form" 
          method="POST" 
          action="{{ route('bills.destroy', $bill) }}" 
          class="hidden">
        @csrf
        @method('DELETE')
    </form>
</x-app-layout>