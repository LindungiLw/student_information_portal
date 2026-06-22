// Vanilla JavaScript untuk Portal Mahasiswa

// --- GLOBAL DARK MODE INIT ---
// Dijalankan secepat mungkin sebelum DOM penuh termuat jika memungkinkan, 
// atau saat DOMContentLoaded untuk menghindari flash of white
if (localStorage.getItem('darkMode') === 'enabled') {
    document.body.classList.add('dark-mode');
}

document.addEventListener('DOMContentLoaded', () => {
    console.log('Portal Informasi Mahasiswa - Initialized');
    
    // Accordion Logic for Academics Page
    const accordions = document.querySelectorAll('.accordion-header');
    accordions.forEach(acc => {
        acc.addEventListener('click', function() {
            const item = this.parentElement;
            const content = item.querySelector('.accordion-content');
            
            // Close other accordions (Optional, un-comment to allow only one open at a time)
            /*
            document.querySelectorAll('.accordion-item').forEach(otherItem => {
                if(otherItem !== item) {
                    otherItem.classList.remove('active');
                    otherItem.querySelector('.accordion-content').style.maxHeight = null;
                }
            });
            */
            
            // Toggle current accordion
            item.classList.toggle('active');
            if (item.classList.contains('active')) {
                content.style.maxHeight = content.scrollHeight + "px";
            } else {
                content.style.maxHeight = null;
            }
        });
    });

    // Efek sederhana saat input focus
    const inputs = document.querySelectorAll('input');
    inputs.forEach(input => {
        input.addEventListener('focus', () => {
            input.parentElement.style.transform = 'scale(1.02)';
            input.parentElement.style.transition = 'transform 0.3s ease';
        });
        
        input.addEventListener('blur', () => {
            input.parentElement.style.transform = 'scale(1)';
        });
    });

    // --- Mobile Sidebar Toggle Logic ---
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const sidebar = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    if (mobileMenuBtn && sidebar && sidebarOverlay) {
        // Buka/Tutup sidebar jika tombol hamburger ditekan
        mobileMenuBtn.addEventListener('click', () => {
            sidebar.classList.toggle('active');
            sidebarOverlay.classList.toggle('active');
        });

        // Tutup sidebar jika overlay hitam ditekan
        sidebarOverlay.addEventListener('click', () => {
            sidebar.classList.remove('active');
            sidebarOverlay.classList.remove('active');
        });
    }
});
