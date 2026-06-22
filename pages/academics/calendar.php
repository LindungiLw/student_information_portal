<?php
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: /index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Calendar | JIU Student Portal</title>
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
    <div class="bottom-dashboard-section" style="padding-top: 20px;">
       <div class="section-header">
          <div class="section-title"><svg class="custom-icon"><use href="#icon-calendar"></use></svg> Academic Calendar TA 2025-2026</div>
       </div>
       <div class="custom-pdf-container">
           <!-- Custom Premium Header -->
           <div class="pdf-header">
               <div class="pdf-title">
                   <svg class="custom-icon" style="color: #e53e3e;"><use href="#icon-calendar"></use></svg> 
                   Official Academic Calendar
               </div>
               <div class="pdf-actions">
                   <a href="/assets/documents/Academic%20Calendar%20TA%202025-2026.pdf" download class="btn-download">
                       <svg class="custom-icon" style="width: 16px; height: 16px;"><use href="#icon-download"></use></svg> Download
                   </a>
                   <button class="btn-fullscreen" onclick="document.getElementById('cal-pdf').requestFullscreen()">
                       <svg class="custom-icon" style="width: 16px; height: 16px;"><use href="#icon-expand"></use></svg> Fullscreen
                   </button>
               </div>
           </div>
           
           <!-- Iframe (Tanpa native toolbar) -->
           <div class="pdf-body" style="height: 800px;">
               <iframe id="cal-pdf" src="/assets/documents/Academic%20Calendar%20TA%202025-2026.pdf#toolbar=0&navpanes=0&view=FitH" width="100%" height="100%" style="border: none;">
                    <div style="padding: 2rem; text-align: center;">
                        <svg class="custom-icon" style="width: 48px; height: 48px; color: #ccc; margin-bottom: 1rem;"><use href="#icon-calendar"></use></svg>
                        <p>Your browser does not support PDF iframes.<br><a href="/assets/documents/Academic%20Calendar%20TA%202025-2026.pdf" target="_blank">Download Academic Calendar here</a></p>
                    </div>
               </iframe>
           </div>
       </div>
    </div>
  </main>

  <script src="/assets/js/main.js"></script>
</body>
</html>
