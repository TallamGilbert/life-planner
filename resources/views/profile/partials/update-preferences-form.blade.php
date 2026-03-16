<section class="bg-white p-8 rounded-xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)]">
    <header class="mb-8 border-b border-gray-100 pb-4">
        <h2 class="text-xl font-bold text-gray-900">
            {{ __('Application Preferences') }}
        </h2>
        <p class="mt-1 text-sm text-gray-500">
            {{ __('Customize your application experience and notification settings.') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.preferences.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        <!-- Timezone Selection -->
        <div>
            <x-input-label for="timezone" :value="__('Timezone')" class="text-gray-700 font-medium mb-2" />
            <select id="timezone" name="timezone"
                class="w-full rounded-lg border-gray-200 focus:border-gray-900 focus:ring-gray-900 transition shadow-sm"
                required>
                <option value="">Select a timezone...</option>
                @php
                    $timezones = timezone_identifiers_list();
                    $currentTz = $preferences?->timezone ?? config('app.timezone', 'UTC');
                @endphp
                <optgroup label="Common Timezones">
                    <option value="UTC" @selected($currentTz === 'UTC')>UTC (Coordinated Universal Time)</option>
                    <option value="America/New_York" @selected($currentTz === 'America/New_York')>America/New_York</option>
                    <option value="Europe/London" @selected($currentTz === 'Europe/London')>Europe/London</option>
                    <option value="Europe/Paris" @selected($currentTz === 'Europe/Paris')>Europe/Paris</option>
                    <option value="Africa/Cairo" @selected($currentTz === 'Africa/Cairo')>Africa/Cairo</option>
                    <option value="Asia/Tokyo" @selected($currentTz === 'Asia/Tokyo')>Asia/Tokyo</option>
                    <option value="Australia/Sydney" @selected($currentTz === 'Australia/Sydney')>Australia/Sydney</option>
                </optgroup>
                <optgroup label="All Timezones">
                    @foreach($timezones as $tz)
                        <option value="{{ $tz }}" @selected($currentTz === $tz)>{{ $tz }}</option>
                    @endforeach
                </optgroup>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('timezone')" />
        </div>

        <!-- Email Notifications Toggle -->
        <div class="space-y-3">
            <div class="flex items-center">
                <input id="email_notifications_enabled" name="email_notifications_enabled" type="checkbox" value="1"
                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                    @checked($preferences?->email_notifications_enabled ?? true)
                    onchange="document.getElementById('email_summary_options').style.display = this.checked ? 'block' : 'none'">
                <label for="email_notifications_enabled" class="ml-3 block text-sm font-medium text-gray-900">
                    {{ __('Receive email notifications') }}
                </label>
            </div>
            <p class="ml-7 text-xs text-gray-500">
                {{ __('Get notified about important updates and reminders') }}
            </p>
        </div>

        <!-- Email Summary Options -->
        <div id="email_summary_options" class="space-y-3 pl-7 border-l-2 border-gray-200"
            style="display: {{ ($preferences?->email_notifications_enabled ?? true) ? 'block' : 'none' }}">

            <!-- Email Summary Toggle -->
            <div class="flex items-center">
                <input id="email_summary_enabled" name="email_summary_enabled" type="checkbox" value="1"
                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                    @checked($preferences?->email_summary_enabled ?? true)
                    onchange="document.getElementById('summary_frequency').style.display = this.checked ? 'block' : 'none'">
                <label for="email_summary_enabled" class="ml-3 block text-sm font-medium text-gray-900">
                    {{ __('Receive email summary') }}
                </label>
            </div>
            <p class="ml-7 text-xs text-gray-500">
                {{ __('Get a periodic summary of your activity') }}
            </p>

            <!-- Summary Frequency -->
            <div id="summary_frequency"
                style="display: {{ ($preferences?->email_summary_enabled ?? true) ? 'block' : 'none' }}">
                <x-input-label for="email_summary_frequency" :value="__('Summary Frequency')" class="text-gray-700 font-medium mb-2" />
                <select id="email_summary_frequency" name="email_summary_frequency"
                    class="w-full rounded-lg border-gray-200 focus:border-gray-900 focus:ring-gray-900 transition shadow-sm">
                    <option value="daily" @selected(($preferences?->email_summary_frequency ?? 'weekly') === 'daily')>
                        {{ __('Daily') }}
                    </option>
                    <option value="weekly" @selected(($preferences?->email_summary_frequency ?? 'weekly') === 'weekly')>
                        {{ __('Weekly') }}
                    </option>
                    <option value="monthly" @selected(($preferences?->email_summary_frequency ?? 'weekly') === 'monthly')>
                        {{ __('Monthly') }}
                    </option>
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('email_summary_frequency')" />
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center gap-4 pt-4 border-t border-gray-100">
            <x-primary-button class="bg-gray-900 hover:bg-gray-800 text-white px-6 py-2.5 rounded-lg transition shadow-sm border border-transparent">
                {{ __('Save Preferences') }}
            </x-primary-button>

            @if (session('status') === 'preferences-updated')
                <div x-data="{ show: true }"
                     x-show="show"
                     x-transition
                     x-init="setTimeout(() => show = false, 2000)"
                     class="flex items-center gap-2 text-sm text-green-600 font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    {{ __('Preferences saved successfully.') }}
                </div>
            @endif
        </div>
    </form>
</section>
