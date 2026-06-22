<?php
session_start();

// Validasi apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: /index.php");
    exit;
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
  <link rel="stylesheet" href="/assets/css/dashboard.css">
  <link rel="stylesheet" href="/assets/css/sidebar.css">
  <link rel="stylesheet" href="/assets/css/variables.css">
  <link rel="stylesheet" href="/assets/css/base.css">
</head>
<body>
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/svg_icons.php'; ?>

  <!-- ── SIDEBAR ── -->
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/sidebar.php'; ?>

  <!-- ── MAIN CONTENT ── -->
  <main class="main">

    <div class="hero-wrapper">
      <div class="hero" style="background-image: url('/assets/images/image.png'); background-size: cover; background-position: center;">
        <div class="hero-overlay"></div>
        <div class="hero-content">
          <h1>Welcome back, <?php $parts = explode(' ', $_SESSION['name']); echo htmlspecialchars($parts[0]); ?>!</h1>
          <p>-Access Your academic life, simplified.</p>
        </div>
      </div>
    </div>

    <div class="intro-text">
      Welcome to the Student Information Portal. This is your central hub for essential school resources. Use this site
      to access your <strong>curriculum</strong>, academic policies, and dormitory regulations, or to explore our
      diverse academic programs.
    </div>

    <!-- Grid Atas: Links & Announcements -->
    <div class="content-grid" style="margin-bottom: 40px;">
        
        <!-- Kiri: Quick Links & Recent Announcements -->
        <div class="main-top-left">
           <div class="section-header">
             <div class="section-title"><svg class="custom-icon"><use href="#icon-link"></use></svg> Quick Links</div>
           </div>
           <div class="quick-links-grid" style="margin-bottom: 30px;">
              <a href="https://jiu.ac" target="_blank" class="quick-link-item">
                <img src="/assets/images/jiu-logo-rounded.png" alt="JIU" style="height: 28px; width: auto; object-fit: contain;">
                <span>JIU Website</span>
              </a>
              <a href="https://jiu.ac/campus/notice-board/" target="_blank" class="quick-link-item">
                <svg class="custom-icon"><use href="#icon-bullhorn"></use></svg><span>Notice Board</span>
              </a>
              <a href="https://jiu.ac/portal/" target="_blank" class="quick-link-item">
                <img src="/assets/images/siakad logo.png" alt="SIAKAD" style="height: 28px; width: auto; object-fit: contain;">
                <span>SIAKAD</span>
              </a>
              <a href="http://jiulibrary.ac" target="_blank" class="quick-link-item">
                <img src="/assets/images/logo-jiulibrary.png" alt="Library" style="height: 28px; width: auto; object-fit: contain;">
                <span>Dream Blue Library</span>
              </a>
           </div>

           <div class="section-header">
             <div class="section-title"><svg class="custom-icon"><use href="#icon-bullhorn"></use></svg> Recent Announcements</div>
             <a href="#" class="view-all">View All</a>
           </div>
           <div class="card">
             <div class="announcement-item">
               <div class="announcement-title">Welcome to the New Academic Year</div>
               <div class="announcement-body">Welcome to the Student Information Portal. Make sure to explore our academic resources.</div>
               <div class="announcement-meta">Sep 01 <span class="meta-dot">•</span> Administration</div>
             </div>
           </div>
        </div>

        <!-- Kanan: Upcoming Events -->
        <div class="main-top-right">
           <div class="section-header">
             <div class="section-title"><svg class="custom-icon"><use href="#icon-calendar"></use></svg> Upcoming</div>
           </div>
           <div class="card upcoming-card">
             <div class="event-item">
               <div class="event-date">
                 <span class="event-month">MAR</span>
                 <span class="event-day">25</span>
               </div>
               <div class="event-info">
                 <div class="event-name">Career Fair</div>
                 <div class="event-loc">10:00 AM • Student Center</div>
               </div>
             </div>
             <div class="divider"></div>
             <div class="event-item">
               <div class="event-date">
                 <span class="event-month">MAR</span>
                 <span class="event-day">31</span>
               </div>
               <div class="event-info">
                 <div class="event-name">Halloween Mixer</div>
                 <div class="event-loc">07:00 PM • Main Quad</div>
               </div>
             </div>
           </div>
        </div>
    </div>

    <!-- Bawah: JIU Vision & Mission Full Width -->
    <div class="bottom-dashboard-section">
       <div class="section-header">
          <div class="section-title"><svg class="custom-icon"><use href="#icon-book"></use></svg> About JIU (Overview & Programs)</div>
       </div>
       <div class="custom-pdf-container">
           <!-- Custom Premium Header -->
           <div class="pdf-header">
               <div class="pdf-title">
                   <svg class="custom-icon" style="color: #e53e3e;"><use href="#icon-book"></use></svg> 
                   JIU Admission Booklet (Interactive)
               </div>
               <div class="pdf-actions">
                   <a href="/assets/documents/JIU-Admission-Booklet-English-Version.pdf" download class="btn-download">
                       <svg class="custom-icon" style="width: 16px; height: 16px;"><use href="#icon-download"></use></svg> Download
                   </a>
                   <button class="btn-fullscreen" onclick="document.getElementById('jiu-pdf').requestFullscreen()">
                       <svg class="custom-icon" style="width: 16px; height: 16px;"><use href="#icon-expand"></use></svg> Fullscreen
                   </button>
               </div>
           </div>
           
           <!-- Iframe (Disembunyikan Native Toolbar-nya) -->
           <div class="pdf-body">
               <iframe id="jiu-pdf" src="/assets/documents/JIU-Admission-Booklet-English-Version.pdf#toolbar=0&navpanes=0&view=FitH" width="100%" height="100%" style="border: none;">
                    <div style="padding: 2rem; text-align: center;">
                        <i class="fas fa-file-pdf" style="font-size: 3rem; color: #ccc; margin-bottom: 1rem;"></i>
                        <p>Browser Anda tidak mendukung iframe PDF.<br><a href="/assets/documents/JIU-Admission-Booklet-English-Version.pdf" target="_blank">Download Booklet JIU di sini</a></p>
                    </div>
               </iframe>
           </div>
       </div>
    </div>
  </main>
</body>
</html>
