<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- Profile Picture Section -->
        <div class="flex flex-col gap-4">
            <x-input-label for="profile_picture" :value="__('Profile Picture')" />
            
            <div class="flex items-start gap-6">
                <!-- Profile Picture Preview -->
                <div class="flex-shrink-0">
                    <div class="w-24 h-24 rounded-lg bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center overflow-hidden border-2 border-gray-200">
                        @if ($user->profile_picture_path)
                            <img src="{{ Storage::url($user->profile_picture_path) }}" 
                                 alt="{{ $user->name }}" 
                                 class="w-full h-full object-cover">
                        @else
                            <span class="text-white text-3xl font-bold">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Upload Controls -->
                <div class="flex-1">
                    <div class="space-y-3">
                        <div class="flex items-center justify-center px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg hover:border-gray-400 transition cursor-pointer">
                            <label for="profile_picture" class="flex flex-col items-center justify-center w-full cursor-pointer">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    <span class="text-sm text-gray-600">Upload new picture</span>
                                </div>
                                <input id="profile_picture" 
                                       name="profile_picture" 
                                       type="file" 
                                       class="hidden" 
                                       accept="image/*"
                                       onchange="previewImage(this)">
                            </label>
                        </div>

                        @if ($user->profile_picture_path)
                            <button type="button" 
                                    class="w-full px-4 py-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition font-medium text-sm flex items-center justify-center gap-2"
                                    onclick="deleteProfilePicture()">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Delete Picture
                            </button>
                        @endif

                        <p class="text-xs text-gray-500">
                            Supported formats: JPG, PNG, GIF (Max 2MB)
                        </p>
                    </div>
                </div>
            </div>

            <x-input-error class="mt-2" :messages="$errors->get('profile_picture')" />
        </div>

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif

            @if (session('status') === 'profile-picture-deleted')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600"
                >{{ __('Profile picture deleted.') }}</p>
            @endif
        </div>
    </form>
</section>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            // Simply show the file name, don't auto-submit
            // User will click Save to submit the form with all required fields
            const fileName = input.files[0].name;
            const fileSize = (input.files[0].size / 1024 / 1024).toFixed(2);
            console.log(`File selected: ${fileName} (${fileSize}MB)`);
        }
    }

    function deleteProfilePicture() {
        if (confirm('Are you sure you want to delete your profile picture?')) {
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
