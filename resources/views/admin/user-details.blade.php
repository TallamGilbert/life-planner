<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 tracking-tight">
                    User Profile
                </h2>
                <p class="text-sm text-gray-500 mt-1">Managing account details for {{ $user->name }}</p>
            </div>
            <a href="{{ route('admin.users') }}" 
               class="group inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-700 hover:border-gray-300 hover:text-gray-900 hover:bg-gray-50 transition shadow-sm">
                <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Directory
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- User Profile Header Card -->
            <div class="bg-white rounded-2xl border border-gray-200/60 shadow-sm p-6 md:p-8">
                <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
                    <!-- Avatar -->
                    <div class="w-20 h-20 md:w-24 md:h-24 bg-gradient-to-br from-gray-800 to-gray-900 rounded-2xl flex items-center justify-center text-white text-3xl md:text-4xl font-bold shadow-md shrink-0 ring-4 ring-gray-50">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    
                    <!-- User Info -->
                    <div class="flex-1 min-w-0 space-y-2">
                        <div class="flex flex-wrap items-center gap-3">
                            <h3 class="text-2xl font-bold text-gray-900 truncate">{{ $user->name }}</h3>
                            @if($user->is_admin)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-50 text-purple-700 border border-purple-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-purple-500"></span>
                                    Administrator
                                </span>
                            @endif
                            @if($user->is_demo)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                    Demo Account
                                </span>
                            @endif
                        </div>
                        
                        <div class="flex flex-col sm:flex-row sm:items-center gap-4 text-sm text-gray-500">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                {{ $user->email }}
                            </div>
                            <div class="hidden sm:block w-1 h-1 bg-gray-300 rounded-full"></div>
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                Joined {{ $user->created_at->format('M d, Y') }}
                            </div>
                        </div>
                    </div>

                    <!-- Admin Actions -->
                    @if($user->id !== auth()->id())
                    <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto border-t md:border-t-0 md:border-l border-gray-100 md:pl-6 pt-4 md:pt-0">
                        @if(!$user->is_admin)
                            <form method="POST" action="{{ route('admin.users.make-admin', $user) }}">
                                @csrf
                                <button type="submit" class="w-full md:w-auto px-4 py-2.5 bg-purple-50 text-purple-700 hover:bg-purple-100 hover:text-purple-800 border border-purple-100 rounded-xl text-sm font-semibold transition flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                    Grant Admin
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('admin.users.remove-admin', $user) }}">
                                @csrf
                                <button type="submit" class="w-full md:w-auto px-4 py-2.5 bg-white text-amber-600 hover:bg-amber-50 border border-gray-200 rounded-xl text-sm font-semibold transition flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                    Revoke Admin
                                </button>
                            </form>
                        @endif

                        @if(!$user->is_admin)
                            <form method="POST" action="{{ route('admin.users.delete', $user) }}" onsubmit="return confirm('Are you sure? This is permanent.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full md:w-auto px-4 py-2.5 bg-white text-red-600 hover:bg-red-50 border border-gray-200 rounded-xl text-sm font-semibold transition flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Delete
                                </button>
                            </form>
                        @endif
                    </div>
                    @endif
                </div>
            </div>

            <!-- Stats Overview Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Expenses Stats -->
                <div class="group bg-white p-6 rounded-2xl border border-gray-200/60 shadow-sm hover:shadow-md transition-all duration-200">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-2 bg-blue-50 text-blue-600 rounded-xl group-hover:bg-blue-600 group-hover:text-white transition-colors duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <span class="text-xs font-medium text-gray-400 uppercase tracking-wider">Expenses</span>
                    </div>
                    <p class="text-2xl font-bold text-gray-900 tracking-tight">{{ $user->expenses->count() }}</p>
                    <div class="mt-2 text-xs text-gray-500 flex items-center gap-1">
                        <span>Total:</span>
                        <span class="font-semibold text-gray-900">Ksh {{ number_format($user->expenses->sum('amount')) }}</span>
                    </div>
                </div>

                <!-- Habits Stats -->
                <div class="group bg-white p-6 rounded-2xl border border-gray-200/60 shadow-sm hover:shadow-md transition-all duration-200">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-2 bg-emerald-50 text-emerald-600 rounded-xl group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <span class="text-xs font-medium text-gray-400 uppercase tracking-wider">Habits</span>
                    </div>
                    <p class="text-2xl font-bold text-gray-900 tracking-tight">{{ $user->habits->count() }}</p>
                    <div class="mt-2 text-xs text-gray-500 flex items-center gap-1">
                        <span>Cum. Streak:</span>
                        <span class="font-semibold text-gray-900">{{ $user->habits->sum('streak') }} days</span>
                    </div>
                </div>

                <!-- Meals Stats -->
                <div class="group bg-white p-6 rounded-2xl border border-gray-200/60 shadow-sm hover:shadow-md transition-all duration-200">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-2 bg-purple-50 text-purple-600 rounded-xl group-hover:bg-purple-600 group-hover:text-white transition-colors duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <span class="text-xs font-medium text-gray-400 uppercase tracking-wider">Meals</span>
                    </div>
                    <p class="text-2xl font-bold text-gray-900 tracking-tight">{{ $user->meals->count() }}</p>
                    <div class="mt-2 text-xs text-gray-500">
                        Total meals recorded
                    </div>
                </div>

                <!-- Bills Stats -->
                <div class="group bg-white p-6 rounded-2xl border border-gray-200/60 shadow-sm hover:shadow-md transition-all duration-200">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-2 bg-amber-50 text-amber-600 rounded-xl group-hover:bg-amber-600 group-hover:text-white transition-colors duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <span class="text-xs font-medium text-gray-400 uppercase tracking-wider">Bills</span>
                    </div>
                    <p class="text-2xl font-bold text-gray-900 tracking-tight">{{ $user->bills->count() }}</p>
                    <div class="mt-2 text-xs text-gray-500 flex items-center gap-1">
                        <span>Outstanding:</span>
                        <span class="font-semibold text-gray-900">Ksh {{ number_format($user->bills->sum('remaining_amount')) }}</span>
                    </div>
                </div>
            </div>

            <!-- Detailed Activity Section -->
            <div class="bg-white rounded-2xl border border-gray-200/60 shadow-sm overflow-hidden min-h-[500px]" x-data="{ tab: 'expenses' }">
                
                <!-- Tab Navigation -->
                <div class="border-b border-gray-100 bg-white px-6">
                    <nav class="flex space-x-8" aria-label="Tabs">
                        <button @click="tab = 'expenses'" 
                                :class="tab === 'expenses' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="whitespace-nowrap py-4 border-b-2 font-medium text-sm transition-colors duration-200">
                            Expense History
                        </button>
                        <button @click="tab = 'habits'" 
                                :class="tab === 'habits' ? 'border-emerald-500 text-emerald-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="whitespace-nowrap py-4 border-b-2 font-medium text-sm transition-colors duration-200">
                            Habit Tracker
                        </button>
                        <button @click="tab = 'meals'" 
                                :class="tab === 'meals' ? 'border-purple-500 text-purple-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="whitespace-nowrap py-4 border-b-2 font-medium text-sm transition-colors duration-200">
                            Meal Plans
                        </button>
                        <button @click="tab = 'bills'" 
                                :class="tab === 'bills' ? 'border-amber-500 text-amber-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="whitespace-nowrap py-4 border-b-2 font-medium text-sm transition-colors duration-200">
                            Bills & Debts
                        </button>
                    </nav>
                </div>

                <!-- Tab Panels -->
                <div class="p-6 bg-gray-50/30">
                    
                    <!-- Expenses Panel -->
                    <div x-show="tab === 'expenses'" class="space-y-3" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                        @forelse($user->expenses->sortByDesc('date')->take(10) as $expense)
                            <div class="flex items-center justify-between p-4 bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md hover:border-blue-100 transition-all duration-200 group">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0 border {{ $expense->type === 'income' ? 'bg-emerald-50 border-emerald-100 text-emerald-600' : 'bg-gray-50 border-gray-100 text-gray-500' }}">
                                        @if($expense->type === 'income')
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path></svg>
                                        @else
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path></svg>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-gray-900 group-hover:text-blue-600 transition">{{ $expense->name }}</p>
                                        <p class="text-xs text-gray-400 mt-0.5">{{ $expense->category }} • {{ $expense->date->format('M d, Y') }}</p>
                                    </div>
                                </div>
                                <span class="text-sm font-bold {{ $expense->type === 'income' ? 'text-emerald-600' : 'text-gray-900' }}">
                                    {{ $expense->type === 'income' ? '+' : '-' }} Ksh {{ number_format($expense->amount) }}
                                </span>
                            </div>
                        @empty
                            <div class="flex flex-col items-center justify-center py-12 text-center">
                                <div class="p-4 rounded-full bg-gray-100 text-gray-400 mb-3">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path></svg>
                                </div>
                                <p class="text-gray-500 text-sm font-medium">No expenses recorded yet.</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Habits Panel -->
                    <div x-show="tab === 'habits'" style="display: none;" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            @forelse($user->habits as $habit)
                                <div class="p-5 bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md hover:border-emerald-200 transition-all duration-200 group">
                                    <div class="flex justify-between items-start mb-3">
                                        <div>
                                            <p class="font-bold text-gray-900 group-hover:text-emerald-600 transition">{{ $habit->name }}</p>
                                            <p class="text-[10px] text-gray-400 uppercase tracking-wider mt-1 font-bold">{{ $habit->category }}</p>
                                        </div>
                                        <div class="flex items-center gap-1.5 bg-amber-50 px-2 py-1 rounded-md text-amber-700 text-xs font-bold border border-amber-100">
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd"></path></svg>
                                            <span>{{ $habit->streak }}</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2 pt-3 border-t border-gray-50">
                                        <div class="flex-1 bg-gray-100 h-1.5 rounded-full overflow-hidden">
                                            <div class="bg-emerald-500 h-full rounded-full" style="width: 100%"></div>
                                        </div>
                                        <span class="text-xs text-gray-400">Active</span>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-full flex flex-col items-center justify-center py-12 text-center">
                                    <div class="p-4 rounded-full bg-gray-100 text-gray-400 mb-3">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                    </div>
                                    <p class="text-gray-500 text-sm font-medium">No habits tracked.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Meals Panel -->
                    <div x-show="tab === 'meals'" style="display: none;" class="space-y-3" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                        @forelse($user->meals->take(10) as $meal)
                            <div class="flex justify-between items-center p-4 bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md hover:border-purple-200 transition-all duration-200">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-900">{{ $meal->name }}</p>
                                        <p class="text-xs text-gray-500 mt-0.5 capitalize">{{ $meal->meal_type }} • {{ $meal->date->format('l, M d') }}</p>
                                    </div>
                                </div>
                                <span class="text-xs font-medium px-2 py-1 bg-gray-100 text-gray-600 rounded-md">
                                    {{ $meal->calories ?? '---' }} kcal
                                </span>
                            </div>
                        @empty
                            <div class="flex flex-col items-center justify-center py-12 text-center">
                                <div class="p-4 rounded-full bg-gray-100 text-gray-400 mb-3">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                </div>
                                <p class="text-gray-500 text-sm font-medium">No meals planned.</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Bills Panel -->
                    <div x-show="tab === 'bills'" style="display: none;" class="grid grid-cols-1 sm:grid-cols-2 gap-4" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                        @forelse($user->bills as $bill)
                            <div class="p-5 bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md hover:border-amber-200 transition-all duration-200">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <p class="font-bold text-gray-900">{{ $bill->name }}</p>
                                        <p class="text-xs text-gray-500 mt-1">Due: {{ $bill->next_due_date ? $bill->next_due_date->format('M d') : 'N/A' }}</p>
                                    </div>
                                    <span class="px-2 py-1 text-[10px] font-bold uppercase tracking-wide rounded border {{ $bill->is_active ? 'bg-amber-50 text-amber-700 border-amber-100' : 'bg-emerald-50 text-emerald-700 border-emerald-100' }}">
                                        {{ $bill->is_active ? 'Active' : 'Paid' }}
                                    </span>
                                </div>
                                <div class="space-y-2">
                                    <div class="flex justify-between text-xs font-medium text-gray-600">
                                        <span>Balance</span>
                                        <span>Ksh {{ number_format($bill->remaining_amount) }}</span>
                                    </div>
                                    <div class="w-full bg-gray-100 rounded-full h-2">
                                        <div class="bg-amber-500 h-2 rounded-full transition-all duration-500" 
                                             style="width: {{ $bill->progress_percentage ?? 0 }}%"></div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full flex flex-col items-center justify-center py-12 text-center">
                                <div class="p-4 rounded-full bg-gray-100 text-gray-400 mb-3">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                </div>
                                <p class="text-gray-500 text-sm font-medium">No bills recorded.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>