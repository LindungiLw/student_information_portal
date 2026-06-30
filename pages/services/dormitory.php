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
  <link rel="stylesheet" href="/assets/css/dashboard.css?v=50">
  <link rel="stylesheet" href="/assets/css/sidebar.css?v=50">
  <link rel="stylesheet" href="/assets/css/variables.css">
  <link rel="stylesheet" href="/assets/css/base.css">
  <link rel="stylesheet" href="/assets/css/responsive.css?v=53">
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
           <div class="custom-pdf-container" id="dorm-pdf-container" style="position: relative;">
               <div class="pdf-header">
                   <div class="pdf-title">
                       <i class="fas fa-file-pdf"></i> <span id="dorm-title-text"><?php echo htmlspecialchars($dormitory_docs[0]['title']); ?></span>
                   </div>
                   <div class="pdf-actions">
                       <a href="<?php echo htmlspecialchars($dormitory_docs[0]['file_path']); ?>" id="dorm-download-btn" download class="pdf-btn pdf-btn-outline">
                           <i class="fas fa-download"></i> Download PDF
                       </a>
                       <button class="floating-fullscreen-btn" onclick="expandPdf(this.dataset.currentUrl)" data-current-url="<?php echo htmlspecialchars($dormitory_docs[0]['file_path']); ?>" id="dorm-fullscreen-btn" style="box-shadow: 0 4px 15px rgba(0,0,0,0.15); border-radius: 8px; background: #ec4899; color: white; border: none; padding: 8px 16px; font-weight: 700; cursor: pointer; transition: transform 0.2s; display: flex; align-items: center; gap: 8px;">
                           <i class="fas fa-expand"></i> Open Document
                       </button>
                   </div>
               </div>
               
               <div class="pdf-body" style="cursor: pointer; position: relative; width: 100%; aspect-ratio: 1 / 1.414; background: #fff; overflow: hidden; border-radius: 0 0 12px 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid rgba(0,0,0,0.08); border-top: none;" onclick="document.getElementById('dorm-fullscreen-btn').click()" title="Click to open Document">
                   <canvas id="dorm-pdf-canvas" data-pdf-url="<?php echo htmlspecialchars($dormitory_docs[0]['file_path']); ?>" style="width: 100%; height: 100%; object-fit: cover; opacity: 0; transition: opacity 0.4s;"></canvas>
                   <div id="dorm-pdf-loader" style="position: absolute; inset: 0; display: flex; flex-direction: column; align-items: center; justify-content: center; background: #f8fafc; color: #ec4899;">
                       <i class="fas fa-circle-notch fa-spin" style="font-size: 24px; margin-bottom: 12px;"></i>
                       <div class="pdf-load-percent" style="font-size: 13px; font-weight: 700; color: #64748b;">Loading...</div>
                   </div>
               </div>
           </div>
       <?php endif; ?>

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

    function loadPdf(pdfUrl, title, btnElement) {
        const buttons = document.querySelectorAll('.dorm-btn');
        buttons.forEach(btn => btn.classList.remove('active'));
        btnElement.classList.add('active');

        const downloadBtn = document.getElementById('dorm-download-btn');
        if(downloadBtn) downloadBtn.href = pdfUrl;
        
        const titleText = document.getElementById('dorm-title-text');
        if(titleText) titleText.innerText = title;
        
        const fullscreenBtn = document.getElementById('dorm-fullscreen-btn');
        if (fullscreenBtn) {
            fullscreenBtn.dataset.currentUrl = pdfUrl;
        }

        renderThumbnail('dorm-pdf-canvas', pdfUrl, 'dorm-pdf-loader');
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
        const canvas = document.getElementById('dorm-pdf-canvas');
        if(canvas && canvas.dataset.pdfUrl) {
            renderThumbnail('dorm-pdf-canvas', canvas.dataset.pdfUrl, 'dorm-pdf-loader');
        }
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
  <script src="/assets/js/main.js?v=54"></script>
</body>
</html>






