<section class="bg-white p-8 rounded-xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)]">
    <header class="mb-8 border-b border-gray-100 pb-4">
        <h2 class="text-xl font-bold text-gray-900">
            {{ __('Profile Information') }}
        </h2>
        <p class="mt-1 text-sm text-gray-500">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- Profile Picture Section -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-4">Profile Picture</label>
            
            <div class="flex flex-col sm:flex-row gap-6 items-start">
                <!-- Profile Picture Preview -->
                <div class="relative group">
                    <div class="w-24 h-24 rounded-full overflow-hidden border border-gray-200 shadow-sm shrink-0 bg-gray-50">
                        @if ($user->profile_picture_path)
                            <img id="preview-image" 
                                 src="{{ Storage::url($user->profile_picture_path) }}" 
                                 alt="{{ $user->name }}" 
                                 class="w-full h-full object-cover">
                        @else
                            <div id="fallback-avatar" class="w-full h-full flex items-center justify-center bg-gray-900 text-white text-2xl font-bold">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <img id="preview-image" src="#" alt="Preview" class="hidden w-full h-full object-cover">
                        @endif
                    </div>
                </div>

                <!-- Upload Controls -->
                <div class="flex-1 w-full max-w-md space-y-3">
                    <!-- Custom File Input -->
                    <div class="relative">
                        <input id="profile_picture" 
                               name="profile_picture" 
                               type="file" 
                               class="hidden" 
                               accept="image/*"
                               onchange="previewFile(this)">
                        
                        <label for="profile_picture" 
                               class="flex items-center justify-center w-full px-4 py-3 border-2 border-dashed border-gray-200 rounded-lg cursor-pointer hover:border-gray-900 hover:bg-gray-50 transition group">
                            <div class="text-center">
                                <span class="text-sm font-medium text-gray-600 group-hover:text-gray-900">Click to upload new picture</span>
                                <p class="text-xs text-gray-400 mt-1">JPG, PNG, GIF (Max 2MB)</p>
                            </div>
                        </label>
                    </div>

                    @if ($user->profile_picture_path)
                        <button type="button" 
                                onclick="deleteProfilePicture()"
                                class="text-xs text-red-600 hover:text-red-800 font-medium flex items-center gap-1 transition">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            Remove current picture
                        </button>
                    @endif
                </div>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('profile_picture')" />
        </div>

        <div class="border-t border-gray-50 my-6"></div>

        <!-- Name Input -->
        <div>
            <x-input-label for="name" :value="__('Name')" class="text-gray-700 font-medium mb-2" />
            <x-text-input id="name" name="name" type="text" 
                class="w-full rounded-lg border-gray-200 focus:border-gray-900 focus:ring-gray-900 transition shadow-sm placeholder-gray-400" 
                :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- Email Input -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-gray-700 font-medium mb-2" />
            <x-text-input id="email" name="email" type="email" 
                class="w-full rounded-lg border-gray-200 focus:border-gray-900 focus:ring-gray-900 transition shadow-sm placeholder-gray-400" 
                :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3 p-3 bg-yellow-50 rounded-lg border border-yellow-100">
                    <p class="text-sm text-yellow-800">
                        {{ __('Your email address is unverified.') }}
                        <button form="send-verification" class="underline font-medium hover:text-yellow-900 ml-1">
                            {{ __('Click here to re-send verification.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-sm text-green-600 font-medium">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Actions -->
        <div class="flex items-center gap-4 pt-4">
            <x-primary-button class="bg-gray-900 hover:bg-gray-800 text-white px-6 py-2.5 rounded-lg transition shadow-sm border border-transparent">
                {{ __('Save Changes') }}
            </x-primary-button>

            @if (session('status') === 'profile-updated')
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

<!-- Scripts -->
<script>
    function previewFile(input) {
        const file = input.files[0];
        if (file) {
            const reader = new FileReader();
            const preview = document.getElementById('preview-image');
            const fallback = document.getElementById('fallback-avatar');

            reader.onload = function(e) {
                if(preview) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                }
                if(fallback) {
                    fallback.classList.add('hidden');
                }
            }
            reader.readAsDataURL(file);
        }
    }

    function deleteProfilePicture() {
        if (confirm('Are you sure you want to remove your profile picture?')) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                             document.querySelector('input[name="_token"]')?.value;
            
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("profile.picture.delete") }}';
            
            const tokenInput = document.createElement('input');
            tokenInput.type = 'hidden';
            tokenInput.name = '_token';
            tokenInput.value = csrfToken;
            
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';
            
            form.appendChild(tokenInput);
            form.appendChild(methodInput);
            document.body.appendChild(form);
            form.submit();
        }
    }
</script>