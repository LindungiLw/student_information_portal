<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /index.php');
    exit;
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/koneksi.php';

$exchange_docs = [];
$internship_docs = [];
$scholarship_docs = [];

try {
    $stmt = $pdo->query("SELECT * FROM exchange_documents ORDER BY id ASC");
    $raw_exchange = $stmt->fetchAll();
    foreach ($raw_exchange as $doc) {
        if (!empty($doc['file_path']) && file_exists($_SERVER['DOCUMENT_ROOT'] . $doc['file_path'])) {
            $exchange_docs[] = $doc;
        }
    }

    $stmt2 = $pdo->query("SELECT * FROM internship_documents ORDER BY id ASC");
    $raw_intern = $stmt2->fetchAll();
    foreach ($raw_intern as $doc) {
        if (!empty($doc['file_path']) && file_exists($_SERVER['DOCUMENT_ROOT'] . $doc['file_path'])) {
            $internship_docs[] = $doc;
        }
    }

    $stmt3 = $pdo->query("SELECT * FROM scholarship_documents ORDER BY id ASC");
    $raw_schol = $stmt3->fetchAll();
    foreach ($raw_schol as $doc) {
        if (!empty($doc['file_path']) && file_exists($_SERVER['DOCUMENT_ROOT'] . $doc['file_path'])) {
            $scholarship_docs[] = $doc;
        }
    }
} catch (PDOException $e) {
    // If tables don't exist yet, just keep empty arrays
}

$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>External Activities | JIU Student Portal</title>
  <link rel="icon" type="image/png" href="/assets/images/jiu-logo-rounded.png">
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="/assets/css/dashboard.css?v=10">
  <link rel="stylesheet" href="/assets/css/sidebar.css?v=3">
  <link rel="stylesheet" href="/assets/css/variables.css">
  <link rel="stylesheet" href="/assets/css/base.css">
  <link rel="stylesheet" href="/assets/css/responsive.css?v=4">
</head>
<body>
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/svg_icons.php'; ?>
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/sidebar.php'; ?>
  
  <main class="main">
    <div class="page-header">
       <h1><i class="fas fa-globe-americas"></i> External Activities</h1>
       <p>Broaden your horizons through global exchanges, professional internships, and service scholarships.</p>
    </div>
    <div class="bottom-dashboard-section" style="padding-top: 0;">

       <!-- Tab CSS -->
       <style>
           .dept-tabs {
               display: flex;
               overflow-x: auto;
               border-bottom: 2px solid var(--border-color);
               margin-top: 30px;
               gap: 12px;
               padding-bottom: 4px;
           }
           .dept-tab-btn {
               padding: 12px 24px;
               background: transparent;
               border: none;
               font-family: 'Manrope', sans-serif;
               font-size: 15px;
               font-weight: 700;
               color: var(--text-muted);
               cursor: pointer;
               border-radius: 8px 8px 0 0;
               transition: all 0.3s ease;
               white-space: nowrap;
               position: relative;
           }
           .dept-tab-btn:hover {
               color: var(--purple-accent);
               background: rgba(107, 33, 168, 0.05);
           }
           .dept-tab-btn.active {
               color: var(--purple-accent);
           }
           .dept-tab-btn.active::after {
               content: '';
               position: absolute;
               bottom: -6px;
               left: 0;
               width: 100%;
               height: 4px;
               background: var(--purple-accent);
               border-radius: 4px 4px 0 0;
           }
           
           .dept-tab-content {
               display: none;
               padding: 30px 0;
               animation: fadeIn 0.4s ease forwards;
           }
           .dept-tab-content.active {
               display: block;
           }
           @keyframes fadeIn {
               from { opacity: 0; transform: translateY(10px); }
               to { opacity: 1; transform: translateY(0); }
           }

           /* Hero Styling */
           .exchange-hero {
               display: flex;
               align-items: flex-start;
               gap: 40px;
               background: #fff;
               border-radius: 24px;
               padding: 30px;
               box-shadow: 0 4px 20px rgba(0,0,0,0.03);
               border: 1px solid var(--border-color);
               margin-bottom: 30px;
           }
           .exchange-hero-img {
               width: 400px;
               height: 250px;
               border-radius: 16px;
               object-fit: cover;
               flex-shrink: 0;
           }
           .exchange-hero-content {
               flex-grow: 1;
               padding-top: 10px;
           }
           .exchange-hero-content h1 {
               font-size: 32px;
               font-weight: 800;
               color: #1e293b;
               margin-bottom: 15px;
               letter-spacing: -0.5px;
           }
           .exchange-badge {
               display: inline-block;
               padding: 6px 14px;
               background: rgba(107, 33, 168, 0.08);
               color: var(--purple-accent);
               font-size: 11px;
               font-weight: 800;
               border-radius: 20px;
               letter-spacing: 0.8px;
               text-transform: uppercase;
               margin-bottom: 15px;
           }
           .exchange-list {
               list-style: none;
               padding: 0;
               margin-top: 15px;
           }
           .exchange-list li {
               font-size: 15px;
               color: #4a5568;
               margin-bottom: 12px;
               display: flex;
               align-items: flex-start;
               gap: 12px;
               line-height: 1.6;
           }
           .exchange-list li::before {
               content: '■';
               color: var(--purple-accent);
               font-size: 10px;
               margin-top: 5px;
           }
           .scholar-table th, .scholar-table td { padding: 12px 15px; border-bottom: 1px solid var(--border-color); text-align: left; }
             .scholar-table th { background: #f8fafc; font-weight: 700; color: #475569; }
             
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
             .doc-btn.active { background: rgba(107, 33, 168, 0.1); border-color: rgba(107, 33, 168, 0.3); color: var(--purple-accent); }
             
             @media screen and (max-width: 768px) {
                 .exchange-hero { flex-direction: column; padding: 20px; gap: 20px; }
                 .exchange-hero-img { width: 100%; height: auto; aspect-ratio: 16/9; }
             }
       </style>

       <!-- Tab Navigation -->
       <div class="dept-tabs">
           <button class="dept-tab-btn active" onclick="openTab(event, 'tab-exchange')">Student Exchange</button>
           <button class="dept-tab-btn" onclick="openTab(event, 'tab-internship')">Internship</button>
           <button class="dept-tab-btn" onclick="openTab(event, 'tab-scholarship')">Service Scholarship</button>
       </div>

        <!-- Tab Content 1: Exchange -->
        <div id="tab-exchange" class="dept-tab-content active">
            <div class="exchange-hero">
                <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Student Exchange Program" class="exchange-hero-img">
                <div class="exchange-hero-content">
                    <div class="exchange-badge">Global Experience</div>
                    <h1>Student Exchange Program</h1>
                    <ul class="exchange-list">
                        <li>Student Exchange Program application opens Oct- Nov timeframe.</li>
                        <li>Application for 2026 Exchange Program is currently closed.</li>
                        <li>Please consult with your academic advisor when you plan for exchange student program.</li>
                    </ul>
                </div>
            </div>

            <!-- Exchange Document Selection Buttons -->
            <h3 style="margin-bottom: 20px; font-size: 20px; color: var(--text-main);">Available Programs</h3>
            
            <?php if (empty($exchange_docs)): ?>
                <div class="empty-state-container" style="background: white; padding: 60px 40px; border-radius: 16px; text-align: center; border: 1px solid var(--border-color); box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
                    <div class="empty-state-icon" style="font-size: 56px; color: #cbd5e1; margin-bottom: 20px;"><i class="fas fa-plane-departure"></i></div>
                    <div class="empty-state-title" style="font-size: 22px; font-weight: 800; color: #334155; margin-bottom: 12px;">No Exchange Documents Available</div>
                    <div class="empty-state-desc" style="font-size: 15px; color: #64748b; max-width: 400px; margin: 0 auto;">Exchange program details have not been uploaded by the administration yet. Please check back later.</div>
                </div>
            <?php else: ?>
                <div class="doc-buttons">
                    <?php foreach ($exchange_docs as $index => $doc): ?>
                        <button class="doc-btn exchange-btn <?php echo $index === 0 ? 'active' : ''; ?>" onclick="loadPdf('<?php echo htmlspecialchars($doc['file_path']); ?>', '<?php echo addslashes(htmlspecialchars($doc['title'])); ?>', this, 'exchange-pdf', 'exchange-download-btn', 'exchange-title-text', 'exchange-btn')">
                            <i class="fas fa-file-pdf"></i> <?php echo htmlspecialchars($doc['title']); ?>
                        </button>
                    <?php endforeach; ?>
                </div>

                <!-- Interactive PDF Viewer -->
                <div class="custom-pdf-container" id="exchange-pdf-container">
                    <button class="floating-fullscreen-btn" onclick="toggleFullscreen('exchange-pdf-container')">
                        <i class="fas fa-expand"></i> Fullscreen
                    </button>
                    
                    <div class="pdf-body">
                        <iframe 
                            id="exchange-pdf"
                            class="ignore-mobile-fallback"
                            src="<?php echo htmlspecialchars($exchange_docs[0]['file_path']); ?>#toolbar=0&navpanes=0&view=FitH" 
                            type="application/pdf">
                        </iframe>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Tab Content 2: Internship -->
        <div id="tab-internship" class="dept-tab-content">
            <div class="exchange-hero">
                <img src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Internship Program" class="exchange-hero-img">
                <div class="exchange-hero-content">
                    <div class="exchange-badge" style="color: #dd6b20; background: rgba(221, 107, 32, 0.1);">Career Prep</div>
                    <h1>Internship</h1>
                    <ul class="exchange-list">
                        <li>Internship regulations and policies may vary by department.</li>
                        <li>Consultation with an Academic Advisor or Department Head is required prior to application.</li>
                    </ul>
                </div>
            </div>

            <!-- Internship Document Selection Buttons -->
            <h3 style="margin-bottom: 20px; font-size: 20px; color: var(--text-main);">Internship Guidelines</h3>
            
            <?php if (empty($internship_docs)): ?>
                <div class="empty-state-container" style="background: white; padding: 60px 40px; border-radius: 16px; text-align: center; border: 1px solid var(--border-color); box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
                    <div class="empty-state-icon" style="font-size: 56px; color: #cbd5e1; margin-bottom: 20px;"><i class="fas fa-briefcase"></i></div>
                    <div class="empty-state-title" style="font-size: 22px; font-weight: 800; color: #334155; margin-bottom: 12px;">No Internship Documents Available</div>
                    <div class="empty-state-desc" style="font-size: 15px; color: #64748b; max-width: 400px; margin: 0 auto;">Internship guidelines have not been uploaded by the administration yet. Please check back later.</div>
                </div>
            <?php else: ?>
                <div class="doc-buttons">
                    <?php foreach ($internship_docs as $index => $doc): ?>
                        <button class="doc-btn internship-btn <?php echo $index === 0 ? 'active' : ''; ?>" onclick="loadPdf('<?php echo htmlspecialchars($doc['file_path']); ?>', '<?php echo addslashes(htmlspecialchars($doc['title'])); ?>', this, 'internship-pdf', 'internship-download-btn', 'internship-title-text', 'internship-btn')">
                            <i class="fas fa-file-contract"></i> <?php echo htmlspecialchars($doc['title']); ?>
                        </button>
                    <?php endforeach; ?>
                </div>

                <!-- Interactive PDF Viewer -->
                <div class="custom-pdf-container" id="internship-pdf-container">
                    <button class="floating-fullscreen-btn" onclick="toggleFullscreen('internship-pdf-container')">
                        <i class="fas fa-expand"></i> Fullscreen
                    </button>
                    
                    <div class="pdf-body">
                        <iframe 
                            id="internship-pdf"
                            class="ignore-mobile-fallback"
                            src="<?php echo htmlspecialchars($internship_docs[0]['file_path']); ?>#toolbar=0&navpanes=0&view=FitH" 
                            type="application/pdf">
                        </iframe>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Tab Content 3: Scholarship -->
        <div id="tab-scholarship" class="dept-tab-content">
            <div class="exchange-hero">
                <img src="https://images.unsplash.com/photo-1559027615-cd4628902d4a?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Student Service Scholarship" class="exchange-hero-img">
                <div class="exchange-hero-content">
                    <div class="exchange-badge" style="color: #059669; background: rgba(5, 150, 105, 0.1);">Financial Support</div>
                    <h1>Student Service Scholarship</h1>
                    <ul class="exchange-list">
                        <li>Internship regulations and policies may vary by department.</li>
                        <li>Consultation with an Academic Advisor or Department Head is required prior to application.</li>
                    </ul>
                </div>
            </div>

            <!-- Scholarship Document Selection Buttons -->
            <h3 style="margin-bottom: 20px; font-size: 20px; color: var(--text-main);">Scholarship Documents</h3>
            
            <?php if (empty($scholarship_docs)): ?>
                <div class="empty-state-container" style="background: white; padding: 60px 40px; border-radius: 16px; text-align: center; border: 1px solid var(--border-color); box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
                    <div class="empty-state-icon" style="font-size: 56px; color: #cbd5e1; margin-bottom: 20px;"><i class="fas fa-hand-holding-heart"></i></div>
                    <div class="empty-state-title" style="font-size: 22px; font-weight: 800; color: #334155; margin-bottom: 12px;">No Scholarship Documents Available</div>
                    <div class="empty-state-desc" style="font-size: 15px; color: #64748b; max-width: 400px; margin: 0 auto;">Scholarship programs have not been uploaded by the administration yet. Please check back later.</div>
                </div>
            <?php else: ?>
                <div class="doc-buttons">
                    <?php foreach ($scholarship_docs as $index => $doc): ?>
                        <button class="doc-btn scholarship-btn <?php echo $index === 0 ? 'active' : ''; ?>" onclick="loadPdf('<?php echo htmlspecialchars($doc['file_path']); ?>', '<?php echo addslashes(htmlspecialchars($doc['title'])); ?>', this, 'scholarship-pdf', 'scholarship-download-btn', 'scholarship-title-text', 'scholarship-btn')">
                            <i class="fas fa-hand-holding-heart"></i> <?php echo htmlspecialchars($doc['title']); ?>
                        </button>
                    <?php endforeach; ?>
                </div>

                <!-- Interactive PDF Viewer -->
                <div class="custom-pdf-container" id="scholarship-pdf-container">
                    <button class="floating-fullscreen-btn" onclick="toggleFullscreen('scholarship-pdf-container')">
                        <i class="fas fa-expand"></i> Fullscreen
                    </button>
                    
                    <div class="pdf-body">
                        <iframe 
                            id="scholarship-pdf"
                            class="ignore-mobile-fallback"
                            src="<?php echo htmlspecialchars($scholarship_docs[0]['file_path']); ?>#toolbar=0&navpanes=0&view=FitH" 
                            type="application/pdf">
                        </iframe>
                    </div>
                </div>
            <?php endif; ?>
        </div>

       <script>
       function openTab(evt, tabId) {
           var tabContents = document.getElementsByClassName("dept-tab-content");
           for (var i = 0; i < tabContents.length; i++) {
               tabContents[i].classList.remove("active");
           }
           var tabBtns = document.getElementsByClassName("dept-tab-btn");
           for (var i = 0; i < tabBtns.length; i++) {
               tabBtns[i].classList.remove("active");
           }
           document.getElementById(tabId).classList.add("active");
           evt.currentTarget.classList.add("active");
       }
       
       function loadPdf(pdfUrl, title, btnElement, pdfId, downloadBtnId, titleId, btnClass) {
           const buttons = document.querySelectorAll('.' + btnClass);
           buttons.forEach(btn => btn.classList.remove('active'));
           btnElement.classList.add('active');

           const iframe = document.getElementById(pdfId);
           iframe.src = `${pdfUrl}#toolbar=0&navpanes=0&view=FitH`;

           const downloadBtn = document.getElementById(downloadBtnId);
           downloadBtn.href = pdfUrl;
           
           document.getElementById(titleId).innerText = title;
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
    </div>
  </main>
  
  <script src="/assets/js/main.js"></script>
</body>
</html>






