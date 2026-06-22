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
  <title>Student Exchange Program | JIU Student Portal</title>
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
      
      .doc-buttons {
          display: flex;
          gap: 15px;
          margin-bottom: 30px;
          flex-wrap: wrap;
      }
      .doc-btn {
          padding: 14px 24px;
          background: #f8fafc;
          border: 1px solid var(--border-color);
          border-radius: 12px;
          color: #475569;
          font-weight: 700;
          font-size: 14px;
          cursor: pointer;
          transition: all 0.3s;
          display: flex;
          align-items: center;
          gap: 10px;
      }
      .doc-btn:hover {
          background: #f1f5f9;
          transform: translateY(-2px);
      }
      .doc-btn.active {
          background: rgba(107, 33, 168, 0.1);
          border-color: rgba(107, 33, 168, 0.3);
          color: var(--purple-accent);
      }
      
      @media screen and (max-width: 768px) {
          .exchange-hero {
              flex-direction: column;
              padding: 20px;
              gap: 20px;
          }
          .exchange-hero-img {
              width: 100%;
              height: auto;
              aspect-ratio: 16/9;
          }
          .exchange-hero-content h1 {
              font-size: 28px;
          }
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

       <!-- Exchange Hero Section -->
       <div class="exchange-hero">
           <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Exchange Program" class="exchange-hero-img">
           <div class="exchange-hero-content">
               <h1>Student Exchange Program</h1>
               <ul class="exchange-list">
                   <li>Student Exchange Program application opens Oct- Nov timeframe.</li>
                   <li>Application for 2026 Exchange Program is currently closed.</li>
                   <li>Please consult with your academic advisor when you plan for exchange student program.</li>
               </ul>
           </div>
       </div>

       <!-- Document Selection Buttons -->
       <h3 style="margin-bottom: 20px; font-size: 20px; color: var(--text-main);">Available Universities & Fact Sheets</h3>
       <div class="doc-buttons">
           <button class="doc-btn active" onclick="loadPdf('/assets/documents/exchange/1b. SEAM Announcement 2026-Fall.pdf', this)">
               <i class="fas fa-university"></i> Handong Global Univ. (HGU)
           </button>
           <button class="doc-btn" onclick="loadPdf('/assets/documents/exchange/INTI Student Mobility Programme Brochure 2026.pdf', this)">
               <i class="fas fa-university"></i> INTI International Univ.
           </button>
           <button class="doc-btn" onclick="loadPdf('/assets/documents/exchange/[DLSU] Fact Sheet vMay2025.pdf', this)">
               <i class="fas fa-university"></i> De La Salle Univ. (DLSU)
           </button>
       </div>

       <!-- Interactive PDF Viewer -->
       <div class="custom-pdf-container" id="exchange-pdf-container">
           <div class="pdf-header">
               <div class="pdf-title">
                   <i class="fas fa-file-pdf"></i> <span id="pdf-title-text">Official Exchange Document</span>
               </div>
               <div class="pdf-actions">
                   <a href="#" id="pdf-download-btn" download class="pdf-btn pdf-btn-outline">
                       <i class="fas fa-download"></i> Download PDF
                   </a>
                   <button class="pdf-btn pdf-btn-primary" onclick="toggleFullscreen('exchange-pdf-container')">
                       <i class="fas fa-expand"></i> Fullscreen
                   </button>
               </div>
           </div>
           
           <div class="pdf-body">
               <iframe 
                   id="exchange-pdf"
                   src="/assets/documents/exchange/1b. SEAM Announcement 2026-Fall.pdf#toolbar=0&navpanes=0&view=FitH" 
                   type="application/pdf">
               </iframe>
           </div>
       </div>

    </div>
  </main>
  
  <script>
    function loadPdf(pdfUrl, btnElement) {
        // Update active button
        const buttons = document.querySelectorAll('.doc-btn');
        buttons.forEach(btn => btn.classList.remove('active'));
        btnElement.classList.add('active');

        // Update iframe
        const iframe = document.getElementById('exchange-pdf');
        iframe.src = `${pdfUrl}#toolbar=0&navpanes=0&view=FitH`;

        // Update download link
        const downloadBtn = document.getElementById('pdf-download-btn');
        downloadBtn.href = pdfUrl;

        // Smooth scroll to PDF
        const container = document.getElementById('exchange-pdf-container');
        container.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    // Set initial download link
    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById('pdf-download-btn').href = '/assets/documents/exchange/1b. SEAM Announcement 2026-Fall.pdf';
    });

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
