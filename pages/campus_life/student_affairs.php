<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /index.php');
    exit;
}
$current_page = basename($_SERVER['PHP_SELF']);

require_once $_SERVER['DOCUMENT_ROOT'] . '/config/koneksi.php';

// Fetch documents from database (with error handling in case the table is not created yet)
$docs = [];
try {
    $stmt = $pdo->query("SELECT category, file_path FROM student_affairs_documents");
    $docs = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
} catch (PDOException $e) {
    // If the table doesn't exist, $docs remains an empty array
    // This allows the page to load gracefully and show the empty states.
}

$club_activities_pdf = (isset($docs['club_activities']) && file_exists($_SERVER['DOCUMENT_ROOT'] . $docs['club_activities'])) ? $docs['club_activities'] : null;
$student_union_pdf = (isset($docs['student_union']) && file_exists($_SERVER['DOCUMENT_ROOT'] . $docs['student_union'])) ? $docs['student_union'] : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Student Affairs | JIU Student Portal</title>
  <link rel="icon" type="image/png" href="/assets/images/jiu-logo-rounded.png">
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="/assets/css/dashboard.css?v=50">
  <link rel="stylesheet" href="/assets/css/sidebar.css?v=50">
  <link rel="stylesheet" href="/assets/css/variables.css">
  <link rel="stylesheet" href="/assets/css/base.css">
  <link rel="stylesheet" href="/assets/css/responsive.css?v=50">
  <style>
      @keyframes scaleUpModal {
          from { transform: scale(0.95); opacity: 0; }
          to { transform: scale(1); opacity: 1; }
      }
  </style>
</head>
<body>
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/svg_icons.php'; ?>
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/sidebar.php'; ?>
  
  <main class="main">
    <div class="page-header">
       <h1><i class="fas fa-users"></i> Student Affairs</h1>
       <p>Explore your passions, join student clubs, and connect with the Student Union.</p>
    </div>
    <div class="bottom-dashboard-section" style="padding-top: 0;">

       <!-- Horizontal Cards Container -->
       <div class="affairs-container">
           
           <!-- Club Activities -->
           <div class="affairs-card">
               <div class="affairs-img-wrapper">
                   <!-- Fallback Unsplash image for Soccer/Clubs -->
                   <img src="https://images.unsplash.com/photo-1526232761682-d26e03ac148e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Club Activities">
               </div>
               <div class="affairs-content">
                   <div class="affairs-badge">Student Life</div>
                   <h2>Club Activities</h2>
                   <p>Explore your passions! A wide variety of student clubs are waiting for you. Stay tuned for registration details.</p>
                   <a href="javascript:void(0)" onclick="openPdfSection('Club Activities', <?php echo $club_activities_pdf ? "'" . htmlspecialchars($club_activities_pdf) . "'" : 'null'; ?>)" class="affairs-btn">View More <i class="fas fa-arrow-right"></i></a>
               </div>
           </div>

           <!-- Student Union -->
           <div class="affairs-card">
               <div class="affairs-img-wrapper">
                   <!-- Fallback Unsplash image for Student Union/Lounge -->
                   <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Student Union">
               </div>
               <div class="affairs-content">
                   <div class="affairs-badge">Organization</div>
                   <h2>Student Union</h2>
                   <p>President: <strong>Lubiyani Tiiyo</strong></p>
                   <p>Vice President: <strong>Fadhil Ramadianshah</strong></p>
                   <a href="javascript:void(0)" onclick="openPdfSection('Student Union', <?php echo $student_union_pdf ? "'" . htmlspecialchars($student_union_pdf) . "'" : 'null'; ?>)" class="affairs-btn">View More <i class="fas fa-arrow-right"></i></a>
               </div>
           </div>

       </div>
       
       <!-- Pure 100% Clean PDF Lightbox Popup (No Header Bar) -->
       <div id="booklet-popup-modal" class="booklet-modal-backdrop" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.88); backdrop-filter: blur(12px); z-index: 999999; align-items: center; justify-content: center; padding: 20px;" onclick="closeBookletModal()">
           <button type="button" onclick="closeBookletModal()" title="Close Popup (Esc)" style="position: absolute; top: 24px; right: 24px; width: 48px; height: 48px; border-radius: 50%; background: rgba(255, 255, 255, 0.18); color: #ffffff; border: 1px solid rgba(255, 255, 255, 0.35); backdrop-filter: blur(10px); cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 20px; z-index: 1000000; box-shadow: 0 10px 25px rgba(0,0,0,0.4); transition: transform 0.25s, background 0.25s;" onmouseover="this.style.background='rgba(239, 68, 68, 0.9)'; this.style.transform='scale(1.1) rotate(90deg)';" onmouseout="this.style.background='rgba(255, 255, 255, 0.18)'; this.style.transform='scale(1) rotate(0deg)';">
               <i class="fas fa-times"></i>
           </button>
           <div class="pure-pdf-popup-box" onclick="event.stopPropagation()" style="width: min(920px, 94vw); height: min(90vh, 1200px); background: #e2e8f0; border-radius: 20px; overflow-y: auto; overflow-x: hidden; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.75); position: relative; border: 1px solid rgba(255, 255, 255, 0.22); animation: scaleUpModal 0.32s cubic-bezier(0.16, 1, 0.3, 1);">
               <div id="pdf-render-container" style="width: 100%; display: flex; flex-direction: column; align-items: center; padding: 20px; gap: 20px;"></div>
           </div>
       </div>

    </div>
  </main>
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
  <script>
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
    
    let currentExpandedUrl = null;

    function openPdfSection(keyword, pdfUrl = null) {
        const modal = document.getElementById('booklet-popup-modal');
        const container = document.getElementById('pdf-render-container');
        if (!modal || !container) return;
        
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';

        if (!pdfUrl) {
            container.innerHTML = `
                <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%; color: #94a3b8; padding: 40px; text-align: center;">
                    <i class="fas fa-file-pdf" style="font-size: 48px; color: #cbd5e1; margin-bottom: 16px;"></i>
                    <h3 style="font-size: 18px; color: #334155; margin-bottom: 8px;">No Document Uploaded</h3>
                    <p style="font-size: 14px; max-width: 300px;">The administration has not yet uploaded the document for ${keyword}. Please check back later.</p>
                </div>
            `;
            return;
        }
        
        if (currentExpandedUrl !== pdfUrl) {
            currentExpandedUrl = pdfUrl;
            container.innerHTML = '<div style="color: #64748b; font-weight: 600; padding: 40px; text-align: center; font-family: \'Manrope\', sans-serif;"><i class="fas fa-circle-notch fa-spin" style="font-size: 24px; margin-bottom: 12px; color: #3b82f6;"></i><br>Loading document...</div>';
            
            pdfjsLib.getDocument(pdfUrl).promise.then(pdf => {
                const screenWidth = window.innerWidth;
                let scale = 1.5;
                if (screenWidth < 600) scale = 1.0;

                const renderPage = (num) => {
                    return pdf.getPage(num).then(page => {
                        const viewport = page.getViewport({ scale: scale });
                        const canvas = document.createElement('canvas');
                        const context = canvas.getContext('2d');
                        canvas.width = viewport.width; canvas.height = viewport.height;
                        canvas.style.maxWidth = '100%'; canvas.style.height = 'auto';
                        canvas.style.boxShadow = '0 10px 25px rgba(0,0,0,0.1)';
                        canvas.style.borderRadius = '8px'; canvas.style.background = '#fff';

                        return page.render({ canvasContext: context, viewport: viewport }).promise.then(() => canvas);
                    });
                };

                const renderAllPages = async () => {
                    const canvases = [];
                    for (let i = 1; i <= pdf.numPages; i++) {
                        canvases.push(await renderPage(i));
                    }
                    container.innerHTML = '';
                    canvases.forEach(c => container.appendChild(c));
                };

                renderAllPages().catch(err => {
                    console.error("Error rendering pages: ", err);
                    container.innerHTML = '<div style="color: #ef4444; font-weight: 600; padding: 40px; text-align: center;">Failed to load PDF pages.</div>';
                });
            }).catch(e => {
                console.error(e);
                container.innerHTML = '<div style="color: #ef4444; font-weight: 600; padding: 40px; text-align: center;">Failed to open document.</div>';
            });
        }
    }

    function closeBookletModal() {
        const modal = document.getElementById('booklet-popup-modal');
        if (modal) {
            modal.style.display = 'none';
            document.body.style.overflow = '';
        }
    }
    
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeBookletModal();
    });
  </script>
  <script src="/assets/js/main.js"></script>
</body>
</html>
