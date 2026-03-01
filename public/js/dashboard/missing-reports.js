/**
 * missing-reports.js
 * Logic untuk handle Tab laporan dan AJAX Pagination di missing.blade.php
 */

document.addEventListener('DOMContentLoaded', function() {
    let currentActiveTabId = sessionStorage.getItem('last_active_tab') || 'tab-orang';

    const tabButtons = document.querySelectorAll('.tab-button');
    const ajaxContainer = document.getElementById('ajax-pagination-container');

    // 1. Inisialisasi Tab Aktif Pertama Kali
    if (currentActiveTabId) {
        const targetButton = document.querySelector(`[data-tab="${currentActiveTabId}"]`);
        if (targetButton) {
            // Kita beri sedikit delay agar AOS atau komponen lain siap
            setTimeout(() => activateTab(targetButton), 10);
        }
    }

    // 2. Event Listener Klik Tab
    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            currentActiveTabId = button.dataset.tab;
            sessionStorage.setItem('last_active_tab', currentActiveTabId);
            activateTab(button);
        });
    });

    function activateTab(button) {
        const tabId = button.dataset.tab;

        // Reset Styles Buttons
        tabButtons.forEach(btn => {
            btn.classList.remove('active', 'bg-primary/10', 'text-primary');
            btn.classList.add('text-netral-500');
        });

        // Set Active Style
        button.classList.add('active', 'bg-primary/10', 'text-primary');
        button.classList.remove('text-netral-500');

        // Toggle Content Panes
        document.querySelectorAll('.tab-pane').forEach(pane => {
            pane.classList.add('hidden');
        });

        const activePane = document.getElementById(tabId);
        if (activePane) {
            activePane.classList.remove('hidden');
        }
    }

    // 3. AJAX Pagination
    document.addEventListener('click', function(e) {
        const link = e.target.closest('.pagination a, .ajax-pagination a');
        if (link) {
            e.preventDefault();
            const url = link.getAttribute('href');
            loadDashboardData(url);
        }
    });

    function loadDashboardData(url) {
        if (!ajaxContainer) return;

        ajaxContainer.style.opacity = '0.5';

        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            ajaxContainer.innerHTML = data.html;
            ajaxContainer.style.opacity = '1';

            // Re-sync tab state setelah konten baru dimuat
            maintainActiveTab();
        })
        .catch(error => {
            console.error('Error:', error);
            ajaxContainer.style.opacity = '1';
        });
    }

    function maintainActiveTab() {
        document.querySelectorAll('.tab-pane').forEach(p => p.classList.add('hidden'));
        const activePane = document.getElementById(currentActiveTabId);
        if (activePane) {
            activePane.classList.remove('hidden');
        }
    }
});
