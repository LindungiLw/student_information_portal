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

    // --- Hero Progressive Smooth Shrink on Scroll ---
    const heroWrapper = document.querySelector('.hero-wrapper');
    const hero        = document.querySelector('.hero');
    const heroContent = document.querySelector('.hero-content');
    const heroH1      = document.querySelector('.hero-content h1');
    const heroP       = document.querySelector('.hero-content p');

    if (heroWrapper && hero) {
        // Konfigurasi nilai awal → akhir
        const CONFIG = {
            scrollStart  : 0,    // mulai shrink dari scroll ini
            scrollEnd    : 140,  // selesai shrink di scroll ini
            heightFrom   : 220,  // tinggi banner awal (px)
            heightTo     : 70,   // tinggi banner akhir (px)
            radiusFrom   : 20,   // border-radius awal
            radiusTo     : 14,   // border-radius akhir
            fontFrom     : 32,   // font-size h1 awal
            fontTo       : 18,   // font-size h1 akhir
            padBotFrom   : 25,   // padding-bottom wrapper awal
            padBotTo     : 10,   // padding-bottom wrapper akhir
        };

        // Easing function (ease-out cubic) — makin smooth di akhir
        const easeOutCubic = t => 1 - Math.pow(1 - t, 3);

        // Interpolasi linear
        const lerp = (from, to, t) => from + (to - from) * t;

        let currentScroll = 0;
        let targetScroll  = 0;
        let rafId         = null;

        const applyHeroStyles = (progress) => {
            const p = easeOutCubic(Math.min(Math.max(progress, 0), 1));

            // Hero height & radius
            hero.style.height       = lerp(CONFIG.heightFrom, CONFIG.heightTo, p) + 'px';
            hero.style.borderRadius = lerp(CONFIG.radiusFrom, CONFIG.radiusTo, p) + 'px';

            // Wrapper bottom padding
            heroWrapper.style.paddingBottom = lerp(CONFIG.padBotFrom, CONFIG.padBotTo, p) + 'px';

            // H1 font size
            if (heroH1) {
                heroH1.style.fontSize    = lerp(CONFIG.fontFrom, CONFIG.fontTo, p) + 'px';
                heroH1.style.marginBottom = lerp(6, 0, p) + 'px';
            }

            // Subtitle fade out mulai di 40% scroll
            if (heroP) {
                const subtitleP = Math.min(Math.max((p - 0.3) / 0.4, 0), 1);
                heroP.style.opacity   = 1 - subtitleP;
                heroP.style.maxHeight = lerp(30, 0, subtitleP) + 'px';
            }

            // Box shadow lebih dalam saat mengecil (layering effect)
            const shadowOpacity = lerp(0.12, 0.22, p);
            hero.style.boxShadow = `0 ${lerp(8, 5, p)}px ${lerp(25, 18, p)}px rgba(0,0,0,${shadowOpacity})`;
        };

        // Smooth lerp loop via rAF
        const smoothUpdate = () => {
            // Lerp current → target (faktor 0.1 = sangat smooth, 0.2 = medium)
            currentScroll += (targetScroll - currentScroll) * 0.12;

            const rawProgress = (currentScroll - CONFIG.scrollStart)
                              / (CONFIG.scrollEnd - CONFIG.scrollStart);

            applyHeroStyles(rawProgress);

            // Terus loop jika belum konvergen
            if (Math.abs(targetScroll - currentScroll) > 0.3) {
                rafId = requestAnimationFrame(smoothUpdate);
            } else {
                rafId = null;
            }
        };

        window.addEventListener('scroll', () => {
            targetScroll = window.scrollY;
            if (!rafId) {
                rafId = requestAnimationFrame(smoothUpdate);
            }
        }, { passive: true });

        // Init state
        applyHeroStyles(0);
    }

    // Removed SMART MOBILE PDF HANDLER to allow native iframe PDF viewing on mobile.
});
