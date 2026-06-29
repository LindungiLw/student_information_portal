<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /index.php');
    exit;
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/koneksi.php';

$forms_docs = [];
try {
    $stmt = $pdo->query("SELECT * FROM forms_documents ORDER BY id ASC");
    $all_docs = $stmt->fetchAll();
    foreach ($all_docs as $doc) {
        if (!empty($doc['file_path']) && file_exists($_SERVER['DOCUMENT_ROOT'] . $doc['file_path'])) {
            $forms_docs[] = $doc;
        }
    }
} catch (PDOException $e) {
    // If table doesn't exist
}

$current_page = 'student_services.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Forms | JIU Student Portal</title>
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
      .doc-btn.active { background: rgba(99, 102, 241, 0.1); border-color: rgba(99, 102, 241, 0.3); color: #6366f1; }
      
      /* Modern Steps Timeline */
      .steps-timeline {
          display: flex;
          gap: 24px;
          margin-bottom: 50px;
          flex-wrap: wrap;
      }
      .step-card {
          flex: 1;
          min-width: 250px;
          background: #ffffff;
          border-radius: 20px;
          padding: 24px;
          border: 1px solid var(--border-color);
          box-shadow: 0 4px 15px rgba(0,0,0,0.02);
          position: relative;
          overflow: hidden;
      }
      .step-number {
          position: absolute;
          top: -15px;
          right: -10px;
          font-size: 80px;
          font-weight: 800;
          color: rgba(99, 102, 241, 0.05);
          line-height: 1;
          z-index: 0;
      }
      .step-icon {
          width: 48px;
          height: 48px;
          border-radius: 12px;
          background: rgba(99, 102, 241, 0.1);
          color: #6366f1;
          display: flex;
          align-items: center;
          justify-content: center;
          font-size: 20px;
          margin-bottom: 16px;
          position: relative;
          z-index: 1;
      }
      .step-card h4 {
          font-size: 18px;
          font-weight: 800;
          color: #1e293b;
          margin-bottom: 10px;
          position: relative;
          z-index: 1;
      }
      .step-card p {
          font-size: 14px;
          color: #64748b;
          margin: 0;
          line-height: 1.6;
          position: relative;
          z-index: 1;
      }
  </style>
</head>
<body>
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/svg_icons.php'; ?>
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/sidebar.php'; ?>
  
  <main class="main">
    <div class="page-header">
       <h1><i class="fas fa-file-signature"></i> Administrative Forms</h1>
       <p>Download, fill, and submit official university forms for your academic and service needs.</p>
    </div>
    
    <div class="bottom-dashboard-section" style="padding-top: 0;">
       <div style="margin-bottom: 30px;">
           <a href="/pages/services/student_services.php" class="back-btn" style="display: inline-flex; align-items: center; gap: 8px; font-weight: 600; color: var(--text-muted); text-decoration: none; padding: 10px 16px; background: #f8fafc; border-radius: 10px; transition: 0.2s;"><i class="fas fa-arrow-left"></i> Back to Student Services</a>
       </div>

       <!-- Steps Timeline -->
       <h3 style="margin-bottom: 20px; font-size: 20px; color: var(--text-main);">How to Submit Forms</h3>
       <div class="steps-timeline">
           <div class="step-card">
               <div class="step-number">1</div>
               <div class="step-icon"><i class="fas fa-download"></i></div>
               <h4>Download</h4>
               <p>Find the required form from the list below and download the PDF file to your device.</p>
           </div>
           <div class="step-card">
               <div class="step-number">2</div>
               <div class="step-icon"><i class="fas fa-pen-alt"></i></div>
               <h4>Fill & Sign</h4>
               <p>Fill out the form completely. Don't forget to attach required signatures (yours and your advisor's).</p>
           </div>
           <div class="step-card">
               <div class="step-number">3</div>
               <div class="step-icon"><i class="fas fa-paper-plane"></i></div>
               <h4>Submit</h4>
               <p>Hand in the hardcopy to the Academic Office or upload the scanned copy via the specific portal.</p>
           </div>
       </div>

       <!-- Section 1: Forms Documents -->
       <h3 style="margin-bottom: 20px; font-size: 20px; color: var(--text-main);">Downloadable Forms</h3>
       
       <?php if (empty($forms_docs)): ?>
           <div class="empty-state-container" style="background: white; padding: 60px 40px; border-radius: 16px; text-align: center; border: 1px solid var(--border-color); box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
               <div class="empty-state-icon" style="font-size: 56px; color: #cbd5e1; margin-bottom: 20px;"><i class="fas fa-file-signature"></i></div>
               <div class="empty-state-title" style="font-size: 22px; font-weight: 800; color: #334155; margin-bottom: 12px;">No Forms Available</div>
               <div class="empty-state-desc" style="font-size: 15px; color: #64748b; max-width: 400px; margin: 0 auto;">There are no downloadable forms available at this moment. Please check back later or contact the administration.</div>
           </div>
       <?php else: ?>
           <div class="doc-buttons">
               <?php foreach ($forms_docs as $index => $doc): ?>
                   <button class="doc-btn forms-btn <?php echo $index === 0 ? 'active' : ''; ?>" onclick="loadPdf('<?php echo htmlspecialchars($doc['file_path']); ?>', '<?php echo addslashes(htmlspecialchars($doc['title'])); ?>', this)">
                       <i class="fas fa-file-pdf"></i> <?php echo htmlspecialchars($doc['title']); ?>
                   </button>
               <?php endforeach; ?>
           </div>

           <!-- Interactive PDF Viewer -->
           <div class="custom-pdf-container" id="forms-pdf-container">
               <div class="pdf-header">
                   <div class="pdf-title">
                       <i class="fas fa-file-pdf"></i> <span id="forms-title-text"><?php echo htmlspecialchars($forms_docs[0]['title']); ?></span>
                   </div>
                   <div class="pdf-actions">
                       <a href="<?php echo htmlspecialchars($forms_docs[0]['file_path']); ?>" id="forms-download-btn" download class="pdf-btn pdf-btn-outline">
                           <i class="fas fa-download"></i> Download Form
                       </a>
                       <button class="pdf-btn pdf-btn-primary" onclick="toggleFullscreen('forms-pdf-container')">
                           <i class="fas fa-expand"></i> Fullscreen
                       </button>
                   </div>
               </div>
               
               <div class="pdf-body">
                   <iframe 
                       id="forms-pdf"
                       src="<?php echo htmlspecialchars($forms_docs[0]['file_path']); ?>#toolbar=0&navpanes=0&view=FitH" 
                       type="application/pdf">
                   </iframe>
               </div>
           </div>
       <?php endif; ?>

    </div>
  </main>
  
  <script>
    function loadPdf(pdfUrl, title, btnElement) {
        const buttons = document.querySelectorAll('.forms-btn');
        buttons.forEach(btn => btn.classList.remove('active'));
        btnElement.classList.add('active');

        const iframe = document.getElementById('forms-pdf');
        iframe.src = `${pdfUrl}#toolbar=0&navpanes=0&view=FitH`;

        const downloadBtn = document.getElementById('forms-download-btn');
        downloadBtn.href = pdfUrl;
        
        document.getElementById('forms-title-text').innerText = title;
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






