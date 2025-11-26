<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    {{ __('New Transaction') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Record a new income or expense.</p>
            </div>
            <a href="{{ route('expenses.index') }}" 
               class="text-sm font-medium text-gray-500 hover:text-gray-900 flex items-center gap-2 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Transactions
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50/50 min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-8">
                    <form method="POST" action="{{ route('expenses.store') }}" class="space-y-6" x-data="{ type: '{{ old('type', 'expense') }}' }">
                        @csrf

                        <!-- Transaction Type (Visual Selector) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                Transaction Type
                            </label>
                            <div class="grid grid-cols-2 gap-4">
                                <!-- Hidden Input to store value -->
                                <input type="hidden" name="type" x-model="type">

                                <!-- Expense Option -->
                                <div @click="type = 'expense'" 
                                     class="cursor-pointer relative flex flex-col items-center justify-center p-4 rounded-xl border-2 transition-all duration-200 group"
                                     :class="type === 'expense' ? 'border-red-100 bg-red-50/50' : 'border-gray-100 hover:border-gray-200 hover:bg-gray-50'">
                                    
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center mb-2 transition-colors duration-200"
                                         :class="type === 'expense' ? 'bg-red-100 text-red-600' : 'bg-gray-100 text-gray-400 group-hover:text-gray-600'">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                                    </div>
                                    <span class="font-semibold text-sm transition-colors" 
                                          :class="type === 'expense' ? 'text-red-900' : 'text-gray-500'">Expense</span>
                                    
                                    <!-- Checkmark for active state -->
                                    <div x-show="type === 'expense'" class="absolute top-3 right-3 text-red-600">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                    </div>
                                </div>

                                <!-- Income Option -->
                                <div @click="type = 'income'" 
                                     class="cursor-pointer relative flex flex-col items-center justify-center p-4 rounded-xl border-2 transition-all duration-200 group"
                                     :class="type === 'income' ? 'border-green-100 bg-green-50/50' : 'border-gray-100 hover:border-gray-200 hover:bg-gray-50'">
                                    
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center mb-2 transition-colors duration-200"
                                         :class="type === 'income' ? 'bg-green-100 text-green-600' : 'bg-gray-100 text-gray-400 group-hover:text-gray-600'">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    </div>
                                    <span class="font-semibold text-sm transition-colors" 
                                          :class="type === 'income' ? 'text-green-900' : 'text-gray-500'">Income</span>

                                    <!-- Checkmark for active state -->
                                    <div x-show="type === 'income'" class="absolute top-3 right-3 text-green-600">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                Description
                            </label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   value="{{ old('name') }}"
                                   class="w-full rounded-lg border-gray-200 bg-gray-50 focus:bg-white focus:border-gray-900 focus:ring-0 transition duration-200"
                                   placeholder="e.g. Weekly Groceries"
                                   required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Amount & Date Row -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Amount -->
                            <div>
                                <label for="amount" class="block text-sm font-medium text-gray-700 mb-1">
                                    Amount
                                </label>
                                <div class="relative">
                                    <span class="absolute left-3 top-2.5 text-gray-500 font-medium">Ksh</span>
                                    <input type="number" 
                                           name="amount" 
                                           id="amount" 
                                           step="0.01" 
                                           min="0.01"
                                           value="{{ old('amount') }}"
                                           class="w-full pl-12 rounded-lg border-gray-200 bg-gray-50 focus:bg-white focus:border-gray-900 focus:ring-0 transition duration-200"
                                           placeholder="0.00"
                                           required>
                                </div>
                                @error('amount')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Date -->
                            <div>
                                <label for="date" class="block text-sm font-medium text-gray-700 mb-1">
                                    Date
                                </label>
                                <input type="date" 
                                       name="date" 
                                       id="date" 
                                       value="{{ old('date', date('Y-m-d')) }}"
                                       class="w-full rounded-lg border-gray-200 bg-gray-50 focus:bg-white focus:border-gray-900 focus:ring-0 transition duration-200 text-gray-600"
                                       required>
                                @error('date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Category -->
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-1">
                                Category
                            </label>
                            <div class="relative">
                                <select name="category" 
                                        id="category" 
                                        class="w-full appearance-none rounded-lg border-gray-200 bg-gray-50 focus:bg-white focus:border-gray-900 focus:ring-0 transition duration-200"
                                        required>
                                    <option value="" class="text-gray-400">Select a category...</option>
                                    <optgroup label="Expenses">
                                        <option value="Food" {{ old('category') == 'Food' ? 'selected' : '' }}> Food & Dining</option>
                                        <option value="Transport" {{ old('category') == 'Transport' ? 'selected' : '' }}> Transportation</option>
                                        <option value="Shopping" {{ old('category') == 'Shopping' ? 'selected' : '' }}> Shopping</option>
                                        <option value="Entertainment" {{ old('category') == 'Entertainment' ? 'selected' : '' }}>🎬 Entertainment</option>
                                        <option value="Bills" {{ old('category') == 'Bills' ? 'selected' : '' }}> Bills & Utilities</option>
                                        <option value="Health" {{ old('category') == 'Health' ? 'selected' : '' }}> Health</option>
                                        <option value="Education" {{ old('category') == 'Education' ? 'selected' : '' }}> Education</option>
                                        <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}>🔹 Other</option>
                                    </optgroup>
                                    <optgroup label="Income">
                                        <option value="Salary" {{ old('category') == 'Salary' ? 'selected' : '' }}> Salary</option>
                                        <option value="Freelance" {{ old('category') == 'Freelance' ? 'selected' : '' }}> Freelance</option>
                                        <option value="Investment" {{ old('category') == 'Investment' ? 'selected' : '' }}> Investment</option>
                                        <option value="Gift" {{ old('category') == 'Gift' ? 'selected' : '' }}> Gift</option>
                                    </optgroup>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                            @error('category')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Notes (Optional) -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                                Notes <span class="text-gray-400 font-normal">(Optional)</span>
                            </label>
                            <textarea name="description" 
                                      id="description" 
                                      rows="3"
                                      class="w-full rounded-lg border-gray-200 bg-gray-50 focus:bg-white focus:border-gray-900 focus:ring-0 transition duration-200"
                                      placeholder="Add any additional details...">{{ old('description') }}</textarea>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-100">
                            <a href="{{ route('expenses.index') }}" 
                               class="text-sm font-medium text-gray-500 hover:text-gray-900 transition">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="px-8 py-2.5 bg-gray-900 text-white font-medium rounded-lg hover:bg-gray-800 transition shadow-sm hover:shadow-md">
                                Save Transaction
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>