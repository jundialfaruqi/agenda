function updateIcons(button, isShown) {
  // Support DaisyUI swap component if present
  if (button.classList.contains('swap')) {
    button.classList.toggle('swap-active', isShown);
  } else {
    // Fallback to manual icon toggling
    const openIcon = button.querySelector('.icon-eye-open');
    const closedIcon = button.querySelector('.icon-eye-closed');
    if (openIcon) openIcon.classList.toggle('hidden', !isShown);
    if (closedIcon) closedIcon.classList.toggle('hidden', isShown);
  }
}

function initPasswordToggle() {
  const buttons = document.querySelectorAll('[data-toggle="password"]');
  buttons.forEach((button) => {
    const targetId = button.getAttribute('data-target');
    const input = document.getElementById(targetId);
    if (!input) return;

    // Initialize icon state based on current input type
    updateIcons(button, input.type === 'text');

    // Avoid duplicate listeners by cloning button
    const newButton = button.cloneNode(true);
    button.parentNode.replaceChild(newButton, button);

    newButton.addEventListener('click', (e) => {
      e.preventDefault();
      input.type = input.type === 'password' ? 'text' : 'password';
      updateIcons(newButton, input.type === 'text');
    });
  });
}

document.addEventListener('DOMContentLoaded', initPasswordToggle);
document.addEventListener('livewire:navigated', initPasswordToggle);