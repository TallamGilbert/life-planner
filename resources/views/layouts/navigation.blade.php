<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <div class="shrink-0 flex items-center">
                            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                                <svg class="h-9 w-auto" width="180" height="40" viewBox="0 0 180 40" xmlns="http://www.w3.org/2000/svg">
                                    <!-- Colored accent circle (visible on both light & dark) -->
                                    <circle cx="14" cy="14" r="14" fill="#10b981" opacity="0.15"/>
                                    <circle cx="14" cy="14" r="9" fill="#10b981"/>

                                    <!-- Calendar + checkmark icon (white on the green circle) -->
                                    <g transform="translate(4,4)">
                                        <rect x="4" y="4" width="20" height="20" rx="4" stroke="white" stroke-width="2.5" fill="none"/>
                                        <path d="M8 10 L16 18 L24 6" stroke="white" stroke-width="2.5" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round"/>
                                    </g>

                                    <!-- Text – always strong contrast -->
                                    <text x="36" y="25"
                                        font-family="system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif"
                                        font-size="22" font-weight="800"
                                        class="fill-gray-900 dark:fill-blue">
                                        LifePlanner
                                    </text>
                                </svg>
                            </a>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Home') }}
                    </x-nav-link>

                    <x-nav-link :href="route('expenses.index')" :active="request()->routeIs('expenses.*')">
                        {{ __('Budget') }}
                    </x-nav-link>


                    <x-nav-link :href="route('bills.index')" :active="request()->routeIs('bills.*')">
                        {{ __('Bills') }}
                    </x-nav-link>

                    <x-nav-link :href="route('habits.index')" :active="request()->routeIs('habits.*')">
                        {{ __('Habits') }}
                    </x-nav-link>

                    <x-nav-link :href="route('meals.index')" :active="request()->routeIs('meals.*')">
                        {{ __('Meals') }}
                    </x-nav-link>
                    <x-nav-link :href="route('analytics.index')" :active="request()->routeIs('analytics.*')">
                        {{ __('Analytics') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Right Side: Avatar Dropdown (perfectly aligned to the far right) -->
            <div class="hidden sm:flex sm:items-center">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition">
                            @if (auth()->user()->avatar_url)
                                <img class="h-9 w-9 rounded-full object-cover" 
                                     src="{{ auth()->user()->avatar_url }}" 
                                     alt="{{ auth()->user()->name }}">
                            @else
                                <div class="h-9 w-9 rounded-full bg-indigo-600 flex items-center justify-center text-white font-medium text-sm">
                                    {{ Str::substr(auth()->user()->name, 0, 2) }}
                                </div>
                            @endif
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Mobile menu button -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu (mobile) -->
    <div :class="{'block': open, 'hidden': !open}" class="sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('expenses.index')" :active="request()->routeIs('expenses.*')">
                {{ __('Budget') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('bills.index')" :active="request()->routeIs('bills.*')">
                {{ __('Bills') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('habits.index')" :active="request()->routeIs('habits.*')">
                {{ __('Habits') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('meals.index')" :active="request()->routeIs('meals.*')">
                {{ __('Meals') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('analytics.index')" :active="request()->routeIs('analytics.*')">
            {{ __('Analytics') }}
        </x-responsive-nav-link>
        </div>

        <!-- Mobile user menu -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4 flex items-center">
                @if (auth()->user()->avatar_url)
                    <img class="h-10 w-10 rounded-full object-cover" src="{{ auth()->user()->avatar_url }}" alt="">
                @else
                    <div class="h-10 w-10 rounded-full bg-indigo-600 flex items-center justify-center text-white font-medium">
                        {{ Str::substr(auth()->user()->name, 0, 2) }}
                    </div>
                @endif
                <div class="ml-3">
                    <div class="font-medium text-base text-gray-800">{{ auth()->user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ auth()->user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>














