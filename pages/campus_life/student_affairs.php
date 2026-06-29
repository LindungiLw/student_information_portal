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
  <link rel="stylesheet" href="/assets/css/dashboard.css?v=25">
  <link rel="stylesheet" href="/assets/css/sidebar.css?v=4">
  <link rel="stylesheet" href="/assets/css/variables.css">
  <link rel="stylesheet" href="/assets/css/base.css">
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
       
       <!-- PDF Modal Overlay -->
       <div id="pdf-modal" class="booklet-modal-backdrop" style="display: none;">
           <div class="booklet-modal-content">
               <div class="bm-header">
                   <div class="bm-title">
                       <i class="fas fa-file-pdf" style="color: #ef4444; font-size: 18px;"></i>
                       <span id="modal-pdf-title">Student Affairs Document</span>
                   </div>
                   <div style="display: flex; gap: 10px; align-items: center;">
                       <button class="pdf-btn" onclick="toggleFullscreen('modal-pdf-body')" style="background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.2); padding: 6px 14px; border-radius: 12px; color: white; cursor: pointer; font-size: 12.5px; font-weight: 600; display: flex; align-items: center; gap: 6px;">
                           <i class="fas fa-expand"></i> Fullscreen
                       </button>
                       <button class="bm-close" onclick="closePdfModal()">
                           <i class="fas fa-times"></i> Close
                       </button>
                   </div>
               </div>
               
               <div class="bm-body" id="modal-pdf-body">
                   <iframe 
                       id="affairs-pdf"
                       src="" 
                       style="width: 100%; height: 100%; border: none;"
                       type="application/pdf">
                   </iframe>
               </div>
           </div>
       </div>

    </div>
  </main>
  
  <script>
    function openPdfSection(keyword, pdfUrl = null) {
        const modal = document.getElementById('pdf-modal');
        const iframe = document.getElementById('affairs-pdf');
        const title = document.getElementById('modal-pdf-title');
        
        if(modal && iframe) {
            title.textContent = keyword + " Document";
            
            if (pdfUrl) {
                // If admin has uploaded a URL, use it
                const timestamp = new Date().getTime();
                iframe.src = `${pdfUrl}?t=${timestamp}#toolbar=0&navpanes=0&view=FitH`;
                iframe.style.display = 'block';
                
                // Hide empty state if exists
                let emptyState = document.getElementById('affairs-empty-state');
                if (emptyState) emptyState.style.display = 'none';
            } else {
                // Hide iframe, show empty state
                iframe.src = '';
                iframe.style.display = 'none';
                
                let emptyState = document.getElementById('affairs-empty-state');
                if (!emptyState) {
                    emptyState = document.createElement('div');
                    emptyState.id = 'affairs-empty-state';
                    emptyState.style.cssText = "display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%; color: #94a3b8; padding: 40px; text-align: center;";
                    emptyState.innerHTML = `
                        <i class="fas fa-file-pdf" style="font-size: 48px; color: #cbd5e1; margin-bottom: 16px;"></i>
                        <h3 style="font-size: 18px; color: #334155; margin-bottom: 8px;">No Document Uploaded</h3>
                        <p style="font-size: 14px; max-width: 300px;">The administration has not yet uploaded the document for ${keyword}. Please check back later.</p>
                    `;
                    document.getElementById('modal-pdf-body').appendChild(emptyState);
                } else {
                    emptyState.style.display = 'flex';
                    emptyState.querySelector('p').innerText = `The administration has not yet uploaded the document for ${keyword}. Please check back later.`;
                }
            }
            
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden'; // Prevent background scrolling
        }
    }

    function closePdfModal() {
        const modal = document.getElementById('pdf-modal');
        const iframe = document.getElementById('affairs-pdf');
        if(modal) {
            modal.style.display = 'none';
            document.body.style.overflow = ''; // Restore scrolling
        }
        if(iframe) {
            iframe.src = ''; // Stop loading/playing
        }
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
