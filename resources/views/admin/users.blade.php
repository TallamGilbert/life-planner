<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                👥 User Management
            </h2>
            <a href="{{ route('admin.dashboard') }}" 
               class="text-sm text-gray-600 hover:text-gray-900">
                ← Back to Admin
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Success/Error Messages -->
            @if(session('success'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        showToast('{{ session('success') }}', 'success');
                    });
                </script>
            @endif

            @if(session('error'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        showToast('{{ session('error') }}', 'error');
                    });
                </script>
            @endif

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white rounded-lg shadow-sm p-4">
                    <p class="text-sm text-gray-600">Total Users</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $users->total() }}</p>
                </div>
                <div class="bg-white rounded-lg shadow-sm p-4">
                    <p class="text-sm text-gray-600">Active Users</p>
                    <p class="text-2xl font-bold text-green-600">
                        {{ $users->filter(function($user) { return !$user->is_demo; })->count() }}
                    </p>
                </div>
                <div class="bg-white rounded-lg shadow-sm p-4">
                    <p class="text-sm text-gray-600">Demo Users</p>
                    <p class="text-2xl font-bold text-yellow-600">
                        {{ $users->filter(function($user) { return $user->is_demo; })->count() }}
                    </p>
                </div>
                <div class="bg-white rounded-lg shadow-sm p-4">
                    <p class="text-sm text-gray-600">Admins</p>
                    <p class="text-2xl font-bold text-purple-600">
                        {{ $users->filter(function($user) { return $user->is_admin; })->count() }}
                    </p>
                </div>
            </div>

            <!-- Users Table -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">All Users</h3>
                        
                        <!-- Search & Filter (Optional - can add later) -->
                        <div class="flex gap-2">
                            <input type="text" 
                                   placeholder="Search users..." 
                                   class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                   id="search-users">
                            <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                    id="filter-users">
                                <option value="all">All Users</option>
                                <option value="active">Active Only</option>
                                <option value="demo">Demo Only</option>
                                <option value="admin">Admins Only</option>
                            </select>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        User
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Email
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Data
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Joined
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($users as $user)
                                    <tr class="hover:bg-gray-50 transition">
                                        <!-- User Info -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center text-white font-bold">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </div>
                                                <div class="ml-3">
                                                    <p class="text-sm font-medium text-gray-900">
                                                        {{ $user->name }}
                                                        @if($user->id === auth()->id())
                                                            <span class="text-xs text-blue-600">(You)</span>
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Email -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <p class="text-sm text-gray-900">{{ $user->email }}</p>
                                        </td>

                                        <!-- Status -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex flex-col gap-1">
                                                @if($user->is_admin)
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                                                        👑 Admin
                                                    </span>
                                                @endif
                                                @if($user->is_demo)
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                        ⏰ Demo
                                                        @if($user->demo_expires_at)
                                                            ({{ $user->getDemoTimeRemaining() }}m left)
                                                        @endif
                                                    </span>
                                                @else
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                        ✓ Active
                                                    </span>
                                                @endif
                                            </div>
                                        </td>

                                        <!-- User Data Stats -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-xs text-gray-600">
                                                <p>💰 {{ $user->expenses_count }} expenses</p>
                                                <p>🔥 {{ $user->habits_count }} habits</p>
                                                <p>🍽️ {{ $user->meals_count }} meals</p>
                                                <p>📋 {{ $user->bills_count }} bills</p>
                                            </div>
                                        </td>

                                        <!-- Joined Date -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $user->created_at->format('M d, Y') }}
                                            <p class="text-xs text-gray-400">{{ $user->created_at->diffForHumans() }}</p>
                                        </td>

                                        <!-- Actions -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <div class="flex items-center gap-2">
                                                <!-- View Details -->
                                                <a href="{{ route('admin.users.show', $user) }}" 
                                                   class="text-blue-600 hover:text-blue-800 font-medium">
                                                    View
                                                </a>

                                                @if($user->id !== auth()->id())
                                                    <!-- Make/Remove Admin -->
                                                    @if(!$user->is_admin)
                                                        <form method="POST" action="{{ route('admin.users.make-admin', $user) }}" class="inline">
                                                            @csrf
                                                            <button type="submit" 
                                                                    class="text-purple-600 hover:text-purple-800 font-medium">
                                                                Make Admin
                                                            </button>
                                                        </form>
                                                    @else
                                                        <form method="POST" action="{{ route('admin.users.remove-admin', $user) }}" class="inline">
                                                            @csrf
                                                            <button type="submit" 
                                                                    class="text-orange-600 hover:text-orange-800 font-medium">
                                                                Remove Admin
                                                            </button>
                                                        </form>
                                                    @endif

                                                    <!-- Delete User -->
                                                    @if(!$user->is_admin)
                                                        <button onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}')"
                                                                class="text-red-600 hover:text-red-800 font-medium">
                                                            Delete
                                                        </button>
                                                    @endif
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="delete-modal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Delete User?</h3>
                    <p class="text-gray-600 mb-6">
                        Are you sure you want to delete <strong id="delete-user-name"></strong>?
                        This will permanently delete all their data including expenses, habits, meals, and bills.
                    </p>
                    <div class="flex gap-3">
                        <button onclick="closeDeleteModal()"
                                class="flex-1 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                            Cancel
                        </button>
                        <form id="delete-form" method="POST" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                                Delete User
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        function confirmDelete(userId, userName) {
            document.getElementById('delete-user-name').textContent = userName;
            document.getElementById('delete-form').action = `/admin/users/${userId}`;
            document.getElementById('delete-modal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('delete-modal').classList.add('hidden');
        }

        // Simple client-side search (you can make this server-side later)
        document.getElementById('search-users').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });

        // Simple filter
        document.getElementById('filter-users').addEventListener('change', function(e) {
            const filter = e.target.value;
            const rows = document.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const isAdmin = row.textContent.includes('👑 Admin');
                const isDemo = row.textContent.includes('⏰ Demo');
                const isActive = row.textContent.includes('✓ Active');
                
                let show = true;
                if (filter === 'active' && !isActive) show = false;
                if (filter === 'demo' && !isDemo) show = false;
                if (filter === 'admin' && !isAdmin) show = false;
                
                row.style.display = show ? '' : 'none';
            });
        });
    </script>
</x-app-layout>