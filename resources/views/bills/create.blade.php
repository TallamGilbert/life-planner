<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create New Bill
            </h2>
            <a href="{{ route('bills.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
                ← Back to Bills
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('bills.store') }}" class="space-y-6">
                        @csrf

                        <!-- Bill Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                Bill Name *
                            </label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   value="{{ old('name') }}"
                                   class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                   placeholder="e.g., Laptop Payment, Rent, Car Loan"
                                   required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Total Amount and Installments -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Total Amount -->
                            <div>
                                <label for="total_amount" class="block text-sm font-medium text-gray-700 mb-1">
                                    Total Amount *
                                </label>
                                <div class="relative">
                                    <span class="absolute left-3 top-3 text-gray-500">$</span>
                                    <input type="number" 
                                           name="total_amount" 
                                           id="total_amount" 
                                           step="0.01" 
                                           min="0.01"
                                           value="{{ old('total_amount') }}"
                                           class="w-full pl-8 rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                           placeholder="0.00"
                                           required
                                           oninput="calculateInstallment()">
                                </div>
                                @error('total_amount')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Number of Installments -->
                            <div>
                                <label for="total_installments" class="block text-sm font-medium text-gray-700 mb-1">
                                    Number of Installments *
                                </label>
                                <input type="number" 
                                       name="total_installments" 
                                       id="total_installments" 
                                       min="1"
                                       value="{{ old('total_installments') }}"
                                       class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                       placeholder="e.g., 12"
                                       required
                                       oninput="calculateInstallment()">
                                @error('total_installments')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Installment Preview -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-sm text-blue-900 font-medium">Installment Amount</p>
                                    <p class="text-xs text-blue-700">Amount per payment</p>
                                </div>
                                <p class="text-2xl font-bold text-blue-900">
                                    $<span id="installment-preview">0.00</span>
                                </p>
                            </div>
                        </div>

                        <!-- Frequency and Start Date -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Payment Frequency -->
                            <div>
                                <label for="frequency" class="block text-sm font-medium text-gray-700 mb-1">
                                    Payment Frequency *
                                </label>
                                <select name="frequency" 
                                        id="frequency" 
                                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                        required>
                                    <option value="weekly" {{ old('frequency') == 'weekly' ? 'selected' : '' }}>Weekly</option>
                                    <option value="monthly" {{ old('frequency', 'monthly') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                    <option value="quarterly" {{ old('frequency') == 'quarterly' ? 'selected' : '' }}>Quarterly</option>
                                    <option value="yearly" {{ old('frequency') == 'yearly' ? 'selected' : '' }}>Yearly</option>
                                </select>
                                @error('frequency')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Start Date -->
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">
                                    First Payment Date *
                                </label>
                                <input type="date" 
                                       name="start_date" 
                                       id="start_date" 
                                       value="{{ old('start_date', date('Y-m-d')) }}"
                                       class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                       required>
                                @error('start_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
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
                                <option value="Electronics" {{ old('category') == 'Electronics' ? 'selected' : '' }}>Electronics</option>
                                <option value="Furniture" {{ old('category') == 'Furniture' ? 'selected' : '' }}>Furniture</option>
                                <option value="Vehicle" {{ old('category') == 'Vehicle' ? 'selected' : '' }}>Vehicle</option>
                                <option value="Education" {{ old('category') == 'Education' ? 'selected' : '' }}>Education</option>
                                <option value="Medical" {{ old('category') == 'Medical' ? 'selected' : '' }}>Medical</option>
                                <option value="Rent" {{ old('category') == 'Rent' ? 'selected' : '' }}>Rent</option>
                                <option value="Utilities" {{ old('category') == 'Utilities' ? 'selected' : '' }}>Utilities</option>
                                <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}>Other</option>
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
                                      class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                      placeholder="Any additional details...">{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Example -->
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <h4 class="font-semibold text-yellow-900 mb-2">💡 Example</h4>
                            <p class="text-sm text-yellow-800">
                                If you bought a laptop for <strong>$1,200</strong> and want to pay it in 
                                <strong>12 monthly</strong> installments, each payment would be <strong>$100/month</strong>.
                            </p>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center justify-end gap-4 pt-4 border-t">
                            <a href="{{ route('bills.index') }}" 
                               class="px-4 py-2 text-gray-700 hover:text-gray-900">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                                Create Bill
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Calculate Installment Script -->
    <script>
        function calculateInstallment() {
            const total = parseFloat(document.getElementById('total_amount').value) || 0;
            const installments = parseInt(document.getElementById('total_installments').value) || 1;
            const installmentAmount = total / installments;
            document.getElementById('installment-preview').textContent = installmentAmount.toFixed(2);
        }

        // Calculate on page load if values exist
        window.addEventListener('DOMContentLoaded', calculateInstallment);
    </script>
</x-app-layout>