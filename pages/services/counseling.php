<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /index.php');
    exit;
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/koneksi.php';

$stmt = $pdo->query("SELECT * FROM counseling_documents ORDER BY id ASC");
$counseling_docs = $stmt->fetchAll();

if (count($counseling_docs) === 0) {
    $pdo->exec("INSERT INTO counseling_documents (title, file_path) VALUES 
        ('JIU Student Counseling Information', '/assets/documents/couseling/JIU Student Counseling (1).pdf')");
    $stmt = $pdo->query("SELECT * FROM counseling_documents ORDER BY id ASC");
    $counseling_docs = $stmt->fetchAll();
}

$current_page = 'student_services.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Counseling | JIU Student Portal</title>
  <link rel="icon" type="image/png" href="/assets/images/jiu-logo-rounded.png">
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="/assets/css/dashboard.css?v=10">
  <link rel="stylesheet" href="/assets/css/sidebar.css?v=3">
  <link rel="stylesheet" href="/assets/css/variables.css">
  <link rel="stylesheet" href="/assets/css/base.css">
  <link rel="stylesheet" href="/assets/css/responsive.css?v=4">
  <style>
      .doc-buttons { display: flex; gap: 12px; margin-bottom: 30px; overflow-x: auto; padding-bottom: 12px; scrollbar-width: thin; scrollbar-color: #cbd5e1 transparent; }
      .doc-btn { padding: 14px 24px; background: #f8fafc; border: 1px solid var(--border-color); border-radius: 12px; color: #475569; font-weight: 700; font-size: 14px; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; gap: 10px; white-space: nowrap; flex-shrink: 0; }
      .doc-buttons::-webkit-scrollbar { height: 6px; }
      .doc-buttons::-webkit-scrollbar-track { background: transparent; }
      .doc-buttons::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 6px; }
      .doc-btn:hover { background: #f1f5f9; transform: translateY(-2px); }
      .doc-btn.active { background: rgba(16, 185, 129, 0.1); border-color: rgba(16, 185, 129, 0.3); color: #10b981; }
      
      .form-btn {
          display: inline-flex; align-items: center; gap: 8px; background: #10b981; color: #fff; padding: 12px 20px; border-radius: 10px; text-decoration: none; font-weight: 600; font-size: 14px; transition: all 0.3s; margin-left: 20px;
      }
      .form-btn:hover { background: #059669; color: #fff; transform: translateY(-1px); }
  </style>
</head>
<body>
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/svg_icons.php'; ?>
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/sidebar.php'; ?>
  
  <main class="main">
    <div class="page-header">
       <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 15px; width: 100%;">
           <div>
               <h1><i class="fas fa-hands-helping"></i> Counseling Program</h1>
               <p>Confidential support and guidance for your well-being.</p>
           </div>
           <a href="https://forms.gle/your-google-form-link" target="_blank" class="form-btn">
               <i class="fab fa-wpforms"></i> Request Counseling Form
           </a>
       </div>
    </div>
    
    <div class="bottom-dashboard-section" style="padding-top: 0;">
       <div style="margin-bottom: 30px;">
           <a href="/pages/services/student_services.php" class="back-btn" style="display: inline-flex; align-items: center; gap: 8px; font-weight: 600; color: var(--text-muted); text-decoration: none; padding: 10px 16px; background: #f8fafc; border-radius: 10px; transition: 0.2s;"><i class="fas fa-arrow-left"></i> Back to Student Services</a>
       </div>

       <h3 style="margin-bottom: 20px; font-size: 20px; color: var(--text-main);">Counseling Guides & Documents</h3>
       <div class="doc-buttons">
           <?php foreach ($counseling_docs as $index => $doc): ?>
               <button class="doc-btn counsel-btn <?php echo $index === 0 ? 'active' : ''; ?>" onclick="loadPdf('<?php echo htmlspecialchars($doc['file_path']); ?>', '<?php echo addslashes(htmlspecialchars($doc['title'])); ?>', this)">
                   <i class="fas fa-file-pdf"></i> <?php echo htmlspecialchars($doc['title']); ?>
               </button>
           <?php endforeach; ?>
           <?php if (count($counseling_docs) === 0): ?>
               <p style="color: var(--text-muted);">No counseling documents available.</p>
           <?php endif; ?>
       </div>

       <?php if (count($counseling_docs) > 0): ?>
       <!-- Interactive PDF Viewer -->
       <div class="custom-pdf-container" id="counsel-pdf-container">
           <div class="pdf-header">
               <div class="pdf-title">
                   <i class="fas fa-file-pdf"></i> <span id="counsel-title-text"><?php echo htmlspecialchars($counseling_docs[0]['title']); ?></span>
               </div>
               <div class="pdf-actions">
                   <a href="<?php echo htmlspecialchars($counseling_docs[0]['file_path']); ?>" id="counsel-download-btn" download class="pdf-btn pdf-btn-outline">
                       <i class="fas fa-download"></i> Download PDF
                   </a>
                   <button class="pdf-btn pdf-btn-primary" onclick="toggleFullscreen('counsel-pdf-container')">
                       <i class="fas fa-expand"></i> Fullscreen
                   </button>
               </div>
           </div>
           
           <div class="pdf-body">
               <iframe 
                   id="counsel-pdf"
                   data-src="<?php echo htmlspecialchars($counseling_docs[0]['file_path']); ?>#toolbar=0&navpanes=0&view=FitH" 
                   type="application/pdf">
               </iframe>
           </div>
       </div>
       <?php endif; ?>

    </div>
  </main>
  
  <script>
    function loadPdf(pdfUrl, title, btnElement) {
        const buttons = document.querySelectorAll('.counsel-btn');
        buttons.forEach(btn => btn.classList.remove('active'));
        btnElement.classList.add('active');

        const iframe = document.getElementById('counsel-pdf');
        iframe.src = `${pdfUrl}#toolbar=0&navpanes=0&view=FitH`;

        const downloadBtn = document.getElementById('counsel-download-btn');
        downloadBtn.href = pdfUrl;
        
        document.getElementById('counsel-title-text').innerText = title;
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






