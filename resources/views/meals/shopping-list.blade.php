<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Shopping List') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50/50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Header & Actions -->
            <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4 print:hidden">
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">Weekly Groceries</h3>
                    <p class="text-gray-500 text-sm mt-1">
                        {{ $startOfWeek->format('M d') }} - {{ $endOfWeek->format('M d, Y') }}
                    </p>
                </div>
                
                <div class="flex gap-3">
                    <button onclick="window.print()" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition shadow-sm">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        Print
                    </button>
                    <a href="{{ route('meals.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition shadow-sm">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Back to Planner
                    </a>
                </div>
            </div>

            @if($meals->count() > 0)
                
                @php
                    // Logic to collect and sort ingredients
                    $allIngredients = [];
                    foreach($meals as $meal) {
                        if($meal->ingredients) {
                            $lines = explode("\n", $meal->ingredients);
                            foreach($lines as $line) {
                                if(trim($line)) $allIngredients[] = trim($line);
                            }
                        }
                    }
                    $allIngredients = array_unique($allIngredients);
                    sort($allIngredients);
                @endphp

                <!-- 1. Master List Card -->
                <div class="bg-white rounded-xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] overflow-hidden mb-8 print:shadow-none print:border-gray-300">
                    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-gray-50 rounded-lg text-gray-600 print:hidden">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">Master Shopping List</h4>
                                <p class="text-xs text-gray-500">{{ count($allIngredients) }} items total</p>
                            </div>
                        </div>
                        
                        <!-- Copy Button -->
                        @if(count($allIngredients) > 0)
                            <button onclick="copyToClipboard()" class="print:hidden text-xs font-medium text-gray-500 hover:text-gray-900 flex items-center gap-1 transition">
                                <span id="copy-text">Copy to clipboard</span>
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                            </button>
                        @endif
                    </div>

                    <div class="p-6 bg-white">
                        @if(count($allIngredients) > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-3 gap-x-8">
                                @foreach($allIngredients as $ingredient)
                                    <label class="flex items-start gap-3 p-2 hover:bg-gray-50 rounded-lg transition cursor-pointer group">
                                        <input type="checkbox" class="mt-1 rounded border-gray-300 text-gray-900 focus:ring-gray-900 transition cursor-pointer">
                                        <span class="text-sm text-gray-700 group-hover:text-gray-900 font-medium">{{ $ingredient }}</span>
                                    </label>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-6 text-gray-400 text-sm">
                                <p>No ingredients found. Add ingredients to your meals to populate this list.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- 2. Breakdown by Meal (Accordion Style) -->
                <div class="bg-white rounded-xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] overflow-hidden print:shadow-none print:border-gray-300 print:mt-8">
                    <div class="p-6 border-b border-gray-100">
                        <h4 class="font-bold text-gray-900">Breakdown by Meal</h4>
                        <p class="text-xs text-gray-500 mt-1">Check your pantry against specific recipes.</p>
                    </div>
                    
                    <div class="divide-y divide-gray-50">
                        @foreach($meals as $meal)
                            <div class="p-5 hover:bg-gray-50/50 transition">
                                <div class="flex justify-between items-start mb-3">
                                    <div>
                                        <h5 class="text-sm font-bold text-gray-900">{{ $meal->name }}</h5>
                                        <div class="flex items-center gap-2 mt-0.5">
                                            <span class="text-xs text-gray-500 capitalize">{{ $meal->meal_type }}</span>
                                            <span class="text-gray-300">•</span>
                                            <span class="text-xs text-gray-500">{{ $meal->date->format('D, M d') }}</span>
                                        </div>
                                    </div>
                                    @if(!$meal->ingredients)
                                        <span class="text-[10px] bg-gray-100 text-gray-400 px-2 py-1 rounded">No ingredients</span>
                                    @endif
                                </div>

                                @if($meal->ingredients)
                                    <div class="pl-4 border-l-2 border-gray-100">
                                        <ul class="space-y-1">
                                            @foreach(explode("\n", $meal->ingredients) as $item)
                                                @if(trim($item))
                                                    <li class="text-xs text-gray-600 flex items-center gap-2">
                                                        <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                                        {{ trim($item) }}
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Pro Tip Card -->
                <div class="mt-8 flex gap-3 items-start p-4 bg-gray-900 rounded-xl text-gray-400 print:hidden">
                    <span class="text-lg">💡</span>
                    <div>
                        <p class="text-sm font-bold text-white">Smart Shopping</p>
                        <p class="text-xs mt-1">Cross-reference the "Breakdown by Meal" section with your pantry before you leave. Use the "Master List" while you are at the store for efficiency.</p>
                    </div>
                </div>

            @else
                <!-- Empty State -->
                <div class="bg-white rounded-xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] p-12 text-center">
                    <div class="mx-auto w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">Your cart is empty</h3>
                    <p class="text-gray-500 text-sm mt-1 max-w-sm mx-auto">
                        Add meals with ingredients to your planner to automatically generate your shopping list.
                    </p>
                    <a href="{{ route('meals.create') }}" class="mt-6 inline-flex items-center gap-2 px-5 py-2.5 bg-gray-900 text-white rounded-lg text-sm font-medium hover:bg-gray-800 transition">
                        Add First Meal
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Scripts -->
    <script>
        function copyToClipboard() {
            const ingredients = @json($allIngredients ?? []);
            const text = ingredients.join('\n');
            
            navigator.clipboard.writeText(text).then(function() {
                const btnText = document.getElementById('copy-text');
                const originalText = btnText.innerText;
                
                btnText.innerText = 'Copied!';
                btnText.classList.add('text-green-600', 'font-bold');
                
                setTimeout(() => {
                    btnText.innerText = originalText;
                    btnText.classList.remove('text-green-600', 'font-bold');
                }, 2000);
            }, function(err) {
                alert('Failed to copy');
            });
        }
    </script>
    
    <style>
        @media print {
            body { background: white !important; }
            nav, header { display: none !important; }
        }
    </style>
</x-app-layout>