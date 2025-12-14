document.addEventListener('DOMContentLoaded', () => {
    const navButtons = document.querySelectorAll('.guide-spots__nav-btn[role="tab"]');
    const panels = document.querySelectorAll('.guide-spots__panel[role="tabpanel"]');

    if (!navButtons.length || !panels.length) {
        return;
    }

    navButtons.forEach(button => {
        button.addEventListener('click', () => {
            const targetArea = button.getAttribute('data-area');
            const targetPanelId = button.getAttribute('aria-controls');

            // Remove active class from all buttons
            navButtons.forEach(btn => {
                btn.classList.remove('is-active');
                btn.setAttribute('aria-selected', 'false');
            });

            // Add active class to clicked button
            button.classList.add('is-active');
            button.setAttribute('aria-selected', 'true');

            // Hide all panels
            panels.forEach(panel => {
                panel.classList.remove('is-active');
                panel.setAttribute('aria-hidden', 'true');
            });

            // Show target panel
            const targetPanel = document.getElementById(targetPanelId);
            if (targetPanel) {
                targetPanel.classList.add('is-active');
                targetPanel.setAttribute('aria-hidden', 'false');
            }
        });
    });
});

