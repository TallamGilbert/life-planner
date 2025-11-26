<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    {{ __('Create New Bill') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Set up a recurring payment or installment plan.</p>
            </div>
            <a href="{{ route('bills.index') }}" 
               class="text-sm font-medium text-gray-500 hover:text-gray-900 flex items-center gap-2 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Bills
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50/50 min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-8">
                    <form method="POST" action="{{ route('bills.store') }}" class="space-y-6">
                        @csrf

                        <!-- Bill Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                Bill Name
                            </label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   value="{{ old('name') }}"
                                   class="w-full rounded-lg border-gray-200 bg-gray-50 focus:bg-white focus:border-gray-900 focus:ring-0 transition duration-200"
                                   placeholder="e.g. Laptop Loan, Annual Rent, School Fees"
                                   required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Amount & Installments Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Total Amount -->
                            <div>
                                <label for="total_amount" class="block text-sm font-medium text-gray-700 mb-1">
                                    Total Amount
                                </label>
                                <div class="relative">
                                    <span class="absolute left-3 top-2.5 text-gray-500 font-medium">Ksh</span>
                                    <input type="number" 
                                           name="total_amount" 
                                           id="total_amount" 
                                           step="0.01" 
                                           min="0.01"
                                           value="{{ old('total_amount') }}"
                                           class="w-full pl-12 rounded-lg border-gray-200 bg-gray-50 focus:bg-white focus:border-gray-900 focus:ring-0 transition duration-200"
                                           placeholder="0.00"
                                           required
                                           oninput="calculateInstallment()">
                                </div>
                                @error('total_amount')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Installments -->
                            <div>
                                <label for="total_installments" class="block text-sm font-medium text-gray-700 mb-1">
                                    Total Installments
                                </label>
                                <div class="relative">
                                    <input type="number" 
                                           name="total_installments" 
                                           id="total_installments" 
                                           min="1"
                                           value="{{ old('total_installments') }}"
                                           class="w-full rounded-lg border-gray-200 bg-gray-50 focus:bg-white focus:border-gray-900 focus:ring-0 transition duration-200"
                                           placeholder="e.g. 12"
                                           required
                                           oninput="calculateInstallment()">
                                     <span class="absolute right-3 top-2.5 text-gray-400 text-sm">payments</span>
                                </div>
                                @error('total_installments')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Live Calculation Preview -->
                        <div class="bg-gray-900 rounded-xl p-6 text-white shadow-lg transform transition-all" id="preview-box">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-gray-400 text-xs uppercase tracking-wider font-semibold">Estimated Payment</p>
                                    <p class="text-sm text-gray-500 mt-1">Per installment</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-3xl font-bold tracking-tight">
                                        <span class="text-lg text-gray-500 font-normal">Ksh</span> 
                                        <span id="installment-preview">0.00</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Frequency & Date -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Frequency -->
                            <div>
                                <label for="frequency" class="block text-sm font-medium text-gray-700 mb-1">
                                    Frequency
                                </label>
                                <div class="relative">
                                    <select name="frequency" 
                                            id="frequency" 
                                            class="w-full appearance-none rounded-lg border-gray-200 bg-gray-50 focus:bg-white focus:border-gray-900 focus:ring-0 transition duration-200"
                                            required>
                                        <option value="weekly" {{ old('frequency') == 'weekly' ? 'selected' : '' }}>Weekly</option>
                                        <option value="monthly" {{ old('frequency', 'monthly') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                        <option value="quarterly" {{ old('frequency') == 'quarterly' ? 'selected' : '' }}>Quarterly</option>
                                        <option value="yearly" {{ old('frequency') == 'yearly' ? 'selected' : '' }}>Yearly</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Start Date -->
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">
                                    First Due Date
                                </label>
                                <input type="date" 
                                       name="start_date" 
                                       id="start_date" 
                                       value="{{ old('start_date', date('Y-m-d')) }}"
                                       class="w-full rounded-lg border-gray-200 bg-gray-50 focus:bg-white focus:border-gray-900 focus:ring-0 transition duration-200 text-gray-600"
                                       required>
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
                                        class="w-full appearance-none rounded-lg border-gray-200 bg-gray-50 focus:bg-white focus:border-gray-900 focus:ring-0 transition duration-200">
                                    <option value="" class="text-gray-400">Select category (Optional)</option>
                                    <option value="Rent">🏠 Rent</option>
                                    <option value="Electronics">💻 Electronics</option>
                                    <option value="Furniture">🪑 Furniture</option>
                                    <option value="Vehicle">🚗 Vehicle</option>
                                    <option value="Education">📚 Education</option>
                                    <option value="Medical">🏥 Medical</option>
                                    <option value="Utilities">⚡ Utilities</option>
                                    <option value="Other">🔹 Other</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">
                                Notes
                            </label>
                            <textarea name="notes" 
                                      id="notes" 
                                      rows="3"
                                      class="w-full rounded-lg border-gray-200 bg-gray-50 focus:bg-white focus:border-gray-900 focus:ring-0 transition duration-200"
                                      placeholder="Add details about lender or terms...">{{ old('notes') }}</textarea>
                        </div>

                        <!-- Helpful Tip -->
                        <div class="flex items-start gap-3 p-4 bg-gray-50 rounded-lg border border-gray-100">
                            <div class="text-yellow-500 mt-0.5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <p class="text-sm text-gray-600 leading-relaxed">
                                <strong>Tip:</strong> The system will automatically track payments. If you enter a Total Amount of Ksh 120,000 over 12 installments, we'll remind you to pay Ksh 10,000 each time.
                            </p>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-100">
                            <a href="{{ route('bills.index') }}" 
                               class="text-sm font-medium text-gray-500 hover:text-gray-900 transition">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="px-8 py-2.5 bg-gray-900 text-white font-medium rounded-lg hover:bg-gray-800 transition shadow-sm hover:shadow-md">
                                Create Bill
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Live Calculation Script -->
    <script>
        function calculateInstallment() {
            const total = parseFloat(document.getElementById('total_amount').value) || 0;
            const installments = parseInt(document.getElementById('total_installments').value) || 1;
            
            // Avoid division by zero
            const divisor = installments > 0 ? installments : 1;
            const installmentAmount = total / divisor;
            
            // Update the DOM
            document.getElementById('installment-preview').textContent = installmentAmount.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }

        // Initialize on load in case of validation errors returning old data
        window.addEventListener('DOMContentLoaded', calculateInstallment);
    </script>
</x-app-layout>