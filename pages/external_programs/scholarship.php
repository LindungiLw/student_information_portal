<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /index.php');
    exit;
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/koneksi.php';

$scholarship_docs = [];
try {
    $stmt = $pdo->query("SELECT * FROM scholarship_documents ORDER BY id DESC");
    $scholarship_docs = $stmt->fetchAll();
} catch (PDOException $e) {
    // If the table doesn't exist yet, it stays empty
}

$current_page = 'external_activities.php'; // Keep sidebar active on External Activities
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Student Service Scholarship | JIU Student Portal</title>
  <link rel="icon" type="image/png" href="/assets/images/jiu-logo-rounded.png">
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="/assets/css/dashboard.css?v=10">
  <link rel="stylesheet" href="/assets/css/sidebar.css?v=3">
  <link rel="stylesheet" href="/assets/css/variables.css">
  <link rel="stylesheet" href="/assets/css/base.css">
  <link rel="stylesheet" href="/assets/css/responsive.css?v=4">
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
           <img src="https://images.unsplash.com/photo-1559027615-cd4628902d4a?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Student Service Scholarship" class="exchange-hero-img">
           <div class="exchange-hero-content">
               <h1>Student Service Scholarship</h1>
               <ul class="exchange-list">
                   <li>Scholarship regulations and policies may vary by department.</li>
                   <li>Consultation with an Academic Advisor or Department Head is required prior to application.</li>
               </ul>
           </div>
       </div>

       <h3 style="margin-bottom: 20px; font-size: 20px; color: var(--text-main);">Scholarship Guidelines</h3>

       <!-- Document Selection Buttons -->
       <div class="doc-buttons">
           <?php foreach ($scholarship_docs as $index => $doc): ?>
               <button class="doc-btn <?php echo $index === 0 ? 'active' : ''; ?>" onclick="loadPdf('<?php echo htmlspecialchars($doc['file_path']); ?>', this)">
                   <i class="fas fa-hand-holding-heart"></i> <?php echo htmlspecialchars($doc['title']); ?>
               </button>
           <?php endforeach; ?>
       </div>

       <?php if (count($scholarship_docs) > 0): ?>
       <!-- Interactive PDF Viewer -->
       <div class="custom-pdf-container" id="scholarship-pdf-container">
           <div class="pdf-header">
               <div class="pdf-title">
                   <i class="fas fa-file-pdf"></i> <span id="pdf-title-text">Official Scholarship Document</span>
               </div>
               <div class="pdf-actions">
                   <a href="<?php echo htmlspecialchars($scholarship_docs[0]['file_path']); ?>" id="pdf-download-btn" download class="pdf-btn pdf-btn-outline">
                       <i class="fas fa-download"></i> Download PDF
                   </a>
                   <button class="pdf-btn pdf-btn-primary" onclick="toggleFullscreen('scholarship-pdf-container')">
                       <i class="fas fa-expand"></i> Fullscreen
                   </button>
               </div>
           </div>
           
           <div class="pdf-body">
               <iframe 
                   id="scholarship-pdf"
                   src="<?php echo htmlspecialchars($scholarship_docs[0]['file_path']); ?>#toolbar=0&navpanes=0&view=FitH" 
                   type="application/pdf">
               </iframe>
           </div>
       </div>
       <?php else: ?>
       <div class="empty-state-container" style="background: white; padding: 40px; border-radius: 12px; text-align: center; border: 1px solid var(--border-color);">
           <div class="empty-state-icon" style="font-size: 48px; color: #cbd5e1; margin-bottom: 16px;"><i class="fas fa-file-pdf"></i></div>
           <div class="empty-state-title" style="font-size: 18px; font-weight: 700; margin-bottom: 8px;">No Documents Available</div>
           <div class="empty-state-desc" style="font-size: 14px; color: var(--text-muted); margin-bottom: 24px;">The scholarship guidelines have not been uploaded by the administration yet.</div>
       </div>
       <?php endif; ?>

    </div>
  </main>
  
  <script>
    function loadPdf(pdfUrl, btnElement) {
        // Update active button
        const buttons = document.querySelectorAll('.doc-btn');
        buttons.forEach(btn => btn.classList.remove('active'));
        btnElement.classList.add('active');

        // Update iframe
        const iframe = document.getElementById('scholarship-pdf');
        if (iframe) iframe.src = `${pdfUrl}#toolbar=0&navpanes=0&view=FitH`;

        // Update download link
        const downloadBtn = document.getElementById('pdf-download-btn');
        if (downloadBtn) downloadBtn.href = pdfUrl;

        // Smooth scroll to PDF
        const container = document.getElementById('scholarship-pdf-container');
        if (container) container.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

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
