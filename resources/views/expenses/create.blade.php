<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Add Transaction') }}
            </h2>
            <a href="{{ route('expenses.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
                ← Back to Transactions
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('expenses.store') }}" class="space-y-6">
                        @csrf

                        <!-- Transaction Type -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Transaction Type *
                            </label>
                            <div class="grid grid-cols-2 gap-4">
                                <label class="relative flex items-center justify-center p-4 border-2 rounded-lg cursor-pointer hover:bg-gray-50 transition"
                                       :class="type === 'expense' ? 'border-red-500 bg-red-50' : 'border-gray-300'"
                                       x-data="{ type: '{{ old('type', 'expense') }}' }">
                                    <input type="radio" name="type" value="expense" 
                                           class="sr-only" 
                                           checked
                                           @change="type = 'expense'">
                                    <div class="text-center">
                                        <svg class="w-8 h-8 mx-auto text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                        </svg>
                                        <span class="block mt-2 font-semibold text-gray-900">Expense</span>
                                    </div>
                                </label>

                                <label class="relative flex items-center justify-center p-4 border-2 rounded-lg cursor-pointer hover:bg-gray-50 transition"
                                       :class="type === 'income' ? 'border-green-500 bg-green-50' : 'border-gray-300'"
                                       x-data="{ type: '{{ old('type', 'expense') }}' }">
                                    <input type="radio" name="type" value="income" 
                                           class="sr-only"
                                           @change="type = 'income'">
                                    <div class="text-center">
                                        <svg class="w-8 h-8 mx-auto text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                                        </svg>
                                        <span class="block mt-2 font-semibold text-gray-900">Income</span>
                                    </div>
                                </label>
                            </div>
                            @error('type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                Description *
                            </label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   value="{{ old('name') }}"
                                   class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                   placeholder="e.g., Groceries, Salary, Coffee"
                                   required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Amount -->
                        <div>
                            <label for="amount" class="block text-sm font-medium text-gray-700 mb-1">
                                Amount *
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-gray-500">$</span>
                                <input type="number" 
                                       name="amount" 
                                       id="amount" 
                                       step="0.01" 
                                       min="0.01"
                                       value="{{ old('amount') }}"
                                       class="w-full pl-8 rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                       placeholder="0.00"
                                       required>
                            </div>
                            @error('amount')
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
                                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                    required>
                                <option value="">Select a category</option>
                                <optgroup label="Expense Categories">
                                    <option value="Food" {{ old('category') == 'Food' ? 'selected' : '' }}>Food & Dining</option>
                                    <option value="Transport" {{ old('category') == 'Transport' ? 'selected' : '' }}>Transportation</option>
                                    <option value="Shopping" {{ old('category') == 'Shopping' ? 'selected' : '' }}>Shopping</option>
                                    <option value="Entertainment" {{ old('category') == 'Entertainment' ? 'selected' : '' }}>Entertainment</option>
                                    <option value="Bills" {{ old('category') == 'Bills' ? 'selected' : '' }}>Bills & Utilities</option>
                                    <option value="Health" {{ old('category') == 'Health' ? 'selected' : '' }}>Health & Fitness</option>
                                    <option value="Education" {{ old('category') == 'Education' ? 'selected' : '' }}>Education</option>
                                    <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}>Other</option>
                                </optgroup>
                                <optgroup label="Income Categories">
                                    <option value="Salary" {{ old('category') == 'Salary' ? 'selected' : '' }}>Salary</option>
                                    <option value="Freelance" {{ old('category') == 'Freelance' ? 'selected' : '' }}>Freelance</option>
                                    <option value="Investment" {{ old('category') == 'Investment' ? 'selected' : '' }}>Investment</option>
                                    <option value="Gift" {{ old('category') == 'Gift' ? 'selected' : '' }}>Gift</option>
                                    <option value="Other Income" {{ old('category') == 'Other Income' ? 'selected' : '' }}>Other Income</option>
                                </optgroup>
                            </select>
                            @error('category')
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
                                   value="{{ old('date', date('Y-m-d')) }}"
                                   class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                   required>
                            @error('date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description (Optional) -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                                Notes (Optional)
                            </label>
                            <textarea name="description" 
                                      id="description" 
                                      rows="3"
                                      class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                      placeholder="Add any additional notes...">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center justify-end gap-4 pt-4 border-t">
                            <a href="{{ route('expenses.index') }}" 
                               class="px-4 py-2 text-gray-700 hover:text-gray-900">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                Add Transaction
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>