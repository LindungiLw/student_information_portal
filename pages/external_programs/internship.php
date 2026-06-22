<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /index.php');
    exit;
}
$current_page = 'external_activities.php'; // Keep sidebar active on External Activities
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Internship | JIU Student Portal</title>
  <link rel="icon" type="image/png" href="/assets/images/jiu-logo-rounded.png">
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="/assets/css/dashboard.css">
  <link rel="stylesheet" href="/assets/css/sidebar.css">
  <link rel="stylesheet" href="/assets/css/variables.css">
  <link rel="stylesheet" href="/assets/css/base.css">
  <style>
      .exchange-hero {
          display: flex;
          align-items: flex-start;
          gap: 40px;
          background: #fff;
          border-radius: 24px;
          padding: 30px;
          box-shadow: 0 4px 20px rgba(0,0,0,0.03);
          border: 1px solid var(--border-color);
          margin-bottom: 40px;
      }
      .exchange-hero-img {
          width: 450px;
          height: 280px;
          border-radius: 16px;
          object-fit: cover;
          flex-shrink: 0;
      }
      .exchange-hero-content {
          flex-grow: 1;
          padding-top: 10px;
      }
      .exchange-hero-content h1 {
          font-size: 36px;
          font-weight: 300;
          color: #8e44ad;
          margin-bottom: 20px;
          letter-spacing: -0.5px;
      }
      .exchange-list {
          list-style: none;
          padding: 0;
      }
      .exchange-list li {
          font-size: 15px;
          color: #334155;
          margin-bottom: 15px;
          display: flex;
          align-items: flex-start;
          gap: 12px;
          line-height: 1.6;
      }
      .exchange-list li::before {
          content: '■';
          color: #8e44ad;
          font-size: 10px;
          margin-top: 5px;
      }
  </style>
</head>
<body>
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/svg_icons.php'; ?>
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/sidebar.php'; ?>
  
  <main class="main">
    <div class="bottom-dashboard-section" style="padding-top: 20px;">
       <div style="margin-bottom: 20px;">
           <a href="/pages/campus_life/external_activities.php" class="back-btn"><i class="fas fa-arrow-left"></i> Back to External Activities</a>
       </div>

       <!-- Hero Section -->
       <div class="exchange-hero">
           <img src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Internship Program" class="exchange-hero-img">
           <div class="exchange-hero-content">
               <h1>Internship</h1>
               <ul class="exchange-list">
                   <li>Internship regulations and policies may vary by department.</li>
                   <li>Consultation with an Academic Advisor or Department Head is required prior to application.</li>
               </ul>
           </div>
       </div>

       <h3 style="margin-bottom: 20px; font-size: 20px; color: var(--text-main);">Internship Guidelines</h3>

       <!-- Interactive PDF Viewer -->
       <div class="custom-pdf-container" id="internship-pdf-container">
           <div class="pdf-header">
               <div class="pdf-title">
                   <i class="fas fa-file-pdf"></i> <span>JIU Internship Guidelines 2025</span>
               </div>
               <div class="pdf-actions">
                   <a href="/assets/documents/intership/JIU INTERNSHIP GUIDELINES 2025.pdf" download class="pdf-btn pdf-btn-outline">
                       <i class="fas fa-download"></i> Download PDF
                   </a>
                   <button class="pdf-btn pdf-btn-primary" onclick="toggleFullscreen('internship-pdf-container')">
                       <i class="fas fa-expand"></i> Fullscreen
                   </button>
               </div>
           </div>
           
           <div class="pdf-body">
               <iframe 
                   src="/assets/documents/intership/JIU INTERNSHIP GUIDELINES 2025.pdf#toolbar=0&navpanes=0&view=FitH" 
                   type="application/pdf">
               </iframe>
           </div>
       </div>

    </div>
  </main>
  
  <script>
    function toggleFullscreen(containerId) {
        const container = document.getElementById(containerId);
        if (!document.fullscreenElement) {
            if (container.requestFullscreen) {
                container.requestFullscreen();
            } else if (container.webkitRequestFullscreen) {
                container.webkitRequestFullscreen();
            } else if (container.msRequestFullscreen) {
                container.msRequestFullscreen();
            }
        } else {
            if (document.exitFullscreen) {
                document.exitFullscreen();
            }
        }
    }
  </script>
  <script src="/assets/js/main.js"></script>
</body>
</html>
