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

<div class="mobile-header">
    <div class="mobile-logo-group">
        <img src="/assets/images/jiu-logo-rounded.png" alt="JIU Logo" class="mobile-logo">
        <span class="mobile-brand-name"><strong>Student Portal</strong></span>
    </div>
    <button id="mobileMenuBtn" class="mobile-menu-btn">
        <i class="fas fa-bars"></i>
    </button>
</div>
<div id="sidebarOverlay" class="sidebar-overlay"></div>

<aside id="sidebar" class="sidebar">
    <div class="sidebar-brand">
        <img src="/assets/images/jiu-logo-rounded.png" alt="JIU Logo" class="brand-logo">
        <span class="brand-name"><Strong>Student Portal</Strong></span>
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
