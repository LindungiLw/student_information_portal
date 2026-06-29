<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /index.php');
    exit;
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/koneksi.php';

$dormitory_docs = [];
try {
    $stmt = $pdo->query("SELECT * FROM dormitory_documents ORDER BY id ASC");
    $all_docs = $stmt->fetchAll();
    foreach ($all_docs as $doc) {
        if (!empty($doc['file_path']) && file_exists($_SERVER['DOCUMENT_ROOT'] . $doc['file_path'])) {
            $dormitory_docs[] = $doc;
        }
    }
} catch (PDOException $e) {
    // If the table doesn't exist, it remains an empty array
}

$current_page = 'student_services.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dormitory | JIU Student Portal</title>
  <link rel="icon" type="image/png" href="/assets/images/jiu-logo-rounded.png">
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="/assets/css/dashboard.css?v=10">
  <link rel="stylesheet" href="/assets/css/sidebar.css?v=3">
  <link rel="stylesheet" href="/assets/css/variables.css">
  <link rel="stylesheet" href="/assets/css/base.css">
  <link rel="stylesheet" href="/assets/css/responsive.css?v=4">
  <style>
      .doc-buttons { 
          display: flex; 
          gap: 12px; 
          margin-bottom: 30px; 
          overflow-x: auto; 
          padding-bottom: 12px; 
          scrollbar-width: thin; 
          scrollbar-color: #cbd5e1 transparent;
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
          white-space: nowrap;
          flex-shrink: 0;
      }
      .doc-buttons::-webkit-scrollbar { height: 6px; }
      .doc-buttons::-webkit-scrollbar-track { background: transparent; }
      .doc-buttons::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 6px; }
      .doc-btn:hover { background: #f1f5f9; transform: translateY(-2px); }
      .doc-btn.active { background: rgba(236, 72, 153, 0.1); border-color: rgba(236, 72, 153, 0.3); color: #ec4899; }
  </style>
</head>
<body>
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/svg_icons.php'; ?>
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/sidebar.php'; ?>
  
  <main class="main">
    <div class="page-header">
       <h1><i class="fas fa-building"></i> Campus Dormitory</h1>
       <p>Information, rules, and guidelines for comfortable community living.</p>
    </div>
    
    <div class="bottom-dashboard-section" style="padding-top: 0;">
       <div style="margin-bottom: 30px;">
           <a href="/pages/services/student_services.php" class="back-btn" style="display: inline-flex; align-items: center; gap: 8px; font-weight: 600; color: var(--text-muted); text-decoration: none; padding: 10px 16px; background: #f8fafc; border-radius: 10px; transition: 0.2s;"><i class="fas fa-arrow-left"></i> Back to Student Services</a>
       </div>

       <h3 style="margin-bottom: 20px; font-size: 20px; color: var(--text-main);">Dormitory Documents</h3>
       
       <?php if (empty($dormitory_docs)): ?>
           <div class="empty-state-container" style="background: white; padding: 60px 40px; border-radius: 16px; text-align: center; border: 1px solid var(--border-color); box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
               <div class="empty-state-icon" style="font-size: 56px; color: #cbd5e1; margin-bottom: 20px;"><i class="fas fa-building"></i></div>
               <div class="empty-state-title" style="font-size: 22px; font-weight: 800; color: #334155; margin-bottom: 12px;">No Documents Available</div>
               <div class="empty-state-desc" style="font-size: 15px; color: #64748b; max-width: 400px; margin: 0 auto;">The administration has not uploaded any dormitory guidelines or documents yet. Please check back later.</div>
           </div>
       <?php else: ?>
           <div class="doc-buttons">
               <?php foreach ($dormitory_docs as $index => $doc): ?>
                   <button class="doc-btn dorm-btn <?php echo $index === 0 ? 'active' : ''; ?>" onclick="loadPdf('<?php echo htmlspecialchars($doc['file_path']); ?>', '<?php echo addslashes(htmlspecialchars($doc['title'])); ?>', this)">
                       <i class="fas fa-file-pdf"></i> <?php echo htmlspecialchars($doc['title']); ?>
                   </button>
               <?php endforeach; ?>
           </div>

           <!-- Interactive PDF Viewer -->
           <div class="custom-pdf-container" id="dorm-pdf-container">
               <div class="pdf-header">
                   <div class="pdf-title">
                       <i class="fas fa-file-pdf"></i> <span id="dorm-title-text"><?php echo htmlspecialchars($dormitory_docs[0]['title']); ?></span>
                   </div>
                   <div class="pdf-actions">
                       <a href="<?php echo htmlspecialchars($dormitory_docs[0]['file_path']); ?>" id="dorm-download-btn" download class="pdf-btn pdf-btn-outline">
                           <i class="fas fa-download"></i> Download PDF
                       </a>
                       <button class="pdf-btn pdf-btn-primary" onclick="toggleFullscreen('dorm-pdf-container')">
                           <i class="fas fa-expand"></i> Fullscreen
                       </button>
                   </div>
               </div>
               
               <div class="pdf-body">
                   <iframe 
                       id="dorm-pdf"
                       src="<?php echo htmlspecialchars($dormitory_docs[0]['file_path']); ?>#toolbar=0&navpanes=0&view=FitH" 
                       type="application/pdf">
                   </iframe>
               </div>
           </div>
       <?php endif; ?>

    </div>
  </main>
  
  <script>
    function loadPdf(pdfUrl, title, btnElement) {
        const buttons = document.querySelectorAll('.dorm-btn');
        buttons.forEach(btn => btn.classList.remove('active'));
        btnElement.classList.add('active');

        const iframe = document.getElementById('dorm-pdf');
        iframe.src = `${pdfUrl}#toolbar=0&navpanes=0&view=FitH`;

        const downloadBtn = document.getElementById('dorm-download-btn');
        downloadBtn.href = pdfUrl;
        
        document.getElementById('dorm-title-text').innerText = title;
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






