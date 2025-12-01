<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-900 tracking-tight leading-tight">
                Admin Overview
            </h2>
            <div class="flex items-center gap-2 text-sm text-gray-500 bg-white px-3 py-1 rounded-full border border-gray-200 shadow-sm">
                <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                System Operational
            </div>
        </div>
    </x-slot>

    <div class="py-10 bg-gray-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Welcome Section -->
            <div class="mb-8">
                <h3 class="text-2xl font-bold text-gray-900">Good morning, Admin</h3>
                <p class="text-gray-500">Here's what's happening across the platform today.</p>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                
                <!-- Total Users -->
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] hover:shadow-lg transition duration-300">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Users</p>
                            <h4 class="text-3xl font-bold text-gray-900 mt-1">{{ number_format($total_users) }}</h4>
                        </div>
                        <div class="p-2 bg-blue-50 text-blue-600 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 text-xs font-medium">
                        <span class="text-green-600 bg-green-50 px-2 py-0.5 rounded">{{ $active_users }} Active</span>
                        <span class="text-gray-400">|</span>
                        <span class="text-orange-600 bg-orange-50 px-2 py-0.5 rounded">{{ $demo_users }} Demo</span>
                    </div>
                </div>

                <!-- Database Volume (Expenses) -->
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] hover:shadow-lg transition duration-300">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Database Entries</p>
                            <h4 class="text-3xl font-bold text-gray-900 mt-1">{{ number_format($total_expenses) }}</h4>
                        </div>
                        <div class="p-2 bg-purple-50 text-purple-600 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path></svg>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500">Total expense records stored</p>
                </div>

                <!-- Habits -->
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] hover:shadow-lg transition duration-300">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Active Habits</p>
                            <h4 class="text-3xl font-bold text-gray-900 mt-1">{{ number_format($total_habits) }}</h4>
                        </div>
                        <div class="p-2 bg-pink-50 text-pink-600 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500">User engagement metrics</p>
                </div>

                <!-- System Load (Bills/Meals) -->
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] hover:shadow-lg transition duration-300">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Scheduled Items</p>
                            <h4 class="text-3xl font-bold text-gray-900 mt-1">{{ number_format($total_bills + $total_meals) }}</h4>
                        </div>
                        <div class="p-2 bg-indigo-50 text-indigo-600 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-1.5 mt-2">
                        <div class="bg-indigo-500 h-1.5 rounded-full" style="width: 70%"></div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Main Column: Recent Users Table -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                        <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-white">
                            <div>
                                <h3 class="font-bold text-gray-900">Recent Registrations</h3>
                                <p class="text-xs text-gray-500 mt-1">Latest users who joined the platform</p>
                            </div>
                            <a href="{{ route('admin.users') }}" class="text-sm font-medium text-gray-900 hover:text-blue-600 transition flex items-center gap-1">
                                View All <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50/50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">User Profile</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Joined</th>
                                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @foreach($recent_users as $user)
                                        <tr class="hover:bg-gray-50/80 transition duration-150">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="h-10 w-10 rounded-full bg-gradient-to-tr from-gray-900 to-gray-700 flex items-center justify-center text-white text-sm font-bold shadow-sm">
                                                        {{ substr($user->name, 0, 1) }}
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-semibold text-gray-900">{{ $user->name }}</div>
                                                        <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($user->is_admin)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                        Administrator
                                                    </span>
                                                @elseif($user->is_demo)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                                        Demo Mode
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        Verified
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $user->created_at->format('M d, Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('admin.users.show', $user) }}" class="text-gray-400 hover:text-gray-900 transition">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Quick Actions & Links -->
                <div class="space-y-6">
                    
                    <!-- Quick Actions Card -->
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                        <h3 class="font-bold text-gray-900 mb-4">Quick Management</h3>
                        <div class="space-y-3">
                            <a href="{{ route('admin.users') }}" class="group flex items-center p-3 rounded-xl bg-gray-50 hover:bg-gray-100 transition border border-gray-100 hover:border-gray-200">
                                <div class="w-10 h-10 rounded-lg bg-white flex items-center justify-center text-blue-600 shadow-sm group-hover:scale-105 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-semibold text-gray-900">Manage Users</p>
                                    <p class="text-xs text-gray-500">Edit, ban or view profiles</p>
                                </div>
                            </a>

                            <a href="{{ route('admin.stats') }}" class="group flex items-center p-3 rounded-xl bg-gray-50 hover:bg-gray-100 transition border border-gray-100 hover:border-gray-200">
                                <div class="w-10 h-10 rounded-lg bg-white flex items-center justify-center text-green-600 shadow-sm group-hover:scale-105 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-semibold text-gray-900">Analytics Report</p>
                                    <p class="text-xs text-gray-500">Download system stats</p>
                                </div>
                            </a>

                            <a href="{{ route('dashboard') }}" class="group flex items-center p-3 rounded-xl bg-gray-900 text-white hover:bg-gray-800 transition shadow-lg shadow-gray-200">
                                <div class="w-10 h-10 rounded-lg bg-white/10 flex items-center justify-center text-white group-hover:scale-105 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-semibold">Switch to User View</p>
                                    <p class="text-xs text-gray-300">View personal dashboard</p>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Mini Insight -->
                    <div class="bg-gradient-to-br from-indigo-600 to-purple-700 p-6 rounded-2xl text-white shadow-lg">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="p-2 bg-white/10 rounded-lg backdrop-blur-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                            <span class="font-bold text-sm">System Health</span>
                        </div>
                        <p class="text-white/80 text-sm leading-relaxed mb-4">
                            All systems are running smoothly. Database backup completed 2 hours ago.
                        </p>
                        <div class="w-full bg-black/20 rounded-full h-1.5">
                            <div class="bg-green-400 h-1.5 rounded-full" style="width: 98%"></div>
                        </div>
                        <div class="flex justify-between mt-2 text-xs text-white/60">
                            <span>Uptime</span>
                            <span>99.9%</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>