<!-- Toast Container -->
<div id="toast-container" 
     class="fixed top-4 right-4 z-50 space-y-3"
     x-data="toastManager()"
     @toast.window="addToast($event.detail)">
    
    <template x-for="toast in toasts" :key="toast.id">
        <div x-show="toast.show"
             x-transition:enter="transform ease-out duration-300 transition"
             x-transition:enter-start="translate-x-full opacity-0"
             x-transition:enter-end="translate-x-0 opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             :class="{
                 'bg-green-50 border-green-200': toast.type === 'success',
                 'bg-red-50 border-red-200': toast.type === 'error',
                 'bg-blue-50 border-blue-200': toast.type === 'info',
                 'bg-yellow-50 border-yellow-200': toast.type === 'warning'
             }"
             class="max-w-sm w-full border-l-4 rounded-lg shadow-lg p-4 flex items-start gap-3">
            
            <!-- Icon -->
            <div class="flex-shrink-0">
                <template x-if="toast.type === 'success'">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </template>
                <template x-if="toast.type === 'error'">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </template>
                <template x-if="toast.type === 'info'">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </template>
                <template x-if="toast.type === 'warning'">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </template>
            </div>

            <!-- Message -->
            <div class="flex-1">
                <p x-text="toast.message" 
                   :class="{
                       'text-green-900': toast.type === 'success',
                       'text-red-900': toast.type === 'error',
                       'text-blue-900': toast.type === 'info',
                       'text-yellow-900': toast.type === 'warning'
                   }"
                   class="font-medium"></p>
            </div>

            <!-- Close Button -->
            <button @click="removeToast(toast.id)" 
                    class="flex-shrink-0 text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </template>
</div>

<script>
    function toastManager() {
        return {
            toasts: [],
            nextId: 1,

            addToast(data) {
                const id = this.nextId++;
                const toast = {
                    id: id,
                    message: data.message,
                    type: data.type || 'info',
                    show: false
                };

                this.toasts.push(toast);

                // Show with animation
                setTimeout(() => {
                    const index = this.toasts.findIndex(t => t.id === id);
                    if (index !== -1) {
                        this.toasts[index].show = true;
                    }
                }, 100);

                // Auto remove after 5 seconds
                setTimeout(() => this.removeToast(id), 5000);
            },

            removeToast(id) {
                const index = this.toasts.findIndex(t => t.id === id);
                if (index !== -1) {
                    this.toasts[index].show = false;
                    setTimeout(() => {
                        this.toasts = this.toasts.filter(t => t.id !== id);
                    }, 300);
                }
            }
        }
    }

    // Helper function to show toasts from anywhere
    window.showToast = function(message, type = 'info') {
        window.dispatchEvent(new CustomEvent('toast', {
            detail: { message, type }
        }));
    }
</script>