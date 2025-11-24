<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Shopping List
            </h2>
            <div class="flex gap-3">
                
                <a href="{{ route('meals.index') }}" 
                   class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    ← Back to Meals
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Week Info -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6 print:border-black">
                <h3 class="font-semibold text-blue-900">
                    Shopping List for Week of {{ $startOfWeek->format('M d') }} - {{ $endOfWeek->format('M d, Y') }}
                </h3>
                <p class="text-sm text-blue-700 mt-1">
                    Based on {{ $meals->count() }} planned meals
                </p>
            </div>

            @if($meals->count() > 0)
                <!-- Meals with Ingredients -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                            <span>🛒</span> Ingredients by Meal
                        </h3>

                        <div class="space-y-6">
                            @foreach($meals as $meal)
                                <div class="border-l-4 border-purple-500 pl-4 py-2">
                                    <!-- Meal Header -->
                                    <div class="mb-2">
                                        <h4 class="font-semibold text-gray-900">{{ $meal->name }}</h4>
                                        <p class="text-sm text-gray-500">
                                            <span class="capitalize">{{ $meal->meal_type }}</span> • 
                                            {{ $meal->date->format('l, M d') }}
                                        </p>
                                    </div>

                                    <!-- Ingredients -->
                                    @if($meal->ingredients)
                                        <div class="bg-gray-50 rounded p-3 print:border print:border-gray-300">
                                            <div class="whitespace-pre-line text-sm text-gray-700 space-y-1">
                                                @foreach(explode("\n", $meal->ingredients) as $ingredient)
                                                    @if(trim($ingredient))
                                                        <div class="flex items-start gap-2">
                                                            <input type="checkbox" class="mt-1 print:hidden">
                                                            <span class="print:before:content-['☐_']">{{ trim($ingredient) }}</span>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Combined Shopping List -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                            <span></span> Combined Shopping List
                        </h3>
                        <p class="text-sm text-gray-600 mb-4">
                            All ingredients from your weekly meals in one list
                        </p>

                        @php
                            // Collect all ingredients
                            $allIngredients = [];
                            foreach($meals as $meal) {
                                if($meal->ingredients) {
                                    $ingredientLines = explode("\n", $meal->ingredients);
                                    foreach($ingredientLines as $line) {
                                        $line = trim($line);
                                        if($line) {
                                            $allIngredients[] = $line;
                                        }
                                    }
                                }
                            }
                            
                            // Remove duplicates and sort
                            $allIngredients = array_unique($allIngredients);
                            sort($allIngredients);
                        @endphp

                        @if(count($allIngredients) > 0)
                            <div class="bg-gray-50 rounded p-4 print:border print:border-gray-300">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                    @foreach($allIngredients as $ingredient)
                                        <div class="flex items-start gap-2">
                                            <input type="checkbox" class="mt-1 print:hidden">
                                            <span class="text-sm text-gray-700 print:before:content-['☐_']">
                                                {{ $ingredient }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Copy to Clipboard Button -->
                            <div class="mt-4 print:hidden">
                                <button onclick="copyToClipboard()" 
                                        class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                                    Copy List to Clipboard
                                </button>
                                <span id="copy-success" class="ml-2 text-green-600 text-sm hidden">✓ Copied!</span>
                            </div>
                        @else
                            <p class="text-gray-500 text-center py-4">
                                No ingredients listed for this week's meals.
                            </p>
                        @endif
                    </div>
                </div>

                <!-- Tips -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mt-6 print:hidden">
                    <h4 class="font-semibold text-yellow-900 mb-2"> Shopping Tips</h4>
                    <ul class="text-sm text-yellow-800 space-y-1">
                        <li>• Check your pantry before shopping to avoid duplicates</li>
                        <li>• Use the checkboxes to mark items as you shop</li>
                        <li>• Print this list or copy it to your phone</li>
                        <li>• Plan meals with similar ingredients to save money</li>
                    </ul>
                </div>

            @else
                <!-- No Meals with Ingredients -->
                <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">No Ingredients Yet</h3>
                    <p class="text-gray-600 mb-4">
                        Add ingredients to your meals to generate a shopping list
                    </p>
                    <a href="{{ route('meals.index') }}" 
                       class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                        Go to Meal Planner
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Copy to Clipboard Script -->
    <script>
        function copyToClipboard() {
            const ingredients = @json($allIngredients ?? []);
            const text = ingredients.join('\n');
            
            navigator.clipboard.writeText(text).then(function() {
                // Show success message
                const successMsg = document.getElementById('copy-success');
                successMsg.classList.remove('hidden');
                setTimeout(() => {
                    successMsg.classList.add('hidden');
                }, 2000);
            }, function(err) {
                alert('Failed to copy: ' + err);
            });
        }

        // Print styles
        const style = document.createElement('style');
        style.textContent = `
            @media print {
                .print\\:hidden { display: none !important; }
                .print\\:border { border: 1px solid #000 !important; }
                .print\\:border-black { border-color: #000 !important; }
                .print\\:border-gray-300 { border-color: #d1d5db !important; }
                body { background: white !important; }
                * { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
            }
        `;
        document.head.appendChild(style);
    </script>
</x-app-layout>
```

<!-- ---

## Step 2: Test the Shopping List!

1. **Make sure you have meals with ingredients:**
   - Go to `http://localhost:8000/meals`
   - Edit a meal and add ingredients like:
```
     - 2 chicken breasts
     - 1 cup rice
     - 2 tbsp olive oil
     - 1 onion, diced -->