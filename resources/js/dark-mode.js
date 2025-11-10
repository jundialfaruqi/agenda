// Dark Mode Toggle Functionality

// Apply saved theme immediately to prevent flash
function applyThemeImmediately() {
    const savedTheme = localStorage.getItem('theme') || 'light';
    document.documentElement.setAttribute('data-theme', savedTheme);
}

// Apply theme immediately when script loads
applyThemeImmediately();

function initializeDarkMode() {
    const themeController = document.querySelector('.theme-controller');
    const htmlElement = document.documentElement;

    // Check for saved theme preference or default to 'light'
    const savedTheme = localStorage.getItem('theme') || 'light';

    // Apply saved theme
    htmlElement.setAttribute('data-theme', savedTheme);

    // Set checkbox state based on saved theme
    if (themeController) {
        themeController.checked = savedTheme === 'dark';
        
        // Remove existing event listener to prevent duplicates
        themeController.removeEventListener('change', handleThemeChange);
        
        // Add event listener
        themeController.addEventListener('change', handleThemeChange);
    }
}

function handleThemeChange() {
    const htmlElement = document.documentElement;
    const newTheme = this.checked ? 'dark' : 'light';

    // Apply theme
    htmlElement.setAttribute('data-theme', newTheme);

    // Save preference
    localStorage.setItem('theme', newTheme);

    // Optional: Add smooth transition
    htmlElement.style.transition = 'background-color 0.3s ease, color 0.3s ease';
    setTimeout(() => {
        htmlElement.style.transition = '';
    }, 300);
}

// Initialize on DOM content loaded
document.addEventListener('DOMContentLoaded', initializeDarkMode);

// Re-initialize after Livewire navigation
document.addEventListener('livewire:navigated', initializeDarkMode);

// Also listen for Livewire page load (for older versions)
document.addEventListener('livewire:load', initializeDarkMode);