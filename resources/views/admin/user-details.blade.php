<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                User Details: {{ $user->name }}
            </h2>
            <a href="{{ route('admin.users') }}" 
               class="text-sm text-gray-600 hover:text-gray-900">
                ← Back to Users
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- User Profile Card -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center gap-6">
                    <div class="w-24 h-24 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center text-white text-4xl font-bold">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div class="flex-1">
                        <h3 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h3>
                        <p class="text-gray-600">{{ $user->email }}</p>
                        <div class="flex gap-2 mt-2">
                            @if($user->is_admin)
                                <span class="px-3 py-1 text-sm font-semibold rounded-full bg-purple-100 text-purple-800">
                                    👑 Admin
                                </span>
                            @endif
                            @if($user->is_demo)
                                <span class="px-3 py-1 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    ⏰ Demo User
                                </span>
                            @else
                                <span class="px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                                    ✓ Active User
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-600">Joined</p>
                        <p class="font-semibold">{{ $user->created_at->format('M d, Y') }}</p>
                        <p class="text-xs text-gray-500">{{ $user->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            </div>

            <!-- User Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-blue-50 rounded-lg p-6 border border-blue-200">
                    <h4 class="text-sm font-medium text-blue-900">Expenses</h4>
                    <p class="text-3xl font-bold text-blue-600">{{ $user->expenses->count() }}</p>
                    <p class="text-sm text-blue-700 mt-1">
                        ${{ number_format($user->expenses->sum('amount'), 2) }} total
                    </p>
                </div>

                <div class="bg-green-50 rounded-lg p-6 border border-green-200">
                    <h4 class="text-sm font-medium text-green-900">Habits</h4>
                    <p class="text-3xl font-bold text-green-600">{{ $user->habits->count() }}</p>
                    <p class="text-sm text-green-700 mt-1">
                        {{ $user->habits->sum('streak') }} total streak days
                    </p>
                </div>

                <div class="bg-purple-50 rounded-lg p-6 border border-purple-200">
                    <h4 class="text-sm font-medium text-purple-900">Meals</h4>
                    <p class="text-3xl font-bold text-purple-600">{{ $user->meals->count() }}</p>
                    <p class="text-sm text-purple-700 mt-1">
                        Planned meals
                    </p>
                </div>

                <div class="bg-orange-50 rounded-lg p-6 border border-orange-200">
                    <h4 class="text-sm font-medium text-orange-900">Bills</h4>
                    <p class="text-3xl font-bold text-orange-600">{{ $user->bills->count() }}</p>
                    <p class="text-sm text-orange-700 mt-1">
                        ${{ number_format($user->bills->sum('remaining_amount'), 2) }} owed
                    </p>
                </div>
            </div>

            <!-- Recent Activity Tabs -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden" x-data="{ tab: 'expenses' }">
                <!-- Tabs -->
                <div class="border-b border-gray-200">
                    <nav class="flex -mb-px">
                        <button @click="tab = 'expenses'" 
                                :class="tab === 'expenses' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="py-4 px-6 border-b-2 font-medium text-sm">
                            Expenses ({{ $user->expenses->count() }})
                        </button>
                        <button @click="tab = 'habits'" 
                                :class="tab === 'habits' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="py-4 px-6 border-b-2 font-medium text-sm">
                            Habits ({{ $user->habits->count() }})
                        </button>
                        <button @click="tab = 'meals'" 
                                :class="tab === 'meals' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="py-4 px-6 border-b-2 font-medium text-sm">
                            Meals ({{ $user->meals->count() }})
                        </button>
                        <button @click="tab = 'bills'" 
                                :class="tab === 'bills' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="py-4 px-6 border-b-2 font-medium text-sm">
                            Bills ({{ $user->bills->count() }})
                        </button>
                    </nav>
                </div>

                <!-- Tab Content -->
                <div class="p-6">
                    <!-- Expenses Tab -->
                    <div x-show="tab === 'expenses'" class="space-y-3">
                        @forelse($user->expenses->take(10) as $expense)
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <p class="font-medium">{{ $expense->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $expense->category }} • {{ $expense->date->format('M d, Y') }}</p>
                                </div>
                                <p class="font-bold {{ $expense->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $expense->type === 'income' ? '+' : '-' }}${{ number_format($expense->amount, 2) }}
                                </p>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-4">No expenses yet</p>
                        @endforelse
                    </div>

                    <!-- Habits Tab -->
                    <div x-show="tab === 'habits'" class="space-y-3">
                        @forelse($user->habits->take(10) as $habit)
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <p class="font-medium">{{ $habit->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $habit->category }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-orange-600">{{ $habit->streak }} 🔥</p>
                                    <p class="text-xs text-gray-500">Best: {{ $habit->longest_streak }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-4">No habits yet</p>
                        @endforelse
                    </div>

                    <!-- Meals Tab -->
                    <div x-show="tab === 'meals'" class="space-y-3">
                        @forelse($user->meals->take(10) as $meal)
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <p class="font-medium">{{ $meal->name }}</p>
                                    <p class="text-sm text-gray-500">{{ ucfirst($meal->meal_type) }} • {{ $meal->date->format('M d, Y') }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-4">No meals yet</p>
                        @endforelse
                    </div>

                    <!-- Bills Tab -->
                    <div x-show="tab === 'bills'" class="space-y-3">
                        @forelse($user->bills->take(10) as $bill)
                            <div class="p-3 bg-gray-50 rounded-lg">
                                <div class="flex justify-between items-center mb-2">
                                    <p class="font-medium">{{ $bill->name }}</p>
                                    <span class="text-sm {{ $bill->is_active ? 'text-orange-600' : 'text-green-600' }}">
                                        {{ $bill->is_active ? 'Active' : 'Completed' }}
                                    </span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">{{ $bill->paid_installments }}/{{ $bill->total_installments }} paid</span>
                                    <span class="font-semibold">${{ number_format($bill->remaining_amount, 2) }} remaining</span>
                                </div>
                                <div class="mt-2 w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $bill->progress_percentage }}%"></div>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-4">No bills yet</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Admin Actions -->
            @if($user->id !== auth()->id())
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-semibold mb-4">Admin Actions</h3>
                    <div class="flex gap-4">
                        @if(!$user->is_admin)
                            <form method="POST" action="{{ route('admin.users.make-admin', $user) }}">
                                @csrf
                                <button type="submit" 
                                        class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                                    👑 Make Admin
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('admin.users.remove-admin', $user) }}">
                                @csrf
                                <button type="submit" 
                                        class="px-6 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700">
                                    Remove Admin
                                </button>
                            </form>
                        @endif

                        @if(!$user->is_admin)
                            <form method="POST" action="{{ route('admin.users.delete', $user) }}"
                                  onsubmit="return confirm('Are you sure you want to delete this user and all their data?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                                    🗑️ Delete User
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>