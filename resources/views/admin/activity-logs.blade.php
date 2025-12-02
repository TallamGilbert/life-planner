<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 tracking-tight">
                    Activity Logs
                </h2>
                <p class="text-sm text-gray-500 mt-1">Audit trail and system events</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.dashboard') }}" 
                   class="group inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-700 hover:border-gray-300 hover:text-gray-900 hover:bg-gray-50 transition shadow-sm">
                    <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Dashboard
                </a>
                
                <form method="POST" action="{{ route('admin.logs.clear') }}" 
                      onsubmit="return confirm('Are you sure? This will permanently delete logs older than 30 days.')">
                    @csrf
                    <input type="hidden" name="days" value="30">
                    <button type="submit" 
                            class="inline-flex items-center gap-2 px-4 py-2 bg-rose-50 text-rose-600 border border-rose-100 rounded-lg text-sm font-medium hover:bg-rose-100 hover:text-rose-700 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        Prune Old Logs
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Success Message -->
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" 
                     class="bg-emerald-50 border border-emerald-100 text-emerald-700 px-4 py-3 rounded-xl shadow-sm flex items-center gap-3">
                    <div class="p-1 bg-emerald-100 rounded-full">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Filters -->
            <div class="bg-white rounded-2xl border border-gray-200/60 shadow-sm p-5">
                <form method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                    <!-- Action Filter -->
                    <div class="md:col-span-3">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Event Type</label>
                        <div class="relative">
                            <select name="action" class="w-full pl-3 pr-10 py-2 bg-gray-50 border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition shadow-sm appearance-none">
                                <option value="">All Events</option>
                                @foreach($actions as $action)
                                    <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                                        {{ ucfirst($action) }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none text-gray-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>

                    <!-- Date Range -->
                    <div class="md:col-span-3">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">From Date</label>
                        <input type="date" 
                               name="date_from" 
                               value="{{ request('date_from') }}"
                               class="w-full px-3 py-2 bg-gray-50 border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition shadow-sm text-gray-600">
                    </div>

                    <div class="md:col-span-3">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">To Date</label>
                        <input type="date" 
                               name="date_to" 
                               value="{{ request('date_to') }}"
                               class="w-full px-3 py-2 bg-gray-50 border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition shadow-sm text-gray-600">
                    </div>

                    <!-- Submit -->
                    <div class="md:col-span-3 flex gap-2">
                        <button type="submit" 
                                class="w-full px-4 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 text-sm font-medium transition shadow-md shadow-gray-200">
                            Filter Logs
                        </button>
                        @if(request()->hasAny(['action', 'date_from', 'date_to']))
                            <a href="{{ route('admin.logs') }}" class="px-4 py-2 bg-white border border-gray-200 text-gray-600 rounded-lg hover:bg-gray-50 text-sm font-medium transition">
                                Clear
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Activity Logs Table -->
            <div class="bg-white rounded-2xl border border-gray-200/60 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50/50 border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Timestamp</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">User</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Event</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Details</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Network</th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($logs as $log)
                                <tr class="hover:bg-gray-50/80 transition duration-150 group">
                                    <!-- Time -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $log->created_at->format('H:i:s') }}</div>
                                        <div class="text-xs text-gray-500">{{ $log->created_at->format('M d, Y') }}</div>
                                    </td>

                                    <!-- User -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($log->user)
                                            <div class="flex items-center">
                                                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center text-gray-600 text-xs font-bold shrink-0">
                                                    {{ substr($log->user->name, 0, 1) }}
                                                </div>
                                                <div class="ml-3">
                                                    <p class="text-sm font-medium text-gray-900">{{ $log->user->name }}</p>
                                                    <p class="text-xs text-gray-500">ID: {{ $log->user->id }}</p>
                                                </div>
                                            </div>
                                        @else
                                            <div class="flex items-center gap-2">
                                                <div class="p-1.5 bg-gray-100 rounded-md">
                                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                                </div>
                                                <span class="text-sm font-medium text-gray-600">System</span>
                                            </div>
                                        @endif
                                    </td>

                                    <!-- Action -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $colors = [
                                                'created' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                                'updated' => 'bg-blue-50 text-blue-700 border-blue-100',
                                                'deleted' => 'bg-red-50 text-red-700 border-red-100',
                                                'login'   => 'bg-purple-50 text-purple-700 border-purple-100',
                                                'logout'  => 'bg-gray-100 text-gray-700 border-gray-200',
                                            ];
                                            $dotColors = [
                                                'created' => 'bg-emerald-500',
                                                'updated' => 'bg-blue-500',
                                                'deleted' => 'bg-red-500',
                                                'login'   => 'bg-purple-500',
                                                'logout'  => 'bg-gray-500',
                                            ];
                                            $colorClass = $colors[$log->action] ?? 'bg-gray-50 text-gray-700 border-gray-100';
                                            $dotClass = $dotColors[$log->action] ?? 'bg-gray-400';
                                        @endphp
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium border {{ $colorClass }}">
                                            <span class="w-1.5 h-1.5 rounded-full {{ $dotClass }}"></span>
                                            {{ ucfirst($log->action) }}
                                        </span>
                                    </td>

                                    <!-- Description -->
                                    <td class="px-6 py-4">
                                        <p class="text-sm text-gray-900 truncate max-w-xs">{{ $log->description }}</p>
                                        @if($log->model)
                                            <p class="text-xs font-mono text-gray-400 mt-0.5">{{ class_basename($log->model) }} #{{ $log->model_id }}</p>
                                        @endif
                                    </td>

                                    <!-- IP Address -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                                            <span class="text-xs font-mono text-gray-500">{{ $log->ip_address ?? 'N/A' }}</span>
                                        </div>
                                    </td>

                                    <!-- Actions -->
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                        <button onclick="viewDetails(this)"
                                                data-log='@json($log)'
                                                data-date="{{ $log->created_at->format('M d, Y H:i:s') }}"
                                                class="text-gray-400 hover:text-blue-600 transition p-2 rounded-lg hover:bg-blue-50">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center text-gray-500">
                                            <div class="p-3 bg-gray-50 rounded-full mb-3">
                                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                            </div>
                                            <p class="text-sm font-medium">No activity logs found matching your criteria.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($logs->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                    {{ $logs->appends(request()->query())->links() }}
                </div>
                @endif
            </div>

        </div>
    </div>

    <!-- Log Details Modal -->
    <div id="log-details-modal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm transition-opacity" onclick="closeLogDetails()"></div>

        <div class="flex min-h-full items-center justify-center p-4 text-center">
            <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:w-full sm:max-w-xl">
                
                <!-- Modal Header -->
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Event Details</h3>
                        <p id="modal-date" class="text-xs text-gray-500 mt-1"></p>
                    </div>
                    <button onclick="closeLogDetails()" class="text-gray-400 hover:text-gray-600 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Modal Content -->
                <div class="px-6 py-6 space-y-4">
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-3 bg-gray-50 rounded-lg border border-gray-100">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Action</span>
                            <span id="modal-action" class="text-sm font-semibold text-gray-900 uppercase"></span>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-lg border border-gray-100">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Subject</span>
                            <span id="modal-model" class="text-sm font-mono text-gray-700"></span>
                        </div>
                    </div>

                    <div>
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-2">Description</span>
                        <p id="modal-description" class="text-sm text-gray-700 bg-blue-50/50 p-3 rounded-lg border border-blue-50"></p>
                    </div>

                    <div>
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-2">Technical Metadata</span>
                        <div class="bg-gray-900 rounded-lg p-3 overflow-x-auto">
                            <pre class="text-xs text-green-400 font-mono" id="modal-meta"></pre>
                        </div>
                    </div>

                </div>
                
                <div class="bg-gray-50 px-6 py-3 sm:flex sm:flex-row-reverse">
                    <button type="button" onclick="closeLogDetails()" class="w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function viewDetails(button) {
            // Extract data from button's data attributes
            const log = JSON.parse(button.dataset.log);
            const formattedDate = button.dataset.date;
            
            const modal = document.getElementById('log-details-modal');
            const metaContainer = document.getElementById('modal-meta');
            
            // Populate basic fields
            document.getElementById('modal-date').textContent = formattedDate;
            document.getElementById('modal-action').textContent = log.action;
            document.getElementById('modal-description').textContent = log.description;
            document.getElementById('modal-model').textContent = log.model ? `${log.model} #${log.model_id}` : 'N/A';

            // Construct Metadata Object for display
            const metadata = {
                ip_address: log.ip_address,
                user_agent: log.user_agent, // Assuming you have this field, otherwise remove
                properties: log.properties // Assuming you store changed attributes here
            };

            // Pretty print JSON
            metaContainer.textContent = JSON.stringify(metadata, null, 2);

            modal.classList.remove('hidden');
        }

        function closeLogDetails() {
            document.getElementById('log-details-modal').classList.add('hidden');
        }
    </script>
</x-app-layout>