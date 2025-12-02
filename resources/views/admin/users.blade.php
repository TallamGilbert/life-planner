<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 tracking-tight">
                    {{ __('User Management') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1"> oversee and manage registered accounts</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" 
               class="group inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-700 hover:border-gray-300 hover:text-gray-900 hover:bg-gray-50 transition shadow-sm">
                <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Success/Error Messages -->
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" 
                     class="bg-emerald-50 border border-emerald-100 text-emerald-700 px-4 py-3 rounded-xl shadow-sm flex items-center gap-3">
                    <div class="p-1 bg-emerald-100 rounded-full">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                     class="bg-red-50 border border-red-100 text-red-700 px-4 py-3 rounded-xl shadow-sm flex items-center gap-3">
                    <div class="p-1 bg-red-100 rounded-full">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </div>
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Stats Overview Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Card 1: Total Users -->
                <div class="group bg-white p-6 rounded-2xl border border-gray-200/60 shadow-sm hover:shadow-md transition-all duration-200">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-2 bg-blue-50 text-blue-600 rounded-xl group-hover:bg-blue-600 group-hover:text-white transition-colors duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <span class="text-xs font-medium text-gray-400 uppercase tracking-wider">Total</span>
                    </div>
                    <p class="text-3xl font-bold text-gray-900 tracking-tight">{{ $users->total() }}</p>
                    <p class="mt-1 text-xs text-gray-500">Registered accounts</p>
                </div>

                <!-- Card 2: Active Users -->
                <div class="group bg-white p-6 rounded-2xl border border-gray-200/60 shadow-sm hover:shadow-md transition-all duration-200">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-2 bg-emerald-50 text-emerald-600 rounded-xl group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <span class="text-xs font-medium text-gray-400 uppercase tracking-wider">Verified</span>
                    </div>
                    <p class="text-3xl font-bold text-gray-900 tracking-tight">
                        {{ $users->filter(function($user) { return !$user->is_demo; })->count() }}
                    </p>
                    <p class="mt-1 text-xs text-gray-500">Full access accounts</p>
                </div>

                <!-- Card 3: Demo Users -->
                <div class="group bg-white p-6 rounded-2xl border border-gray-200/60 shadow-sm hover:shadow-md transition-all duration-200">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-2 bg-amber-50 text-amber-600 rounded-xl group-hover:bg-amber-600 group-hover:text-white transition-colors duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <span class="text-xs font-medium text-gray-400 uppercase tracking-wider">Demo</span>
                    </div>
                    <p class="text-3xl font-bold text-gray-900 tracking-tight">
                        {{ $users->filter(function($user) { return $user->is_demo; })->count() }}
                    </p>
                    <p class="mt-1 text-xs text-gray-500">Temporary access</p>
                </div>

                <!-- Card 4: Admins -->
                <div class="group bg-white p-6 rounded-2xl border border-gray-200/60 shadow-sm hover:shadow-md transition-all duration-200">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-2 bg-purple-50 text-purple-600 rounded-xl group-hover:bg-purple-600 group-hover:text-white transition-colors duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        </div>
                        <span class="text-xs font-medium text-gray-400 uppercase tracking-wider">Admins</span>
                    </div>
                    <p class="text-3xl font-bold text-gray-900 tracking-tight">
                        {{ $users->filter(function($user) { return $user->is_admin; })->count() }}
                    </p>
                    <p class="mt-1 text-xs text-gray-500">System managers</p>
                </div>
            </div>

            <!-- Users Table Container -->
            <div class="bg-white rounded-2xl border border-gray-200/60 shadow-sm overflow-hidden">
                <!-- Toolbar -->
                <div class="px-6 py-5 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h3 class="font-bold text-gray-900">User Directory</h3>
                        <p class="text-sm text-gray-500 mt-1">Search and filter registered members</p>
                    </div>
                    
                    <!-- Search & Filter -->
                    <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                        <div class="relative group">
                            <input type="text" 
                                   id="search-users"
                                   placeholder="Search users..." 
                                   class="pl-10 pr-4 py-2 w-full sm:w-64 bg-gray-50 border-transparent focus:bg-white border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition shadow-sm placeholder-gray-400 text-gray-700">
                            <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3 group-hover:text-blue-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <select id="filter-users" 
                                class="px-4 py-2 bg-gray-50 focus:bg-white border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition shadow-sm text-gray-700 cursor-pointer">
                            <option value="all">All Statuses</option>
                            <option value="active">Active Only</option>
                            <option value="demo">Demo Only</option>
                            <option value="admin">Admins Only</option>
                        </select>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50/50 border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">User Profile</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Usage Metrics</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Joined</th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($users as $user)
                                <tr class="hover:bg-gray-50/80 transition duration-150 group">
                                    <!-- User Info -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-gray-800 to-gray-900 flex items-center justify-center text-white font-bold shadow-sm shrink-0">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="flex items-center gap-2">
                                                    <span class="text-sm font-semibold text-gray-900">{{ $user->name }}</span>
                                                    @if($user->id === auth()->id())
                                                        <span class="px-1.5 py-0.5 rounded text-[10px] font-bold bg-gray-100 text-gray-600 border border-gray-200">YOU</span>
                                                    @endif
                                                </div>
                                                <div class="text-xs text-gray-500">{{ $user->email }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Status -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($user->is_admin)
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-purple-50 text-purple-700 border border-purple-100">
                                                <span class="relative flex h-1.5 w-1.5">
                                                  <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-purple-500"></span>
                                                </span>
                                                Admin
                                            </span>
                                        @elseif($user->is_demo)
                                            <div class="flex flex-col items-start gap-1">
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-100">
                                                    <span class="relative flex h-1.5 w-1.5">
                                                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                                                      <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-amber-500"></span>
                                                    </span>
                                                    Demo
                                                </span>
                                                @if($user->demo_expires_at)
                                                    <span class="text-[10px] text-gray-400 pl-2 font-mono">{{ number_format($user->getDemoTimeRemaining()) }}m remaining</span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-100">
                                                <span class="relative flex h-1.5 w-1.5">
                                                  <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-emerald-500"></span>
                                                </span>
                                                Active
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Data Stats -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-4">
                                            <div class="flex flex-col">
                                                <span class="text-[10px] uppercase text-gray-400 font-bold tracking-wider">Exp</span>
                                                <span class="text-sm font-semibold text-gray-900">{{ $user->expenses_count }}</span>
                                            </div>
                                            <div class="w-px h-8 bg-gray-100"></div>
                                            <div class="flex flex-col">
                                                <span class="text-[10px] uppercase text-gray-400 font-bold tracking-wider">Hab</span>
                                                <span class="text-sm font-semibold text-gray-900">{{ $user->habits_count }}</span>
                                            </div>
                                            <div class="w-px h-8 bg-gray-100"></div>
                                            <div class="flex flex-col">
                                                <span class="text-[10px] uppercase text-gray-400 font-bold tracking-wider">Bill</span>
                                                <span class="text-sm font-semibold text-gray-900">{{ $user->bills_count }}</span>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Joined -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $user->created_at->format('M d, Y') }}</div>
                                        <div class="text-xs text-gray-400">{{ $user->created_at->diffForHumans() }}</div>
                                    </td>

                                    <!-- Actions -->
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                            <a href="{{ route('admin.users.show', $user) }}" 
                                               class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition" 
                                               title="View Details">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            </a>

                                            @if($user->id !== auth()->id())
                                                @if(!$user->is_admin)
                                                    <form method="POST" action="{{ route('admin.users.make-admin', $user) }}" class="inline">
                                                        @csrf
                                                        <button type="submit" 
                                                                class="p-2 text-gray-400 hover:text-purple-600 hover:bg-purple-50 rounded-lg transition"
                                                                title="Grant Admin Access">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                                        </button>
                                                    </form>
                                                @else
                                                    <form method="POST" action="{{ route('admin.users.remove-admin', $user) }}" class="inline">
                                                        @csrf
                                                        <button type="submit" 
                                                                class="p-2 text-purple-600 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition"
                                                                title="Revoke Admin Access">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                                        </button>
                                                    </form>
                                                @endif

                                                <button onclick="confirmDelete(this)"
                                                        data-id="{{ $user->id }}"
                                                        data-name="{{ $user->name }}"
                                                        class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition"
                                                        title="Delete User">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($users->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                    {{ $users->links() }}
                </div>
                @endif
            </div>

        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="delete-modal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm transition-opacity"></div>

        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md ring-1 ring-black/5">
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-50 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                            <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Delete User Account</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Are you sure you want to delete <strong id="delete-user-name" class="text-gray-900"></strong>? 
                                    This action cannot be undone. All data (expenses, habits, bills) will be permanently removed.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50/50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 border-t border-gray-100">
                    <form id="delete-form" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex w-full justify-center rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto transition">
                            Delete Account
                        </button>
                    </form>
                    <button type="button" onclick="closeDeleteModal()" class="mt-3 inline-flex w-full justify-center rounded-lg bg-white px-4 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto transition">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Interactive Script -->
    <script>
        function confirmDelete(button) {
            // Extract data from button's data attributes
            const userId = button.dataset.id;
            const userName = button.dataset.name;
            
            document.getElementById('delete-user-name').textContent = userName;
            document.getElementById('delete-form').action = `/admin/users/${userId}`;
            document.getElementById('delete-modal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('delete-modal').classList.add('hidden');
        }

        // Search logic
        document.getElementById('search-users').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });

        // Filter logic
        document.getElementById('filter-users').addEventListener('change', function(e) {
            const filter = e.target.value;
            const rows = document.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                const isAdmin = text.includes('admin');
                const isDemo = text.includes('demo');
                // A simple check for active users (not demo)
                const isActive = !isDemo;
                
                let show = true;
                if (filter === 'active' && !isActive) show = false;
                if (filter === 'demo' && !isDemo) show = false;
                if (filter === 'admin' && !isAdmin) show = false;
                
                row.style.display = show ? '' : 'none';
            });
        });
    </script>
</x-app-layout>