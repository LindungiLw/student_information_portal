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
                <div class="custom-pdf-container" id="exchange-pdf-container" style="position: relative;">
                    <button class="floating-fullscreen-btn" onclick="expandPdf(this.dataset.currentUrl)" data-current-url="<?php echo htmlspecialchars($exchange_docs[0]['file_path']); ?>" id="exchange-fullscreen-btn" style="position: absolute; top: 16px; right: 24px; z-index: 10; box-shadow: 0 4px 15px rgba(0,0,0,0.15); border-radius: 8px; background: var(--purple-accent); color: white; border: none; padding: 8px 16px; font-weight: 700; cursor: pointer; transition: transform 0.2s; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-expand"></i> Open Document
                    </button>
                    
                    <div class="pdf-body" style="cursor: pointer; position: relative; width: 100%; aspect-ratio: 1 / 1.414; background: #fff; overflow: hidden; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid rgba(0,0,0,0.08);" onclick="document.getElementById('exchange-fullscreen-btn').click()" title="Click to open Document">
                        <canvas id="exchange-pdf-canvas" data-pdf-url="<?php echo htmlspecialchars($exchange_docs[0]['file_path']); ?>" style="width: 100%; height: 100%; object-fit: cover; opacity: 0; transition: opacity 0.4s;"></canvas>
                        <div id="exchange-pdf-loader" style="position: absolute; inset: 0; display: flex; flex-direction: column; align-items: center; justify-content: center; background: #f8fafc; color: var(--purple-accent);">
                            <i class="fas fa-circle-notch fa-spin" style="font-size: 24px; margin-bottom: 12px;"></i>
                            <div class="pdf-load-percent" style="font-size: 13px; font-weight: 700; color: #64748b;">Loading...</div>
                        </div>
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
                <div class="custom-pdf-container" id="internship-pdf-container" style="position: relative;">
                    <button class="floating-fullscreen-btn" onclick="expandPdf(this.dataset.currentUrl)" data-current-url="<?php echo htmlspecialchars($internship_docs[0]['file_path']); ?>" id="internship-fullscreen-btn" style="position: absolute; top: 16px; right: 24px; z-index: 10; box-shadow: 0 4px 15px rgba(0,0,0,0.15); border-radius: 8px; background: #dd6b20; color: white; border: none; padding: 8px 16px; font-weight: 700; cursor: pointer; transition: transform 0.2s; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-expand"></i> Open Document
                    </button>
                    
                    <div class="pdf-body" style="cursor: pointer; position: relative; width: 100%; aspect-ratio: 1 / 1.414; background: #fff; overflow: hidden; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid rgba(0,0,0,0.08);" onclick="document.getElementById('internship-fullscreen-btn').click()" title="Click to open Document">
                        <canvas id="internship-pdf-canvas" data-pdf-url="<?php echo htmlspecialchars($internship_docs[0]['file_path']); ?>" style="width: 100%; height: 100%; object-fit: cover; opacity: 0; transition: opacity 0.4s;"></canvas>
                        <div id="internship-pdf-loader" style="position: absolute; inset: 0; display: flex; flex-direction: column; align-items: center; justify-content: center; background: #f8fafc; color: #dd6b20;">
                            <i class="fas fa-circle-notch fa-spin" style="font-size: 24px; margin-bottom: 12px;"></i>
                            <div class="pdf-load-percent" style="font-size: 13px; font-weight: 700; color: #64748b;">Loading...</div>
                        </div>
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
                <div class="custom-pdf-container" id="scholarship-pdf-container" style="position: relative;">
                    <button class="floating-fullscreen-btn" onclick="expandPdf(this.dataset.currentUrl)" data-current-url="<?php echo htmlspecialchars($scholarship_docs[0]['file_path']); ?>" id="scholarship-fullscreen-btn" style="position: absolute; top: 16px; right: 24px; z-index: 10; box-shadow: 0 4px 15px rgba(0,0,0,0.15); border-radius: 8px; background: #059669; color: white; border: none; padding: 8px 16px; font-weight: 700; cursor: pointer; transition: transform 0.2s; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-expand"></i> Open Document
                    </button>
                    
                    <div class="pdf-body" style="cursor: pointer; position: relative; width: 100%; aspect-ratio: 1 / 1.414; background: #fff; overflow: hidden; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid rgba(0,0,0,0.08);" onclick="document.getElementById('scholarship-fullscreen-btn').click()" title="Click to open Document">
                        <canvas id="scholarship-pdf-canvas" data-pdf-url="<?php echo htmlspecialchars($scholarship_docs[0]['file_path']); ?>" style="width: 100%; height: 100%; object-fit: cover; opacity: 0; transition: opacity 0.4s;"></canvas>
                        <div id="scholarship-pdf-loader" style="position: absolute; inset: 0; display: flex; flex-direction: column; align-items: center; justify-content: center; background: #f8fafc; color: #059669;">
                            <i class="fas fa-circle-notch fa-spin" style="font-size: 24px; margin-bottom: 12px;"></i>
                            <div class="pdf-load-percent" style="font-size: 13px; font-weight: 700; color: #64748b;">Loading...</div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
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

       <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
       <script>
       pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
       
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
       
       function loadPdf(pdfUrl, title, btnElement, pdfIdPrefix, downloadBtnId, titleId, btnClass) {
           const buttons = document.querySelectorAll('.' + btnClass);
           buttons.forEach(btn => btn.classList.remove('active'));
           btnElement.classList.add('active');

           const fullscreenBtn = document.getElementById(pdfIdPrefix.replace('-pdf', '-fullscreen-btn'));
           if (fullscreenBtn) {
               fullscreenBtn.dataset.currentUrl = pdfUrl;
           }
           
           renderThumbnail(pdfIdPrefix + '-canvas', pdfUrl, pdfIdPrefix + '-loader');
       }
       
       function renderThumbnail(canvasId, url, loaderId) {
           const canvas = document.getElementById(canvasId);
           const loader = document.getElementById(loaderId);
           if (!canvas || !url) return;
           
           canvas.style.opacity = '0';
           if (loader) loader.style.display = 'flex';
           
           pdfjsLib.getDocument(url).promise.then(pdf => {
               return pdf.getPage(1);
           }).then(page => {
               const context = canvas.getContext('2d');
               const viewport = page.getViewport({ scale: 1.5 });
               canvas.width = viewport.width;
               canvas.height = viewport.height;
               
               const renderContext = { canvasContext: context, viewport: viewport };
               return page.render(renderContext).promise;
           }).then(() => {
               if (loader) loader.style.display = 'none';
               canvas.style.opacity = '1';
           }).catch(err => {
               console.error("Error rendering PDF thumbnail:", err);
               if (loader) loader.innerHTML = 'Error loading PDF';
           });
       }

       window.addEventListener('DOMContentLoaded', () => {
           const exchangeCanvas = document.getElementById('exchange-pdf-canvas');
           if(exchangeCanvas && exchangeCanvas.dataset.pdfUrl) renderThumbnail('exchange-pdf-canvas', exchangeCanvas.dataset.pdfUrl, 'exchange-pdf-loader');
           
           const internshipCanvas = document.getElementById('internship-pdf-canvas');
           if(internshipCanvas && internshipCanvas.dataset.pdfUrl) renderThumbnail('internship-pdf-canvas', internshipCanvas.dataset.pdfUrl, 'internship-pdf-loader');
           
           const scholarshipCanvas = document.getElementById('scholarship-pdf-canvas');
           if(scholarshipCanvas && scholarshipCanvas.dataset.pdfUrl) renderThumbnail('scholarship-pdf-canvas', scholarshipCanvas.dataset.pdfUrl, 'scholarship-pdf-loader');
       });

       let currentExpandedUrl = null;
       function expandPdf(url) {
           if (!url) return;
           const modal = document.getElementById('booklet-popup-modal');
           const container = document.getElementById('pdf-render-container');
           if (!modal || !container) return;
           
           modal.style.display = 'flex';
           document.body.style.overflow = 'hidden';
           
           if (currentExpandedUrl !== url) {
               currentExpandedUrl = url;
               container.innerHTML = '<div style="color: #64748b; font-weight: 600; padding: 40px; text-align: center; font-family: \'Manrope\', sans-serif;"><i class="fas fa-circle-notch fa-spin" style="font-size: 24px; margin-bottom: 12px; color: #3b82f6;"></i><br>Loading document...</div>';
               
               pdfjsLib.getDocument(url).promise.then(pdf => {
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
    </div>
  </main>
  
  <script src="/assets/js/main.js"></script>
</body>
</html>






