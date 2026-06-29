<?php
// Dapatkan nama file saat ini untuk menentukan status 'active' pada menu sidebar
$current_page = basename($_SERVER['PHP_SELF']);

// Fungsi bantuan untuk menandai menu aktif
function is_active($page, $current_page) {
    return ($page == $current_page) ? 'active' : '';
}

// Ambil data sesi (sudah diatur di file utama, tapi kita pastikan fallback jika kosong)
$user_name = isset($_SESSION['name']) ? $_SESSION['name'] : 'Guest User';
$user_id = isset($_SESSION['nim']) ? 'ID: ' . $_SESSION['nim'] : 'ID: Unknown';

// Buat inisial avatar (2 huruf pertama dari nama)
$words = explode(" ", $user_name);
$initials = "";
foreach ($words as $w) {
  $initials .= mb_substr($w, 0, 1);
}
$avatar_text = strtoupper(mb_substr($initials, 0, 2));
?>

<div class="mobile-header" style="background: rgba(255, 255, 255, 0.96); backdrop-filter: blur(12px); border-bottom: 1px solid rgba(124, 58, 237, 0.18); box-shadow: 0 4px 20px rgba(107, 33, 168, 0.08); padding: 10px 14px; width: 100%; box-sizing: border-box; justify-content: space-between; overflow: hidden;">
    <div class="mobile-logo-group" style="display: flex; align-items: center; gap: 8px; flex: 1; min-width: 0; margin-right: 8px; overflow: hidden;">
        <div style="width: 36px; height: 36px; background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center; gap: 2px; box-shadow: 0 3px 8px rgba(124, 58, 237, 0.35); flex-shrink: 0;">
            <i class="fas fa-person" style="color: #ffffff; font-size: 15px;"></i>
            <i class="fas fa-person-dress" style="color: #fbcfe8; font-size: 15px;"></i>
        </div>
        <span class="mobile-brand-name" style="font-size: 16px; font-weight: 800; background: linear-gradient(135deg, #1e1b4b 0%, #6b21a8 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; letter-spacing: -0.3px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">JIU Student Portal</span>
    </div>
    <div style="display: flex; align-items: center; gap: 8px; flex-shrink: 0;">
        <button type="button" class="mobile-spotlight-btn" onclick="openSpotlight()" title="Quick Search (Ctrl+K)" style="background: rgba(124, 58, 237, 0.08); color: #7c3aed; border: none; width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 15px;">
            <i class="fas fa-magnifying-glass"></i>
        </button>
        <button id="mobileMenuBtn" class="mobile-menu-btn" style="background: #7c3aed; color: #ffffff; border: none; width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 16px; box-shadow: 0 3px 8px rgba(124, 58, 237, 0.3);">
            <i class="fas fa-bars"></i>
        </button>
    </div>
</div>
<div id="sidebarOverlay" class="sidebar-overlay"></div>

<aside id="sidebar" class="sidebar">
    <div class="sidebar-brand">
        <div style="width: 36px; height: 36px; background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center; gap: 2px; box-shadow: 0 3px 8px rgba(124, 58, 237, 0.35); flex-shrink: 0;">
            <i class="fas fa-person" style="color: #ffffff; font-size: 15px;"></i>
            <i class="fas fa-person-dress" style="color: #fbcfe8; font-size: 15px;"></i>
        </div>
        <span class="brand-name" style="font-weight: 800; font-size: 15px; margin-left: 10px; background: linear-gradient(135deg, #ffffff 0%, #cbd5e1 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Student Portal</span>
    </div>

    <!-- Spotlight Quick Search Button -->
    <div class="sidebar-search-container" style="padding: 12px 16px 4px 16px;">
        <button type="button" class="spotlight-trigger-btn" onclick="openSpotlight()">
            <span style="display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-magnifying-glass" style="color: rgba(255,255,255,0.7);"></i>
                <span>Quick Search...</span>
            </span>
            <kbd class="spotlight-kbd">Ctrl K</kbd>
        </button>
    </div>

    <!-- Wrapper yang bisa di-scroll tapi scrollbar-nya tidak terlihat -->
    <div class="sidebar-nav-wrapper">
        <nav class="sidebar-nav">
            <a href="/dashboard.php" class="nav-item <?php echo is_active('dashboard.php', $current_page); ?>">
                <i class="fas fa-house"></i> Dashboard
            </a>

            <div class="nav-section-label">Academics</div>
            <a href="/pages/academics/calendar.php" class="nav-item <?php echo is_active('calendar.php', $current_page); ?>">
                <i class="fas fa-calendar-days"></i> Calendar
            </a>
            <a href="/pages/academics/academics.php" class="nav-item <?php echo is_active('academics.php', $current_page); ?>">
                <i class="fas fa-graduation-cap"></i> Academics
            </a>
            <a href="/pages/academics/department.php" class="nav-item <?php echo is_active('department.php', $current_page); ?>">
                <i class="fas fa-building-columns"></i> Department
            </a>

            <div class="nav-section-label">Finance</div>
            <a href="/pages/finance/cost_of_attendance.php" class="nav-item <?php echo is_active('cost_of_attendance.php', $current_page); ?>">
                <i class="fas fa-coins"></i> Cost of Attendance
            </a>

            <div class="nav-section-label">Campus Life</div>
            <a href="/pages/campus_life/student_affairs.php" class="nav-item <?php echo is_active('student_affairs.php', $current_page); ?>">
                <i class="fas fa-users"></i> Student Affairs
            </a>
            <a href="/pages/campus_life/external_activities.php" class="nav-item <?php echo is_active('external_activities.php', $current_page); ?>">
                <i class="fas fa-globe"></i> External Activities
            </a>
            <a href="/pages/services/student_services.php" class="nav-item <?php echo is_active('student_services.php', $current_page); ?>">
                <i class="fas fa-headset"></i> Student Services
            </a>
        </nav>
    </div>

    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
    <div class="sidebar-nav-wrapper" style="flex: 0 0 auto; border-top: 1px solid rgba(255,255,255,0.1); margin-top: 10px; padding-top: 10px;">
        <nav class="sidebar-nav">
            <div class="nav-section-label">Administration</div>
            <a href="/admin/dashboard.php" class="nav-item" style="color: #6ee7b7;">
                <i class="fas fa-shield-alt"></i> Portal Admin
            </a>
        </nav>
    </div>
    <?php endif; ?>

    <div class="sidebar-bottom">
        <a href="/pages/settings/settings.php" class="sidebar-settings <?php echo is_active('settings.php', $current_page); ?>">
            <i class="fas fa-gear"></i> Settings
        </a>
        <a href="/auth/logout.php" class="sidebar-settings" style="color: #ef4444; margin-bottom: 15px;">
            <i class="fas fa-right-from-bracket"></i> Logout
        </a>
        <div class="sidebar-user">
            <div class="user-avatar"><?php echo htmlspecialchars($avatar_text); ?></div>
            <div class="user-info">
                <div class="user-name"><?php echo htmlspecialchars($user_name); ?></div>
                <div class="user-id"><?php echo htmlspecialchars($user_id); ?></div>
            </div>
        </div>
    </div>
</aside>

<!-- Spotlight Modal Structure -->
<div id="spotlightModal" class="spotlight-modal" onclick="closeSpotlightOutside(event)">
    <div class="spotlight-box">
        <div class="spotlight-header">
            <i class="fas fa-magnifying-glass"></i>
            <input type="text" id="spotlightInput" class="spotlight-input" placeholder="Type a menu, document, or topic... (e.g., 'calendar', 'dorm', 'tuition')" autocomplete="off" oninput="filterSpotlight()">
            <span class="spotlight-esc" onclick="closeSpotlight()">ESC</span>
        </div>
        <div id="spotlightResults" class="spotlight-results">
            <!-- Results injected via JS -->
        </div>
    </div>
</div>

<style>
/* Sticky Page Header Forced */
.page-header {
    background: var(--sidebar-bg) !important;
    position: sticky !important;
    top: 16px !important;
    z-index: 100 !important;
    margin-bottom: 30px !important;
    padding: 16px 24px !important;
    border-radius: 16px !important;
    border: 1px solid rgba(255, 255, 255, 0.15) !important;
    box-shadow: 0 -20px 0 var(--bg-color), 0 10px 30px rgba(0, 0, 0, 0.1) !important;
}
.page-header h1 {
    font-size: 24px !important;
    font-weight: 800 !important;
    color: var(--white) !important;
    margin: 0 0 5px 0 !important;
    display: flex !important;
    align-items: center !important;
    gap: 12px !important;
}
.page-header h1 i, .page-header h1 svg {
    color: var(--white) !important;
}
.page-header p {
    font-size: 15px !important;
    color: rgba(255, 255, 255, 0.85) !important;
    margin: 0 !important;
}

/* Penyesuaian layar HP (Mobile Size Adjustment) */
@media (max-width: 768px) {
    .page-header {
        top: 10px !important;
        padding: 12px 16px !important;
        margin-bottom: 15px !important;
        border-radius: 12px !important;
    }
    .page-header h1 {
        font-size: 18px !important;
        gap: 8px !important;
    }
    .page-header p {
        font-size: 13px !important;
    }
}

/* Spotlight Trigger Button */
.spotlight-trigger-btn {
    width: 100%;
    background: rgba(255, 255, 255, 0.12);
    border: 1px solid rgba(255, 255, 255, 0.18);
    border-radius: 10px;
    padding: 9px 12px;
    color: rgba(255, 255, 255, 0.85);
    font-size: 13.5px;
    font-family: inherit;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: all 0.2s ease;
}
.spotlight-trigger-btn:hover {
    background: rgba(255, 255, 255, 0.2);
    color: #fff;
    border-color: rgba(255, 255, 255, 0.3);
}
.spotlight-kbd {
    background: rgba(0, 0, 0, 0.25);
    border: 1px solid rgba(255, 255, 255, 0.15);
    border-radius: 5px;
    padding: 2px 6px;
    font-size: 11px;
    font-weight: 600;
    color: rgba(255, 255, 255, 0.9);
}

.mobile-spotlight-btn {
    background: transparent;
    border: none;
    color: var(--sidebar-bg);
    font-size: 18px;
    cursor: pointer;
    padding: 6px 10px;
}

/* Spotlight Modal Window */
.spotlight-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    z-index: 999999;
    background: rgba(15, 23, 42, 0.65);
    backdrop-filter: blur(6px);
    align-items: flex-start;
    justify-content: center;
    padding: 80px 16px 20px 16px;
}
.spotlight-modal.active {
    display: flex;
    animation: spotlightFadeIn 0.15s ease-out;
}
@keyframes spotlightFadeIn {
    from { opacity: 0; transform: scale(0.98); }
    to { opacity: 1; transform: scale(1); }
}

.spotlight-box {
    background: #ffffff;
    width: 100%;
    max-width: 640px;
    border-radius: 18px;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35), 0 0 0 1px rgba(107, 111, 160, 0.2);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    max-height: 80vh;
}
body.dark-mode .spotlight-box {
    background: #1e293b;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.spotlight-header {
    display: flex;
    align-items: center;
    padding: 16px 20px;
    border-bottom: 1px solid #e2e8f0;
    gap: 14px;
}
body.dark-mode .spotlight-header {
    border-bottom-color: rgba(255, 255, 255, 0.08);
}
.spotlight-header i {
    font-size: 20px;
    color: #6b6fa0;
}
.spotlight-input {
    flex-grow: 1;
    border: none;
    outline: none;
    font-size: 16px;
    font-family: inherit;
    color: #1e293b;
    background: transparent;
}
body.dark-mode .spotlight-input {
    color: #f8fafc;
}
.spotlight-input::placeholder {
    color: #94a3b8;
}
.spotlight-esc {
    font-size: 11px;
    font-weight: 700;
    background: #f1f5f9;
    color: #64748b;
    padding: 4px 8px;
    border-radius: 6px;
    border: 1px solid #cbd5e1;
    cursor: pointer;
}
body.dark-mode .spotlight-esc {
    background: #334155;
    color: #cbd5e1;
    border-color: #475569;
}

.spotlight-results {
    padding: 12px;
    overflow-y: auto;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    gap: 4px;
}
.spotlight-section-title {
    font-size: 11px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    color: #94a3b8;
    padding: 8px 12px 4px 12px;
}

.spotlight-item {
    display: flex;
    align-items: center;
    padding: 10px 14px;
    border-radius: 12px;
    text-decoration: none;
    color: #1e293b;
    gap: 14px;
    transition: all 0.15s ease;
    cursor: pointer;
}
body.dark-mode .spotlight-item {
    color: #e2e8f0;
}
.spotlight-item:hover, .spotlight-item.selected {
    background: #f1f5f9;
    color: #6b6fa0;
}
body.dark-mode .spotlight-item:hover, body.dark-mode .spotlight-item.selected {
    background: rgba(107, 111, 160, 0.2);
    color: #fff;
}
.spotlight-item-icon {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    background: rgba(107, 111, 160, 0.1);
    color: #6b6fa0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    flex-shrink: 0;
}
.spotlight-item.doc .spotlight-item-icon {
    background: rgba(239, 68, 68, 0.1);
    color: #ef4444;
}
.spotlight-item-text {
    flex-grow: 1;
    min-width: 0;
}
.spotlight-item-title {
    font-weight: 700;
    font-size: 14.5px;
    margin-bottom: 2px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.spotlight-item-desc {
    font-size: 12px;
    color: #64748b;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
body.dark-mode .spotlight-item-desc {
    color: #94a3b8;
}
.spotlight-item-action {
    font-size: 12px;
    font-weight: 600;
    color: #94a3b8;
}

.spotlight-empty {
    padding: 32px 16px;
    text-align: center;
    color: #64748b;
}
</style>

<script>
const SEARCH_INDEX = [
    { title: "Dashboard", desc: "Main portal overview and announcements", url: "/dashboard.php", icon: "fa-house", category: "Navigation Menu" },
    { title: "Academic Calendar", desc: "Official academic year schedule, holidays, exam dates", url: "/pages/academics/calendar.php", icon: "fa-calendar-days", category: "Navigation Menu" },
    { title: "Academics & KRS", desc: "Course registration, student grades, transcript", url: "/pages/academics/academics.php", icon: "fa-graduation-cap", category: "Navigation Menu" },
    { title: "Department Documents", desc: "IT, English, Business major guidelines and syllabus", url: "/pages/academics/department.php", icon: "fa-building-columns", category: "Navigation Menu" },
    { title: "Cost of Attendance", desc: "Tuition fees, payment schedule, financial aid details", url: "/pages/finance/cost_of_attendance.php", icon: "fa-coins", category: "Navigation Menu" },
    { title: "Student Affairs", desc: "Student council, clubs, campus regulations", url: "/pages/campus_life/student_affairs.php", icon: "fa-users", category: "Navigation Menu" },
    { title: "External Activities", desc: "International programs, exchange, internship opportunities", url: "/pages/campus_life/external_activities.php", icon: "fa-globe", category: "Navigation Menu" },
    { title: "Student Exchange Program", desc: "Handong, INTI, De La Salle university partner exchange", url: "/pages/external_programs/exchange_program.php", icon: "fa-plane", category: "Navigation Menu" },
    { title: "Student Internship Program", desc: "Industry placement guidelines, MBKM, career center", url: "/pages/external_programs/internship.php", icon: "fa-briefcase", category: "Navigation Menu" },
    { title: "Student Service Scholarship", desc: "Work-study scholarship application and SSS guidelines", url: "/pages/external_programs/scholarship.php", icon: "fa-award", category: "Navigation Menu" },
    { title: "Student Services Helpdesk", desc: "IT support, campus facility complaints, lost & found", url: "/pages/services/student_services.php", icon: "fa-headset", category: "Navigation Menu" },
    { title: "Library Services", desc: "Book catalog search, borrowing rules, e-journal access", url: "/pages/services/library.php", icon: "fa-book-open", category: "Navigation Menu" },
    { title: "Campus Forms", desc: "Leave of absence form, add/drop form, club request form", url: "/pages/services/forms.php", icon: "fa-file-lines", category: "Navigation Menu" },
    { title: "Dormitory & Housing", desc: "Dorm rules, room assignment, curfew policy", url: "/pages/services/dormitory.php", icon: "fa-bed", category: "Navigation Menu" },
    { title: "Student Counseling", desc: "Mental health support, academic advisor appointment", url: "/pages/services/counseling.php", icon: "fa-heart-pulse", category: "Navigation Menu" },
    { title: "Feedback & Report", desc: "Anonymous campus report, QR scan feedback form", url: "/pages/services/feedback.php", icon: "fa-comment-dots", category: "Navigation Menu" },
    { title: "Portal Settings", desc: "Change password, theme preference, profile avatar", url: "/pages/settings/settings.php", icon: "fa-gear", category: "Navigation Menu" },
    
    // PDF Documents
    { title: "Academic Calendar 2025-2026 (PDF)", desc: "Download official PDF calendar document", url: "/assets/documents/Academic%20Calendar%20TA%202025-2026.pdf", icon: "fa-file-pdf", category: "Documents & Files", isDoc: true },
    { title: "Student Service Scholarship Guideline 2025", desc: "Work study official rules PDF", url: "/assets/documents/sss/JIU%20Student%20Service%20Scholarship%20(Work%20Study)%20Guideline%202025.pdf", icon: "fa-file-pdf", category: "Documents & Files", isDoc: true }
];

let selectedIndex = 0;
let currentResults = [];

function openSpotlight() {
    const modal = document.getElementById('spotlightModal');
    const input = document.getElementById('spotlightInput');
    modal.classList.add('active');
    input.value = '';
    filterSpotlight();
    setTimeout(() => input.focus(), 50);
}

function closeSpotlight() {
    document.getElementById('spotlightModal').classList.remove('active');
}

function closeSpotlightOutside(e) {
    if (e.target.id === 'spotlightModal') {
        closeSpotlight();
    }
}

document.addEventListener('keydown', function(e) {
    if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') {
        e.preventDefault();
        const modal = document.getElementById('spotlightModal');
        if (modal.classList.contains('active')) {
            closeSpotlight();
        } else {
            openSpotlight();
        }
    }
    if (e.key === 'Escape') {
        closeSpotlight();
    }
    
    const modal = document.getElementById('spotlightModal');
    if (modal.classList.contains('active') && currentResults.length > 0) {
        if (e.key === 'ArrowDown') {
            e.preventDefault();
            selectedIndex = (selectedIndex + 1) % currentResults.length;
            renderSpotlightResults();
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            selectedIndex = (selectedIndex - 1 + currentResults.length) % currentResults.length;
            renderSpotlightResults();
        } else if (e.key === 'Enter') {
            e.preventDefault();
            const target = currentResults[selectedIndex];
            if (target) {
                window.location.href = target.url;
            }
        }
    }
});

function filterSpotlight() {
    const query = document.getElementById('spotlightInput').value.toLowerCase().trim();
    if (!query) {
        currentResults = [...SEARCH_INDEX];
    } else {
        currentResults = SEARCH_INDEX.filter(item => 
            item.title.toLowerCase().includes(query) || 
            item.desc.toLowerCase().includes(query) ||
            item.category.toLowerCase().includes(query)
        );
    }
    selectedIndex = 0;
    renderSpotlightResults();
}

function renderSpotlightResults() {
    const container = document.getElementById('spotlightResults');
    if (currentResults.length === 0) {
        container.innerHTML = `
            <div class="spotlight-empty">
                <i class="fas fa-search"></i>
                <p>No menus or documents found for your search.</p>
            </div>
        `;
        return;
    }

    const categories = {};
    currentResults.forEach((item, index) => {
        if (!categories[item.category]) categories[item.category] = [];
        categories[item.category].push({ ...item, globalIndex: index });
    });

    let html = '';
    for (const [cat, items] of Object.entries(categories)) {
        html += `<div class="spotlight-section-title">${cat}</div>`;
        items.forEach(item => {
            const isSel = item.globalIndex === selectedIndex ? 'selected' : '';
            const docClass = item.isDoc ? 'doc' : '';
            const actionText = item.isDoc ? '<i class="fas fa-download"></i> PDF' : '→';
            html += `
                <a href="${item.url}" class="spotlight-item ${isSel} ${docClass}" onmouseenter="selectedIndex = ${item.globalIndex}; renderSpotlightResults();">
                    <div class="spotlight-item-icon"><i class="fas ${item.icon}"></i></div>
                    <div class="spotlight-item-text">
                        <div class="spotlight-item-title">${item.title}</div>
                        <div class="spotlight-item-desc">${item.desc}</div>
                    </div>
                    <div class="spotlight-item-action">${actionText}</div>
                </a>
            `;
        });
    }

    container.innerHTML = html;
    
    // Auto scroll selected into view
    const selEl = container.querySelector('.spotlight-item.selected');
    if (selEl) {
        selEl.scrollIntoView({ block: 'nearest' });
    }
}
</script>
