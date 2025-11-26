<section class="bg-white p-8 rounded-xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)]">
    <header class="mb-8 border-b border-gray-100 pb-4">
        <h2 class="text-xl font-bold text-gray-900">
            {{ __('Update Password') }}
        </h2>
        <p class="mt-1 text-sm text-gray-500">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Current Password')" class="text-gray-700 font-medium mb-2" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" 
                class="w-full rounded-lg border-gray-200 focus:border-gray-900 focus:ring-gray-900 transition shadow-sm" 
                autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('New Password')" class="text-gray-700 font-medium mb-2" />
            <x-text-input id="update_password_password" name="password" type="password" 
                class="w-full rounded-lg border-gray-200 focus:border-gray-900 focus:ring-gray-900 transition shadow-sm" 
                autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" class="text-gray-700 font-medium mb-2" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" 
                class="w-full rounded-lg border-gray-200 focus:border-gray-900 focus:ring-gray-900 transition shadow-sm" 
                autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4 pt-4">
            <x-primary-button class="bg-gray-900 hover:bg-gray-800 text-white px-6 py-2.5 rounded-lg transition shadow-sm border border-transparent">
                {{ __('Save Password') }}
            </x-primary-button>

            @if (session('status') === 'password-updated')
                <div x-data="{ show: true }"
                     x-show="show"
                     x-transition
                     x-init="setTimeout(() => show = false, 2000)"
                     class="flex items-center gap-2 text-sm text-green-600 font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    {{ __('Saved.') }}
                </div>
            @endif
        </div>
    </form>
</section>