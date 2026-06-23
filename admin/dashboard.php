<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Akses Ditolak! Anda bukan admin.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard | JIU Portal</title>
  <link rel="icon" type="image/png" href="/assets/images/jiu-logo-rounded.png">
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="/assets/css/variables.css">
  <link rel="stylesheet" href="/assets/css/base.css">
  <link rel="stylesheet" href="/assets/css/dashboard.css">
  <link rel="stylesheet" href="/assets/css/sidebar.css">
</head>
<body>
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/svg_icons.php'; ?>
  
  <!-- Admin Sidebar -->
  <aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
      <div class="logo">
        <i class="fas fa-shield-alt"></i> JIU ADMIN
      </div>
      <button class="menu-toggle" id="menuToggle" aria-label="Toggle Menu">
        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
      </button>
    </div>

    <nav class="sidebar-nav">
      <ul class="nav-list">
        <li class="nav-item">
          <a href="/admin/dashboard.php" class="nav-link active">
            <i class="fas fa-tachometer-alt"></i> <span>Overview</span>
          </a>
        </li>
        <li class="nav-item">
          <a href="/admin/calendar_manage.php" class="nav-link">
            <i class="fas fa-calendar-alt"></i> <span>Academic Calendar</span>
          </a>
        </li>
      </ul>
    </nav>
    <div class="sidebar-footer">
      <a href="/auth/logout.php" class="logout-btn">
        <i class="fas fa-sign-out-alt"></i> <span>Log Out</span>
      </a>
    </div>
  </aside>

  <main class="main">
    <header class="header">
        <div class="user-profile">
            <div class="avatar"><i class="fas fa-user-shield" style="color: white; font-size: 20px;"></i></div>
            <div class="user-info">
                <span class="user-name"><?php echo htmlspecialchars($_SESSION['name']); ?></span>
                <span class="user-role">Administrator</span>
            </div>
        </div>
    </header>

    <div class="bottom-dashboard-section" style="padding-top: 20px;">
       <div class="section-header" style="flex-direction: column; align-items: flex-start; gap: 8px; border-bottom: none; margin-bottom: 0;">
          <div class="section-title" style="font-size: 28px;">
             <i class="fas fa-tachometer-alt" style="color: var(--purple-accent); margin-right: 12px;"></i> Admin Dashboard
          </div>
          <p style="color: var(--text-muted); font-size: 15px; margin: 0;">Welcome to the administration panel. Please select a module from the sidebar.</p>
       </div>

       <div style="margin-top: 30px; display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 24px;">
           <a href="/admin/calendar_manage.php" style="background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 12px; padding: 24px; text-decoration: none; color: var(--text-main); display: flex; align-items: center; gap: 16px; transition: transform 0.2s; box-shadow: var(--shadow-sm);">
               <div style="width: 50px; height: 50px; background: rgba(107, 33, 168, 0.1); color: var(--purple-accent); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 24px;">
                   <i class="fas fa-calendar-alt"></i>
               </div>
               <div>
                   <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 4px;">Manage Calendar</h3>
                   <p style="font-size: 13px; color: var(--text-muted); margin: 0;">Update academic schedule</p>
               </div>
           </a>
       </div>
    </div>
  </main>
  <script src="/assets/js/main.js"></script>
</body>
</html>
