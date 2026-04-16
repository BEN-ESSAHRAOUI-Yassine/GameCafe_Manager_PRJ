// Aji L3bo Café - App JavaScript

document.addEventListener('DOMContentLoaded', function() {
    
    // Live elapsed time counter
    const elapsedElements = document.querySelectorAll('.elapsed-time');
    
    if (elapsedElements.length > 0) {
        // Track start times by element ID
        const startTimes = {};
        
        elapsedElements.forEach(el => {
            const id = el.dataset.id;
            const startTime = parseInt(el.dataset.start);
            if (id && startTime) {
                startTimes[id] = startTime;
            }
        });
        
        // Update every minute
        setInterval(() => {
            updateElapsedTimes(startTimes);
        }, 60000);
        
        // Initial update
        updateElapsedTimes(startTimes);
    }
    
    // Confirmation dialogs
    const confirmButtons = document.querySelectorAll('[data-confirm]');
    
    confirmButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            const message = this.dataset.confirm || 'Êtes-vous sûr ?';
            if (!confirm(message)) {
                e.preventDefault();
                return false;
            }
        });
    });
    
    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    });
});

function updateElapsedTimes(startTimes) {
    Object.keys(startTimes).forEach(id => {
        const startTime = startTimes[id];
        const elapsed = Math.floor((Date.now() / 1000 - startTime) / 60);
        const el = document.getElementById('elapsed-' + id);
        if (el) {
            el.textContent = elapsed + 'm';
        }
    });
}