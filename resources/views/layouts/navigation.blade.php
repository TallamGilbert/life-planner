<nav x-data="{ open: false }" class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-gray-100 transition-all duration-300">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="group flex items-center space-x-3 transition opacity-90 hover:opacity-100">
                        <svg class="h-9 w-auto" width="180" height="40" viewBox="0 0 180 40" xmlns="http://www.w3.org/2000/svg">
                            <!-- Icon Group -->
                            <g class="transition-transform group-hover:scale-105 duration-200 origin-center">
                                <!-- Accent Circle -->
                                <circle cx="14" cy="14" r="14" fill="#111827" opacity="0.05"/>
                                <circle cx="14" cy="14" r="9" fill="#111827"/>
                                
                                <!-- Icon Path (White checkmark/calendar) -->
                                <g transform="translate(4,4)">
                                    <rect x="4" y="4" width="20" height="20" rx="4" stroke="white" stroke-width="2.5" fill="none"/>
                                    <path d="M8 10 L16 18 L24 6" stroke="white" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                                </g>
                            </g>

                            <!-- Text -->
                            <text x="36" y="25"
                                font-family="system-ui, -apple-system, sans-serif"
                                font-size="22" font-weight="800"
                                fill="#111827">
                                LifePlanner
                            </text>
                        </svg>
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

                    @if(auth()->user()->is_admin)
                    <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.*')">
                        {{ __(' Admin') }}
                    </x-nav-link>
                @endif
                </div>
            </div>

            <!-- Right Side: Avatar Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center justify-center p-0.5 rounded-full hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2 transition duration-150 ease-in-out">
                            @if (auth()->user()->profile_picture_path)
                                <img class="h-8 w-8 rounded-full object-cover border border-gray-200" 
                                     src="{{ Storage::url(auth()->user()->profile_picture_path) }}" 
                                     alt="{{ auth()->user()->name }}">
                            @else
                                <!-- Modern Minimal Fallback Avatar -->
                                <div class="h-8 w-8 rounded-full bg-gray-900 flex items-center justify-center text-white font-bold text-xs tracking-wider">
                                    {{ Str::upper(Str::substr(auth()->user()->name, 0, 1)) }}
                                </div>
                            @endif
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        

                        <x-dropdown-link :href="route('profile.edit')" class="hover:bg-gray-50">
                            {{ __('Profile Settings') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                    class="text-red-600 hover:bg-red-50 hover:text-red-700">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Mobile menu button -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-lg text-gray-400 hover:text-gray-500 hover:bg-gray-50 focus:outline-none focus:bg-gray-50 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': !open}" class="sm:hidden border-t border-gray-100 bg-white/95 backdrop-blur-md">
        <div class="pt-2 pb-3 space-y-1 px-2">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="rounded-lg">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('expenses.index')" :active="request()->routeIs('expenses.*')" class="rounded-lg">
                {{ __('Budget') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('bills.index')" :active="request()->routeIs('bills.*')" class="rounded-lg">
                {{ __('Bills') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('habits.index')" :active="request()->routeIs('habits.*')" class="rounded-lg">
                {{ __('Habits') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('meals.index')" :active="request()->routeIs('meals.*')" class="rounded-lg">
                {{ __('Meals') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('analytics.index')" :active="request()->routeIs('analytics.*')" class="rounded-lg">
                {{ __('Analytics') }}
            </x-responsive-nav-link>
            @if(auth()->user()->is_admin)
            <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.*')">
                {{ __(' Admin') }}
            </x-responsive-nav-link>
        @endif
        </div>

        <!-- Mobile user menu -->
        <div class="pt-4 pb-4 border-t border-gray-100">
            <div class="px-4 flex items-center">
                <div class="shrink-0">
                    @if (auth()->user()->profile_picture_path)
                        <img class="h-10 w-10 rounded-full object-cover border border-gray-200" src="{{ Storage::url(auth()->user()->profile_picture_path) }}" alt="">
                    @else
                        <div class="h-10 w-10 rounded-full bg-gray-900 flex items-center justify-center text-white font-bold text-sm">
                            {{ Str::upper(Str::substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    @endif
                </div>
                <div class="ml-3">
                    <div class="font-bold text-base text-gray-900">{{ auth()->user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ auth()->user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1 px-2">
                <x-responsive-nav-link :href="route('profile.edit')" class="rounded-lg">
                    {{ __('Profile') }}
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();" class="rounded-lg text-red-600">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>