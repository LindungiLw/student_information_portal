<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/koneksi.php';

// Validasi apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: /index.php");
    exit;
}

// Ambil upcoming events dari database (maksimal 2 acara yang belum lewat)
$stmt = $pdo->query("SELECT * FROM academic_calendar WHERE start_date >= CURDATE() ORDER BY start_date ASC LIMIT 2");
$upcoming_events = $stmt->fetchAll();

// Pastikan selalu ada pas 2 upcoming event agar kotak kalender terisi sempurna 2 acara
if (count($upcoming_events) < 2) {
    $upcoming_events[] = [
        'start_date' => date('Y-m-d', strtotime('+6 days')),
        'event_title' => 'Midterm Examination Period',
        'category' => 'Exam',
        'event_color' => '#f59e0b'
    ];
}
if (count($upcoming_events) < 2) {
    $upcoming_events[] = [
        'start_date' => date('Y-m-d', strtotime('+12 days')),
        'event_title' => 'JIU Cultural & Arts Festival',
        'category' => 'Festival',
        'event_color' => '#10b981'
    ];
}

// Pastikan tabel announcements tersedia untuk input berita dari admin
$latest_announcements = [];
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS announcements (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        content TEXT NOT NULL,
        author VARCHAR(100) DEFAULT 'Admin Panel',
        created_at DATE DEFAULT (CURDATE())
    )");
    
    $stmt_ann = $pdo->query("SELECT * FROM announcements ORDER BY id DESC LIMIT 2");
    if ($stmt_ann) {
        $latest_announcements = $stmt_ann->fetchAll();
    }
} catch (Exception $e) {
    // Abaikan jika gagal query
}

// No static fallbacks. The empty state is handled dynamically in the UI.

// Fetch dynamic dashboard booklet
$dash_booklet_path = '';
$dash_booklet_title = 'JIU Admission Booklet';
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS dashboard_documents (
      id int(11) NOT NULL AUTO_INCREMENT,
      title varchar(255) NOT NULL,
      file_path varchar(255) DEFAULT NULL,
      uploaded_at timestamp DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    
    $stmt_doc = $pdo->query("SELECT file_path, title FROM dashboard_documents ORDER BY id DESC LIMIT 1");
    if ($stmt_doc) {
        $latest_doc = $stmt_doc->fetch();
        if ($latest_doc && !empty($latest_doc['file_path']) && file_exists($_SERVER['DOCUMENT_ROOT'] . $latest_doc['file_path'])) {
            $dash_booklet_path = $latest_doc['file_path'];
            $dash_booklet_title = $latest_doc['title'];
        }
    }
} catch (Exception $e) {
    // Fallback to default
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard | JIU Student Portal</title>
  <link rel="icon" type="image/png" href="/assets/images/jiu-logo-rounded.png">
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="/assets/css/dashboard.css?v=35">
  <link rel="stylesheet" href="/assets/css/sidebar.css?v=35">
  <link rel="stylesheet" href="/assets/css/variables.css">
  <link rel="stylesheet" href="/assets/css/base.css">
  <link rel="stylesheet" href="/assets/css/responsive.css?v=35">
</head>
<body class="dashboard-app-viewport">
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/svg_icons.php'; ?>

  <!-- ── SIDEBAR ── -->
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/sidebar.php'; ?>

  <!-- ── MAIN CONTENT ── -->
  <main class="main">

    <!-- Compact Welcome Hero Banner & Intro Text grouped in Header -->
    <div class="hero-wrapper">
      <div class="hero compact-hero">
        <div class="hero-content">
          <h1>Welcome back, <?php $parts = explode(' ', $_SESSION['name'] ?? 'Student'); echo htmlspecialchars($parts[0]); ?>! 👋</h1>
          <p>Access your academic life, simplified.</p>
        </div>
      </div>
      <div class="intro-text">
        Welcome to the Student Information Portal. This is your central hub for essential school resources. Use this site
        to access your <strong>curriculum</strong>, academic policies, and dormitory regulations, or to explore our
        diverse academic programs.
      </div>
    </div>

    <!-- ── 50% / 50% BALANCED MASTER DASHBOARD GRID ── -->
    <div class="dashboard-split-grid">
        
        <!-- LEFT COLUMN: Pure Cover Card Only (Title & icon removed as requested) -->
        <div class="dash-left-col">
           <?php if (!empty($dash_booklet_path)): ?>
           <div class="booklet-pure-card" onclick="expandPdf()" title="Click to open Booklet Popup">
               <!-- Clip wrapper pushing native browser PDF scrollbars off-screen -->
               <div class="pdf-clip-wrapper">
                   <iframe id="dash-pdf-viewer" src="<?php echo htmlspecialchars($dash_booklet_path); ?>#toolbar=0&navpanes=0&scrollbar=0&view=Fit" scrolling="no" tabindex="-1" title="<?php echo htmlspecialchars($dash_booklet_title); ?>"></iframe>
               </div>

               <!-- Gorgeous Modern Interactive Hover Shield with Animated Hand -->
               <div class="pure-card-interactive-shield">
                   <div class="hover-hand-indicator">
                       <div class="hand-icon-ring">
                           <i class="fas fa-hand-pointer"></i>
                       </div>
                       <span class="hover-action-text">Click to Open</span>
                       <span class="hover-sub-text">Interactive Popup</span>
                   </div>
               </div>
           </div>
           <?php else: ?>
           <div class="booklet-pure-card" style="display: flex; flex-direction: column; justify-content: center; align-items: center; background: #f8fafc; border: 2px dashed #cbd5e1; cursor: default;">
               <div style="font-size: 48px; color: #94a3b8; margin-bottom: 16px;"><i class="fas fa-file-pdf"></i></div>
               <div style="font-size: 16px; font-weight: 700; color: var(--text-main); margin-bottom: 8px;">No Document Available</div>
               <div style="font-size: 13px; color: var(--text-muted); text-align: center; max-width: 80%;">The administration has not uploaded a booklet yet.</div>
           </div>
           <?php endif; ?>
        </div>

        <!-- RIGHT COLUMN (50%): Top Row (Quick Links | Upcoming Calendar max 2) + Bottom Row (Full Width Announcements) -->
        <div class="dash-right-col" style="display: flex; flex-direction: column; gap: 20px;">
          
          <!-- TOP ROW: 2-Column Grid (Quick Links Left | Upcoming Right) -->
          <div class="right-top-grid" style="display: grid; grid-template-columns: minmax(180px, 1fr) minmax(200px, 1fr); gap: 20px; align-items: start;">
             
             <!-- LEFT COL: Quick Links -->
             <div class="sidebar-widget">
                 <div class="widget-header">
                     <div class="widget-title"><i class="fas fa-bolt" style="color: #f59e0b;"></i> Quick Links</div>
                 </div>
                 <div class="widget-card widget-card-ql">
                   <div class="ql-grid-2x2">
                      <a href="https://jiu.ac" target="_blank" class="ql-tile">
                        <img src="/assets/images/jiulogo.png" alt="JIU" class="ql-tile-img">
                        <span>JIU Website</span>
                      </a>
                      <a href="https://jiu.ac/campus/notice-board/" target="_blank" class="ql-tile">
                        <div class="ql-tile-icon" style="background: rgba(16, 185, 129, 0.12); color: #10b981;"><i class="fas fa-bullhorn"></i></div>
                        <span>Notice Board</span>
                      </a>
                      <a href="https://jiu.ac/portal/" target="_blank" class="ql-tile">
                        <img src="/assets/images/siakad logo.png" alt="SIAKAD" class="ql-tile-img">
                        <span>SIAKAD</span>
                      </a>
                      <a href="http://jiulibrary.ac" target="_blank" class="ql-tile">
                        <img src="/assets/images/logo-jiulibrary.png" alt="Library" class="ql-tile-img">
                        <span>JIU Library</span>
                      </a>
                   </div>
                 </div>
             </div>

             <!-- RIGHT COL: Upcoming Calendar max 2 -->
             <div class="sidebar-widget">
                 <div class="widget-header">
                     <a href="/pages/academics/calendar.php" class="widget-title" title="View Full Academic Calendar" style="text-decoration: none; cursor: pointer; color: inherit; transition: color 0.2s;" onmouseover="this.style.color='#6366f1';" onmouseout="this.style.color='inherit';">
                         <i class="fas fa-calendar-alt" style="color: #6366f1;"></i> Upcoming <i class="fas fa-arrow-up-right-from-square" style="font-size: 11px; color: #94a3b8; margin-left: 4px;"></i>
                     </a>
                 </div>
                 <div class="widget-card widget-card-up">
                   <?php 
                      $limited_upcoming = array_slice($upcoming_events ?? [], 0, 2);
                      if (empty($limited_upcoming)): 
                   ?>
                      <div class="empty-widget">
                          <i class="fas fa-calendar-check"></i>
                          <p>No upcoming events.</p>
                      </div>
                   <?php else: ?>
                       <?php foreach ($limited_upcoming as $index => $event): 
                           $date = new DateTime($event['start_date']);
                           $month = strtoupper($date->format('M'));
                           $day = $date->format('d');
                       ?>
                       <div class="up-event-item">
                         <div class="up-event-date">
                           <span class="up-m"><?php echo $month; ?></span>
                           <span class="up-d"><?php echo $day; ?></span>
                         </div>
                         <div class="up-event-info">
                           <div class="up-name"><?php echo htmlspecialchars($event['event_title']); ?></div>
                           <div class="up-cat"><span class="cat-dot" style="background: <?php echo htmlspecialchars($event['event_color'] ?? '#6b6fa0'); ?>;"></span> <?php echo htmlspecialchars($event['category']); ?></div>
                         </div>
                       </div>
                       <?php if ($index < count($limited_upcoming) - 1): ?>
                          <div class="widget-divider"></div>
                       <?php endif; ?>
                       <?php endforeach; ?>
                   <?php endif; ?>
                 </div>
             </div>

          </div>

          <!-- BOTTOM ROW: Full-Width Announcements dynamic news feed -->
          <div class="sidebar-widget">
               <div class="widget-header">
                   <div class="widget-title"><i class="fas fa-bullhorn" style="color: #ef4444;"></i> Announcements & News</div>
               </div>
               <div class="widget-card widget-card-ann" style="display: flex; flex-direction: column; gap: 10px; overflow-y: auto; flex: 1; padding: 14px 18px; justify-content: space-around;">
                 <?php if(empty($latest_announcements)): ?>
                     <div style="display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; height: 100%; color: #94a3b8; padding: 20px 0;">
                         <i class="fas fa-bullhorn" style="font-size: 32px; margin-bottom: 12px; color: #cbd5e1;"></i>
                         <div style="font-size: 14px; font-weight: 700; color: var(--text-main);">No announcements yet</div>
                         <div style="font-size: 12.5px; margin-top: 4px;">Check back later for updates.</div>
                     </div>
                 <?php else: ?>
                   <?php foreach ($latest_announcements as $idx => $ann): 
                       $ann_date = date('M d', strtotime($ann['created_at'] ?? 'now'));
                   ?>
                   <div class="ann-item" style="border-left: 3px solid #3b82f6; padding-left: 10px;">
                     <div class="ann-title" style="font-weight: 700; color: #1e293b; font-size: 13.5px; margin-bottom: 2px;"><?php echo htmlspecialchars($ann['title']); ?></div>
                     <div class="ann-body" style="color: #475569; font-size: 12.5px; line-height: 1.45; margin-bottom: 4px;"><?php echo nl2br(htmlspecialchars($ann['content'])); ?></div>
                     <div class="ann-meta" style="font-size: 11px; color: #94a3b8; font-weight: 600;">
                       <i class="far fa-calendar-alt"></i> <?php echo $ann_date; ?> 
                       <span style="margin: 0 4px;">•</span> 
                       <i class="far fa-user"></i> <?php echo htmlspecialchars($ann['author'] ?? 'Admin'); ?>
                     </div>
                   </div>
                   <?php if ($idx < count($latest_announcements) - 1): ?>
                   <div style="height: 1px; background: rgba(148, 163, 184, 0.2); margin: 2px 0;"></div>
                   <?php endif; ?>
                   <?php endforeach; ?>
                 <?php endif; ?>
               </div>
          </div>

        </div>

    </div>
  </main>
  
  <!-- Pure 100% Clean PDF Lightbox Popup (No Header Bar) -->
  <div id="booklet-popup-modal" class="booklet-modal-backdrop" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.88); backdrop-filter: blur(12px); z-index: 999999; align-items: center; justify-content: center; padding: 20px;" onclick="closeBookletModal()">
      <!-- Minimalist Elegant Floating Glass Close Button -->
      <button type="button" onclick="closeBookletModal()" title="Close Popup (Esc)" style="position: absolute; top: 24px; right: 24px; width: 48px; height: 48px; border-radius: 50%; background: rgba(255, 255, 255, 0.18); color: #ffffff; border: 1px solid rgba(255, 255, 255, 0.35); backdrop-filter: blur(10px); cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 20px; z-index: 1000000; box-shadow: 0 10px 25px rgba(0,0,0,0.4); transition: transform 0.25s, background 0.25s;" onmouseover="this.style.background='rgba(239, 68, 68, 0.9)'; this.style.transform='scale(1.1) rotate(90deg)';" onmouseout="this.style.background='rgba(255, 255, 255, 0.18)'; this.style.transform='scale(1) rotate(0deg)';">
          <i class="fas fa-times"></i>
      </button>

      <!-- Pure PDF Frame Container Only -->
      <div class="pure-pdf-popup-box" onclick="event.stopPropagation()" style="width: min(920px, 94vw); height: min(90vh, 1200px); background: #ffffff; border-radius: 20px; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.75); position: relative; border: 1px solid rgba(255, 255, 255, 0.22); animation: scaleUpModal 0.32s cubic-bezier(0.16, 1, 0.3, 1);">
          <iframe id="bm-iframe" src="" style="border: none; width: 100%; height: 100%; display: block; background: #ffffff;"></iframe>
      </div>
  </div>

  <script src="/assets/js/main.js"></script>
  <script>
  function expandPdf() {
      <?php if (empty($dash_booklet_path)): ?>
      return; // Do nothing if no PDF
      <?php endif; ?>
      
      const modal = document.getElementById('booklet-popup-modal');
      const iframe = document.getElementById('bm-iframe');
      if (!modal || !iframe) return;
      
      if (!iframe.src || iframe.src === window.location.href) {
          // #toolbar=0 menyembunyikan ikon print/download kaku Chrome. #scrollbar=0 membuat scroll halus mulus alami.
          iframe.src = "<?php echo addslashes($dash_booklet_path); ?>#toolbar=0&navpanes=0&scrollbar=0&view=FitH";
      }
      modal.style.display = 'flex';
  }
  function closeBookletModal() {
      const modal = document.getElementById('booklet-popup-modal');
      if (modal) modal.style.display = 'none';
  }
  document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') closeBookletModal();
  });
  </script>
</body>
</html>
