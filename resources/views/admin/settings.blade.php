<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 tracking-tight">
                    System Settings
                </h2>
                <p class="text-sm text-gray-500 mt-1">Configure global application preferences and limits</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" 
               class="group inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-700 hover:border-gray-300 hover:text-gray-900 hover:bg-gray-50 transition shadow-sm">
                <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
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

            <form method="POST" action="{{ route('admin.settings.update') }}">
                @csrf

                @foreach($settings as $group => $groupSettings)
                    <!-- Settings Group Card -->
                    <div class="bg-white rounded-2xl border border-gray-200/60 shadow-sm overflow-hidden mb-6">
                        <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/30 flex items-center gap-2">
                            <div class="w-1 h-4 bg-blue-500 rounded-full"></div>
                            <h3 class="text-lg font-bold text-gray-900 capitalize">{{ str_replace('_', ' ', $group) }}</h3>
                        </div>
                        
                        <div class="p-6 space-y-6">
                            @foreach($groupSettings as $setting)
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                    <div class="flex-1">
                                        <label for="setting_{{ $setting->key }}" class="block text-sm font-semibold text-gray-900">
                                            {{ ucwords(str_replace('_', ' ', $setting->key)) }}
                                        </label>
                                        <p class="text-xs text-gray-500 mt-0.5">
                                            Configuration for {{ str_replace('_', ' ', $setting->key) }}
                                        </p>
                                    </div>
                                    
                                    <div class="w-full sm:w-64">
                                        @if($setting->type === 'boolean')
                                            <!-- Modern Toggle Switch -->
                                            <div class="flex items-center justify-end">
                                                <input type="hidden" name="settings[{{ $setting->key }}]" value="0">
                                                <label class="relative inline-flex items-center cursor-pointer">
                                                    <input type="checkbox" 
                                                           id="setting_{{ $setting->key }}"
                                                           name="settings[{{ $setting->key }}]" 
                                                           value="1"
                                                           {{ $setting->value ? 'checked' : '' }}
                                                           class="sr-only peer">
                                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-100 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                                    <span class="ml-3 text-sm font-medium text-gray-600 peer-checked:text-blue-600 transition-colors">
                                                        {{ $setting->value ? 'Enabled' : 'Disabled' }}
                                                    </span>
                                                </label>
                                            </div>
                                        
                                        @elseif($setting->type === 'integer')
                                            <input type="number" 
                                                   id="setting_{{ $setting->key }}"
                                                   name="settings[{{ $setting->key }}]" 
                                                   value="{{ $setting->value }}"
                                                   class="w-full px-4 py-2 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block transition shadow-sm placeholder-gray-400">
                                        
                                        @else
                                            <input type="text" 
                                                   id="setting_{{ $setting->key }}"
                                                   name="settings[{{ $setting->key }}]" 
                                                   value="{{ $setting->value }}"
                                                   class="w-full px-4 py-2 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block transition shadow-sm placeholder-gray-400">
                                        @endif
                                    </div>
                                </div>
                                @if(!$loop->last)
                                    <hr class="border-gray-100">
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endforeach

                <!-- Floating/Sticky Action Bar -->
                <div class="sticky bottom-6 mt-8">
                    <div class="bg-gray-900/95 backdrop-blur-md rounded-2xl shadow-xl p-4 flex justify-between items-center max-w-4xl mx-auto border border-white/10 text-white">
                        <div class="flex items-center gap-3 px-2">
                            <div class="p-2 bg-white/10 rounded-lg">
                                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div class="hidden sm:block">
                                <p class="text-sm font-medium">Unsaved changes?</p>
                                <p class="text-xs text-gray-400">Don't forget to save your updates.</p>
                            </div>
                        </div>
                        <button type="submit" 
                                class="flex items-center gap-2 px-6 py-2.5 bg-blue-600 hover:bg-blue-500 text-white rounded-xl font-semibold text-sm transition shadow-lg shadow-blue-900/20 transform hover:-translate-y-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                            Save Changes
                        </button>
                    </div>
                </div>

            </form>

        </div>
    </div>
</x-app-layout>