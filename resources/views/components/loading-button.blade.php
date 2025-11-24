@props(['type' => 'submit', 'color' => 'blue'])

<button {{ $attributes->merge(['type' => $type, 'class' => "relative bg-{$color}-600 text-white px-6 py-2 rounded-lg hover:bg-{$color}-700 transition disabled:opacity-50 disabled:cursor-not-allowed"]) }}
        x-data="{ loading: false }"
        @click="loading = true; setTimeout(() => { loading = false }, 3000);"
        :disabled="loading">
    
    <span :class="{ 'invisible': loading }">
        {{ $slot }}
    </span>

    <span x-show="loading" 
          class="absolute inset-0 flex items-center justify-center">
        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    </span>
</button>