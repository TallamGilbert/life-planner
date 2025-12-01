<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Account Settings') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ currentTab: 'profile' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
                
                <!-- Sidebar Navigation -->
                <aside class="py-6 px-2 sm:px-6 lg:py-0 lg:px-0 lg:col-span-3">
                    <nav class="space-y-1">
                        <!-- Profile Tab -->
                        <button @click="currentTab = 'profile'" 
                            :class="currentTab === 'profile' ? 'bg-gray-50 text-indigo-700 hover:text-indigo-700 hover:bg-white' : 'text-gray-900 hover:text-gray-900 hover:bg-gray-50'"
                            class="group rounded-md px-3 py-2 flex items-center text-sm font-medium w-full transition-colors">
                            <svg class="text-gray-400 group-hover:text-gray-500 flex-shrink-0 -ml-1 mr-3 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span class="truncate">Profile</span>
                        </button>

                        <!-- Security Tab -->
                        <button @click="currentTab = 'security'" 
                            :class="currentTab === 'security' ? 'bg-gray-50 text-indigo-700 hover:text-indigo-700 hover:bg-white' : 'text-gray-900 hover:text-gray-900 hover:bg-gray-50'"
                            class="group rounded-md px-3 py-2 flex items-center text-sm font-medium w-full transition-colors">
                            <svg class="text-gray-400 group-hover:text-gray-500 flex-shrink-0 -ml-1 mr-3 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <span class="truncate">Security</span>
                        </button>
                        
                        <!-- Preferences Tab (New Feature) -->
                        <button @click="currentTab = 'preferences'" 
                            :class="currentTab === 'preferences' ? 'bg-gray-50 text-indigo-700 hover:text-indigo-700 hover:bg-white' : 'text-gray-900 hover:text-gray-900 hover:bg-gray-50'"
                            class="group rounded-md px-3 py-2 flex items-center text-sm font-medium w-full transition-colors">
                            <svg class="text-gray-400 group-hover:text-gray-500 flex-shrink-0 -ml-1 mr-3 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="truncate">Preferences</span>
                        </button>
                    </nav>
                </aside>

                <!-- Main Content Area -->
                <div class="space-y-6 sm:px-6 lg:px-0 lg:col-span-9">
                    
                    <!-- Profile Tab Content -->
                    <div x-show="currentTab === 'profile'" class="bg-white shadow sm:rounded-lg p-6">
                        @include('profile.partials.update-profile-information-form')
                    </div>

                    <!-- Security Tab Content -->
                    <div x-show="currentTab === 'security'" class="space-y-6">
                        <div class="bg-white shadow sm:rounded-lg p-6">
                            @include('profile.partials.update-password-form')
                        </div>
                        <div class="bg-white shadow sm:rounded-lg p-6">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                    
                    <!-- Preferences Tab Content -->
                    <div x-show="currentTab === 'preferences'" class="bg-white shadow sm:rounded-lg p-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Application Preferences</h2>
                        <!-- Example Preferences Form -->
                        <form class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Timezone</label>
                                <select class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option>Africa/Nairobi</option>
                                    <option>UTC</option>
                                    <option>America/New_York</option>
                                </select>
                            </div>
                            <div class="flex items-center">
                                <input id="notifications" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                <label for="notifications" class="ml-2 block text-sm text-gray-900">Receive email reminders</label>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>