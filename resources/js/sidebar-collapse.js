// Sidebar Collapse Functionality
// Function to initialize sidebar collapse functionality
function initializeSidebarCollapse() {
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const sidebar = document.getElementById('sidebar');
    const toggleIcon = sidebarToggle ? sidebarToggle.querySelector('svg path') : null;
    const toggleText = sidebarToggle ? sidebarToggle.querySelector('.menu-item-text') : null;

    if (sidebarToggle && sidebar && toggleIcon) {
        // Remove existing event listeners to prevent duplicates
        const newToggle = sidebarToggle.cloneNode(true);
        sidebarToggle.parentNode.replaceChild(newToggle, sidebarToggle);
        
        // Get references to the new elements
        const freshToggle = document.getElementById('sidebar-toggle');
        const freshToggleIcon = freshToggle ? freshToggle.querySelector('svg path') : null;
        const freshToggleText = freshToggle ? freshToggle.querySelector('.menu-item-text') : null;
        
        if (freshToggle && freshToggleIcon) {
            freshToggle.addEventListener('click', function() {
            // Toggle between collapsed and expanded width
            if (sidebar.classList.contains('w-64') ||
                sidebar.classList.contains('sm:w-72') ||
                sidebar.classList.contains('md:w-80')) {

                // Collapse sidebar
                sidebar.classList.remove('w-64', 'sm:w-72', 'md:w-80');
                sidebar.classList.add('w-20');

                // Hide text elements (but not in dropdown menus)
                document.querySelectorAll('.menu-item-text, .menu-title, .sidebar-title').forEach(
                    el => {
                        // Don't hide text inside details/dropdown menus
                        if (!el.closest('details')) {
                            el.classList.add('hidden');
                        }
                    });

                // Hide dropdown menus completely when sidebar is collapsed
                document.querySelectorAll('.menu details').forEach(details => {
                    details.classList.add('hidden');
                });

                // Show collapsed title (JT)
                document.querySelector('.sidebar-collapsed-title').classList.remove('hidden');

                // Enlarge icons
                document.querySelectorAll('.menu svg').forEach(icon => {
                    icon.classList.add('w-7', 'h-7');
                });

                // Center menu items and add vertical padding
                document.querySelectorAll('.menu a, .menu button').forEach(item => {
                    item.classList.add('justify-center', 'py-3');
                });

                // Center user avatar in collapsed mode and remove border
                const userInfoContainer = document.querySelector('.user-info-container');
                if (userInfoContainer) {
                    userInfoContainer.classList.add('flex', 'justify-center');
                    userInfoContainer.classList.remove('border', 'rounded-lg');
                    userInfoContainer.querySelector('.flex.items-center.justify-between').classList
                        .add('justify-center');
                    userInfoContainer.querySelector('.flex.items-center.justify-between').classList
                        .remove('justify-between');

                    // Hide dropdown menu completely in sidebar when collapsed
                    const dropdownButton = userInfoContainer.querySelector('button');
                    if (dropdownButton) {
                        dropdownButton.classList.add('hidden');
                    }

                    // Hide dropdown content
                    const dropdownContent = userInfoContainer.querySelector('.dropdown-content');
                    if (dropdownContent) {
                        dropdownContent.classList.add('hidden');
                    }

                    // Disable pointer events on the entire user info container
                    userInfoContainer.classList.add('pointer-events-none');

                    // Remove cursor pointer style from all clickable elements
                    const clickableElements = userInfoContainer.querySelectorAll('.cursor-pointer');
                    clickableElements.forEach(el => {
                        el.classList.remove('cursor-pointer');
                    });
                }

                // Change toggle icon to expand icon and center it
                freshToggleIcon.setAttribute('d',
                    'M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9'
                );

                // Ensure SVG icon is centered within its container
                const svgElement = freshToggleIcon.closest('svg');
                if (svgElement) {
                    svgElement.setAttribute('class', 'h-5 w-5 mx-auto');
                }

                // Hide toggle text but keep button visible
                if (freshToggleText) {
                    freshToggleText.classList.add('hidden');
                }

                // Center the collapsed title (JT)
                const collapsedTitle = document.querySelector('.sidebar-collapsed-title');
                if (collapsedTitle) {
                    collapsedTitle.classList.add('block', 'text-center', 'w-full');
                    collapsedTitle.parentElement.classList.add('justify-center');
                    collapsedTitle.parentElement.classList.remove('justify-start');
                }

                // Center the toggle button icon
                freshToggle.classList.add('justify-center');
                freshToggle.classList.remove('px-4');
                freshToggle.classList.add('px-0');
            } else {
                // Expand sidebar
                sidebar.classList.remove('w-20');
                sidebar.classList.add('w-64', 'sm:w-72', 'md:w-80');

                // Show text elements
                document.querySelectorAll('.menu-item-text, .menu-title, .sidebar-title').forEach(
                    el => {
                        el.classList.remove('hidden');
                    });

                // Show dropdown menus when sidebar is expanded
                document.querySelectorAll('.menu details').forEach(details => {
                    details.classList.remove('hidden');
                });

                // Hide collapsed title (JT)
                document.querySelector('.sidebar-collapsed-title').classList.add('hidden');

                // Restore icon size
                document.querySelectorAll('.menu svg').forEach(icon => {
                    icon.classList.remove('w-7', 'h-7');
                });

                // Restore user info container in expanded mode
                const userInfoContainer = document.querySelector('.user-info-container');
                if (userInfoContainer) {
                    userInfoContainer.classList.remove('flex', 'justify-center');
                    userInfoContainer.classList.add('border', 'rounded-lg');
                    userInfoContainer.querySelector('.flex.items-center.justify-center').classList
                        .add('justify-between');
                    userInfoContainer.querySelector('.flex.items-center.justify-center').classList
                        .remove('justify-center');

                    // Show dropdown button again
                    const dropdownButton = userInfoContainer.querySelector('button');
                    if (dropdownButton) {
                        dropdownButton.classList.remove('hidden');
                    }

                    // Show dropdown content
                    const dropdownContent = userInfoContainer.querySelector('.dropdown-content');
                    if (dropdownContent) {
                        dropdownContent.classList.remove('hidden');
                    }

                    // Re-enable pointer events on the user info container
                    userInfoContainer.classList.remove('pointer-events-none');

                    // Restore cursor pointer style to clickable elements
                    const clickableDiv = userInfoContainer.querySelector('div[tabindex="0"]');
                    if (clickableDiv) {
                        clickableDiv.classList.add('cursor-pointer');
                    }

                    // Restore cursor pointer to button
                    if (dropdownButton) {
                        dropdownButton.classList.add('cursor-pointer');
                    }
                }

                // Restore menu item alignment and remove vertical padding
                document.querySelectorAll('.menu a, .menu button').forEach(item => {
                    item.classList.remove('justify-center', 'py-3');
                });

                // Change toggle icon back to collapse icon
                freshToggleIcon.setAttribute('d',
                    'M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15'
                );

                // Reset SVG icon styling
                const svgElement = freshToggleIcon.closest('svg');
                if (svgElement) {
                    svgElement.setAttribute('class', 'h-5 w-5 mr-2');
                }

                // Show toggle text
                if (freshToggleText) {
                    freshToggleText.classList.remove('hidden');
                }

                // Restore sidebar title alignment
                const sidebarTitle = document.querySelector('.sidebar-title');
                const collapsedTitle = document.querySelector('.sidebar-collapsed-title');
                if (sidebarTitle && collapsedTitle) {
                    // Hide collapsed title
                    collapsedTitle.classList.add('hidden');
                    collapsedTitle.classList.remove('block');

                    // Show main title and restore parent alignment
                    sidebarTitle.classList.remove('hidden');
                    sidebarTitle.parentElement.classList.remove('justify-center');
                    sidebarTitle.parentElement.classList.add('justify-start');
                }

                // Restore toggle button padding
                freshToggle.classList.remove('justify-center');
                freshToggle.classList.add('px-4');
                freshToggle.classList.remove('px-0');
            }
            });
        }
    }
}

// Initialize sidebar collapse on page load
document.addEventListener('DOMContentLoaded', initializeSidebarCollapse);

// Re-initialize sidebar collapse after Livewire navigation
document.addEventListener('livewire:navigated', initializeSidebarCollapse);