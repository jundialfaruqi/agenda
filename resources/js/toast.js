// Toast notification handler for Livewire applications
class ToastManager {
    constructor() {
        this.init();
    }

    init() {
        // Initialize when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => this.handleToasts());
        } else {
            this.handleToasts();
        }

        // Listen for Livewire navigation events
        document.addEventListener('livewire:navigated', () => {
            setTimeout(() => this.handleToasts(), 100);
        });

        // Listen for Livewire updates
        document.addEventListener('livewire:updated', () => {
            setTimeout(() => this.handleToasts(), 100);
        });

        // Also listen for standard Livewire load event
        document.addEventListener('livewire:load', () => {
            setTimeout(() => this.handleToasts(), 100);
        });

        // Listen for custom toast events from Livewire
        window.addEventListener('toast-success', (event) => {
            this.createDynamicToast('success', event.detail.message);
        });

        window.addEventListener('toast-error', (event) => {
            this.createDynamicToast('error', event.detail.message);
        });
    }

    handleToasts() {
        const successToast = document.getElementById('success-toast');
        const errorToast = document.getElementById('error-toast');

        if (successToast) {
            this.showToast('success-toast');
        }

        if (errorToast) {
            this.showToast('error-toast');
        }
    }

    showToast(toastId) {
        const toast = document.getElementById(toastId);
        if (toast) {
            // Remove initial hidden classes and add visible classes
            setTimeout(() => {
                toast.classList.remove('opacity-0', 'translate-x-full');
                toast.classList.add('opacity-100', 'translate-x-0');
            }, 100);

            // Auto hide after 5 seconds
            setTimeout(() => {
                this.hideToast(toastId);
            }, 5000);
        }
    }

    hideToast(toastId) {
        const toast = document.getElementById(toastId);
        if (toast) {
            toast.classList.remove('opacity-100', 'translate-x-0');
            toast.classList.add('opacity-0', 'translate-x-full');

            // Remove from DOM after animation completes
            setTimeout(() => {
                const container = document.getElementById('toast-container');
                if (container && container.children.length <= 1) {
                    container.remove();
                } else if (toast.parentNode) {
                    toast.remove();
                }
            }, 300);
        }
    }

    createDynamicToast(type, message) {
        // Remove existing toast container if it exists
        const existingContainer = document.getElementById('toast-container');
        if (existingContainer) {
            existingContainer.remove();
        }

        // Create toast container
        const container = document.createElement('div');
        container.className = 'toast toast-top toast-end z-50';
        container.id = 'toast-container';

        // Create toast element
        const toast = document.createElement('div');
        const toastId = `${type}-toast`;
        toast.id = toastId;
        toast.className = `alert alert-${type} shadow-lg opacity-0 transform translate-x-full transition-all duration-300 ease-in-out`;

        // Create icon based on type
        const icon = type === 'success' 
            ? `<svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
               </svg>`
            : `<svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
               </svg>`;

        toast.innerHTML = `
            ${icon}
            <span>${message}</span>
            <button class="btn btn-sm btn-circle btn-ghost ml-2" onclick="hideToast('${toastId}')">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        `;

        container.appendChild(toast);
        document.body.appendChild(container);

        // Show the toast
        this.showToast(toastId);
    }
}

// Make hideToast function globally available for onclick handlers
window.hideToast = function(toastId) {
    if (window.toastManager) {
        window.toastManager.hideToast(toastId);
    }
};

// Initialize toast manager
window.toastManager = new ToastManager();

export default ToastManager;