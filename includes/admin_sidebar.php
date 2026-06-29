<?php
// Dapatkan nama file saat ini untuk menentukan status 'active' pada menu sidebar
$current_page = basename($_SERVER['PHP_SELF']);

// Fungsi bantuan untuk menandai menu aktif
function is_active($page, $current_page) {
    return ($page == $current_page) ? 'active' : '';
}

// Ambil data sesi
$user_name = isset($_SESSION['name']) ? $_SESSION['name'] : 'Admin User';
$user_id = 'Role: Administrator';

// Buat inisial avatar
$words = explode(" ", $user_name);
$initials = "";
foreach ($words as $w) {
  $initials .= mb_substr($w, 0, 1);
}
$avatar_text = strtoupper(mb_substr($initials, 0, 2));
?>

<div class="mobile-header" style="background: rgba(255, 255, 255, 0.96); backdrop-filter: blur(12px); border-bottom: 1px solid rgba(124, 58, 237, 0.18); box-shadow: 0 4px 20px rgba(107, 33, 168, 0.08); padding: 10px 14px; width: 100%; box-sizing: border-box; justify-content: space-between; overflow: hidden; position: sticky; top: 0; z-index: 999;">
    <div class="mobile-logo-group" style="display: flex; align-items: center; gap: 8px; flex: 1; min-width: 0; margin-right: 8px; overflow: hidden;">
        <div style="width: 36px; height: 36px; background: linear-gradient(135deg, #ef4444 0%, #7c3aed 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center; box-shadow: 0 3px 8px rgba(239, 68, 68, 0.4); flex-shrink: 0;">
            <i class="fas fa-shield-alt" style="color: #ffffff; font-size: 18px;"></i>
        </div>
        <span class="mobile-brand-name" style="font-size: 16px; font-weight: 800; background: linear-gradient(135deg, #1e1b4b 0%, #6b21a8 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; letter-spacing: -0.3px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">PORTAL ADMIN</span>
    </div>
    <div style="display: flex; align-items: center; gap: 8px; flex-shrink: 0;">
        <button id="mobileMenuBtn" class="mobile-menu-btn" style="background: #7c3aed; color: #ffffff; border: none; width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 16px; box-shadow: 0 3px 8px rgba(124, 58, 237, 0.3);">
            <i class="fas fa-bars"></i>
        </button>
    </div>
</div>
<div id="sidebarOverlay" class="sidebar-overlay"></div>

<aside id="sidebar" class="sidebar">
    <div class="sidebar-brand">
        <i class="fas fa-shield-alt" style="color: white; font-size: 24px;"></i>
        <span class="brand-name" style="margin-left: 8px;"><Strong>PORTAL ADMIN</Strong></span>
    </div>

    <!-- Wrapper yang bisa di-scroll tapi scrollbar-nya tidak terlihat -->
    <div class="sidebar-nav-wrapper">
        <nav class="sidebar-nav">
            <div class="nav-section-label">Main System</div>
            <a href="/admin/dashboard.php" class="nav-item <?php echo is_active('dashboard.php', $current_page); ?>">
                <i class="fas fa-tachometer-alt"></i> Dashboard Content
            </a>

            <div class="nav-section-label">Academics (Uploads)</div>
            <a href="/admin/calendar_manage.php" class="nav-item <?php echo is_active('calendar_manage.php', $current_page); ?>">
                <i class="fas fa-calendar-alt"></i> Academic Calendar
            </a>
            <a href="/admin/academics_docs_manage.php" class="nav-item <?php echo is_active('academics_docs_manage.php', $current_page); ?>">
                <i class="fas fa-graduation-cap"></i> Academics Guidelines
            </a>
            <a href="/admin/department_docs_manage.php" class="nav-item <?php echo is_active('department_docs_manage.php', $current_page); ?>">
                <i class="fas fa-building-columns"></i> Department Docs
            </a>


            <div class="nav-section-label">Finance</div>
            <a href="/admin/finance_docs_manage.php" class="nav-item <?php echo is_active('finance_docs_manage.php', $current_page); ?>">
                <i class="fas fa-coins"></i> Cost of Attendance
            </a>

            <!-- Sub: Campus Life -->
            <div style="font-size: 11px; text-transform: uppercase; color: rgba(255,255,255,0.4); margin: 10px 16px 4px 16px; letter-spacing: 0.5px; font-weight: 700;">Campus Life</div>
            <a href="/admin/student_affairs_docs_manage.php" class="nav-item <?php echo is_active('student_affairs_docs_manage.php', $current_page); ?>">
                <i class="fas fa-users"></i> Student Affairs
            </a>
            <a href="/admin/external_activities_docs_manage.php" class="nav-item <?php echo is_active('external_activities_docs_manage.php', $current_page); ?>">
                <i class="fas fa-globe"></i> External Activities
            </a>
            <a href="/admin/student_services_docs_manage.php" class="nav-item <?php echo is_active('student_services_docs_manage.php', $current_page); ?>">
                <i class="fas fa-headset"></i> Student Services
            </a>
            
            <div class="nav-section-label">Student View</div>
            <a href="/dashboard.php" class="nav-item" style="color: #6ee7b7;">
                <i class="fas fa-external-link-alt"></i> Open Student Portal
            </a>
        </nav>
    </div>

    <div class="sidebar-bottom">
        <a href="/auth/logout.php" class="sidebar-settings" style="color: #ef4444; margin-bottom: 15px;">
            <i class="fas fa-right-from-bracket"></i> Logout
        </a>
        <div class="sidebar-user">
            <div class="user-avatar" style="background: #eab308;"><?php echo htmlspecialchars($avatar_text); ?></div>
            <div class="user-info">
                <div class="user-name"><?php echo htmlspecialchars($user_name); ?></div>
                <div class="user-id" style="color: #fbbf24;"><?php echo htmlspecialchars($user_id); ?></div>
            </div>
        </div>
    </div>
</aside>




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
        position: relative !important;
        top: auto !important;
        padding: 14px 16px !important;
        margin-bottom: 18px !important;
        border-radius: 12px !important;
        width: 100% !important;
        box-sizing: border-box !important;
    }
    .page-header h1 {
        font-size: 18px !important;
        gap: 8px !important;
    }
    .page-header p {
        font-size: 13px !important;
    }
}
</style>
