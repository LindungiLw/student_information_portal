<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /index.php');
    exit;
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/koneksi.php';

// Buat tabel jika belum ada
$pdo->exec("CREATE TABLE IF NOT EXISTS academics_documents (
  id int(11) NOT NULL AUTO_INCREMENT,
  title varchar(255) NOT NULL,
  file_path varchar(255) DEFAULT NULL,
  uploaded_at timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

$academics_docs = [];
try {
    $stmt = $pdo->query("SELECT * FROM academics_documents ORDER BY id ASC");
    $all_docs = $stmt->fetchAll();
    foreach ($all_docs as $doc) {
        if (!empty($doc['file_path']) && file_exists($_SERVER['DOCUMENT_ROOT'] . $doc['file_path'])) {
            $academics_docs[] = $doc;
        }
    }
} catch (PDOException $e) {
    // If table doesn't exist yet, fallback to empty array
}

$current_page = 'academics.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Academics | JIU Student Portal</title>
  <link rel="icon" type="image/png" href="/assets/images/jiu-logo-rounded.png">
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="/assets/css/dashboard.css?v=50">
  <link rel="stylesheet" href="/assets/css/sidebar.css?v=50">
  <link rel="stylesheet" href="/assets/css/variables.css">
  <link rel="stylesheet" href="/assets/css/base.css">
  <link rel="stylesheet" href="/assets/css/responsive.css?v=55">
  <style>
      .doc-buttons { 
          display: flex; 
          gap: 12px; 
          margin-bottom: 24px; 
          overflow-x: auto; 
          padding-bottom: 8px; 
          scrollbar-width: thin; 
      }
      .doc-btn { 
          padding: 12px 20px; 
          background: #f8fafc; 
          border: 1px solid var(--border-color, #e2e8f0); 
          border-radius: 12px; 
          color: #475569; 
          font-weight: 700; 
          font-size: 13.5px; 
          cursor: pointer; 
          transition: all 0.25s; 
          display: flex; 
          align-items: center; 
          gap: 10px; 
          white-space: nowrap;
          flex-shrink: 0;
      }
      .doc-btn:hover { background: #f1f5f9; transform: translateY(-2px); }
      .doc-btn.active { background: rgba(124, 58, 237, 0.1); border-color: rgba(124, 58, 237, 0.35); color: #7c3aed; }
      
      .pdf-body {
          height: 800px;
          position: relative;
          width: 100%;
          overflow: hidden;
          border-radius: 14px;
          border: 1px solid var(--border-color);
      }
      .floating-fullscreen-btn {
          position: absolute;
          top: 16px;
          right: 24px;
          z-index: 10;
          box-shadow: 0 4px 15px rgba(0,0,0,0.15);
          border-radius: 8px;
          background: var(--purple-accent);
          color: white;
          border: none;
          padding: 8px 16px;
          font-weight: 700;
          font-size: 13px;
          display: flex;
          align-items: center;
          gap: 6px;
          cursor: pointer;
          transition: 0.2s;
      }
      .floating-fullscreen-btn:hover {
          background: #5b21b6;
      }
      
      /* Keep smaller iframe height on mobile for scrollability */
      @media (max-width: 767px) {
          .pdf-body { height: 400px !important; } 
      }
      
      /* Premium Policy Cards CSS */
      .policy-card {
          background: linear-gradient(145deg, #ffffff, #f8fafc);
          border: 1px solid rgba(148, 163, 184, 0.3);
          border-radius: 16px;
          padding: 24px;
          display: flex;
          flex-direction: column;
          justify-content: space-between;
          transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
          box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
      }
      .policy-card:hover {
          transform: translateY(-5px);
          box-shadow: 0 15px 35px rgba(59, 130, 246, 0.1);
          border-color: rgba(124, 58, 237, 0.5);
      }
      .policy-card-content h3 {
          color: #1e293b;
          font-weight: 800;
          letter-spacing: -0.3px;
      }
      .policy-card-content p, .policy-card-content ul {
          color: #475569;
          line-height: 1.6;
      }
      .policy-card-icon-wrap {
          width: 48px;
          height: 48px;
          border-radius: 12px;
          background: rgba(124, 58, 237, 0.1);
          display: flex;
          align-items: center;
          justify-content: center;
          color: var(--purple-accent);
      }
      .policy-card-link {
          margin-top: 20px;
          display: inline-flex;
          align-items: center;
          gap: 6px;
          color: var(--purple-accent);
          font-weight: 700;
          font-size: 13px;
          text-decoration: none;
          transition: 0.2s;
      }
      .policy-card-link:hover {
          color: #5b21b6;
          gap: 10px;
      }

      #acad-pdf-container:fullscreen iframe { pointer-events: auto !important; }
      #acad-pdf-container:-webkit-full-screen iframe { pointer-events: auto !important; }

      @media (max-width: 768px) {
          .policy-grid {
              display: flex !important;
              flex-direction: column !important;
              gap: 16px !important;
              width: 100% !important;
          }
              padding: 18px 16px !important;
              border-radius: 14px !important;
          }
          .policy-card h3 {
              font-size: 16.5px !important;
          }
          .policy-card p, .policy-card ul li {
              font-size: 13.5px !important;
          }
          .custom-pdf-container {
              width: 100% !important;
              border-radius: 14px !important;
          }
          .pdf-body {
              height: 70vh !important;
          }
          .page-header {
              flex-direction: column !important;
              align-items: flex-start !important;
          }
      }
      @keyframes scaleUpModal {
          from { transform: scale(0.95); opacity: 0; }
          to { transform: scale(1); opacity: 1; }
      }
      @keyframes fadeIn {
          from { opacity: 0; }
          to { opacity: 1; }
      }
  </style>
</head>
<body>
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/svg_icons.php'; ?>
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/sidebar.php'; ?>
  <main class="main">
    <div class="page-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
       <div>
           <h1 style="margin:0; display:flex; align-items:center; gap:10px;"><svg class="custom-icon" style="color: white;"><use href="#icon-book"></use></svg> Academic Policies</h1>
           <p style="margin-top:8px; margin-bottom:0;">Review the academic guidelines, credit requirements, and procedures for your study.</p>
       </div>
       <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
           <a href="/admin/academics_docs_manage.php" class="btn" style="background: white; color: var(--purple-accent); text-decoration: none; display: inline-flex; align-items: center; gap: 8px; padding: 10px 18px; border-radius: 10px; font-weight: 700; font-size: 13.5px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
               <i class="fas fa-edit"></i> Manage Docs
           </a>
       <?php endif; ?>
    </div>
    
    <div class="bottom-dashboard-section" style="padding-top: 0;">

       <!-- Bento Box Grid Layout -->
       <div class="policy-grid">
           <!-- Card 1 -->
            <div class="policy-card">
                <div class="policy-card-content">
                    <div style="display: flex; align-items: center; gap: 14px; margin-bottom: 16px;">
                        <div class="policy-card-icon-wrap">
                            <svg class="custom-icon"><use href="#icon-clock"></use></svg>
                        </div>
                        <h3 style="margin: 0; font-size: 16px;">Length of Study & Credits</h3>
                    </div>
                    <p style="font-size: 13.5px;">Regular undergraduate program spans <strong>8 to 10 semesters</strong>.<br><br>To graduate, students must complete a minimum of <strong>144 credits</strong>.</p>
                </div>
               <a href="javascript:void(0)" onclick="openPdfSection('Length of Undergraduate Study', 1)" class="policy-card-link">Read Full Details <i class="fas fa-arrow-right"></i></a>
           </div>
           
           <!-- Card 2 -->
            <div class="policy-card">
                <div class="policy-card-content">
                    <div style="display: flex; align-items: center; gap: 14px; margin-bottom: 16px;">
                        <div class="policy-card-icon-wrap">
                            <svg class="custom-icon"><use href="#icon-user-check"></use></svg>
                        </div>
                        <h3 style="margin: 0; font-size: 16px;">Class Attendance</h3>
                    </div>
                    <p style="font-size: 13.5px;">Strict attendance required. A maximum of <strong>3 unauthorized absences</strong> is allowed per subject to qualify for final exams.<br><br>Medical/official leave requires documentation.</p>
                </div>
               <a href="javascript:void(0)" onclick="openPdfSection('Class Attendance', 2)" class="policy-card-link">Read Full Details <i class="fas fa-arrow-right"></i></a>
           </div>

           <!-- Card 3 -->
            <div class="policy-card">
                <div class="policy-card-content">
                    <div style="display: flex; align-items: center; gap: 14px; margin-bottom: 16px;">
                        <div class="policy-card-icon-wrap">
                            <svg class="custom-icon"><use href="#icon-clipboard"></use></svg>
                        </div>
                        <h3 style="margin: 0; font-size: 16px;">Assessments & Exams</h3>
                    </div>
                    <p style="font-size: 13.5px;">Evaluated through Mid/Final exams, Quizzes, and Projects.<br><br><strong style="color:#e53e3e; background: rgba(229,62,62,0.1); padding: 2px 6px; border-radius: 4px;">Strict Anti-Cheating Rule:</strong> Any violation automatically results in a failing grade.</p>
                </div>
               <a href="javascript:void(0)" onclick="openPdfSection('Assessment', 3)" class="policy-card-link">Read Full Details <i class="fas fa-arrow-right"></i></a>
           </div>

           <!-- Card 4 -->
            <div class="policy-card">
                <div class="policy-card-content">
                    <div style="display: flex; align-items: center; gap: 14px; margin-bottom: 16px;">
                        <div class="policy-card-icon-wrap">
                            <svg class="custom-icon"><use href="#icon-star"></use></svg>
                        </div>
                        <h3 style="margin: 0; font-size: 16px;">Grading & GPA</h3>
                    </div>
                    <ul style="font-size: 13.5px; padding-left: 20px;">
                        <li style="margin-bottom: 4px;"><strong>A (4.0):</strong> Outstanding (85-100)</li>
                        <li style="margin-bottom: 4px;"><strong>C (2.0):</strong> Passing (55-59)</li>
                        <li style="margin-bottom: 4px;"><strong>Fail:</strong> Below 54.9</li>
                        <li style="margin-top:10px; color: var(--purple-accent);"><strong>Cum Laude:</strong> GPA 3.75 - 4.00</li>
                    </ul>
                </div>
               <a href="javascript:void(0)" onclick="openPdfSection('Grading System', 4)" class="policy-card-link">Read Full Details <i class="fas fa-arrow-right"></i></a>
           </div>

           <!-- Card 5 -->
            <div class="policy-card">
                <div class="policy-card-content">
                    <div style="display: flex; align-items: center; gap: 14px; margin-bottom: 16px;">
                        <div class="policy-card-icon-wrap">
                            <svg class="custom-icon"><use href="#icon-repeat"></use></svg>
                        </div>
                        <h3 style="margin: 0; font-size: 16px;">Transfer & Leave</h3>
                    </div>
                    <p style="font-size: 13.5px;">Academic leave is permitted for up to <strong>2 semesters</strong>.<br><br><strong>Drop Out Rule:</strong> Triggers if cumulative GPA falls below 2.0 or earning &lt; 30 credits after 4 semesters.</p>
                </div>
               <a href="javascript:void(0)" onclick="openPdfSection('Academic Leave', 5)" class="policy-card-link">Read Full Details <i class="fas fa-arrow-right"></i></a>
           </div>

           <!-- Card 6 -->
            <div class="policy-card">
                <div class="policy-card-content">
                    <div style="display: flex; align-items: center; gap: 14px; margin-bottom: 16px;">
                        <div class="policy-card-icon-wrap">
                            <svg class="custom-icon"><use href="#icon-award"></use></svg>
                        </div>
                        <h3 style="margin: 0; font-size: 16px;">Judicium & Graduation</h3>
                    </div>
                    <p style="font-size: 13.5px;">Requirements include:<br><span style="display:block; margin-top:6px; margin-left: 8px;">• Fulfilling 144 credits without D/E<br>• Completing Thesis/Final Project<br>• Settling all financial obligations<br>• Minimum C on Internships</span></p>
                </div>
               <a href="javascript:void(0)" onclick="openPdfSection('Judicium', 6)" class="policy-card-link">Read Full Details <i class="fas fa-arrow-right"></i></a>
           </div>
       </div>

       <!-- Full Document PDF Viewer Section -->
       <div class="section-header" style="margin-top: 40px;">
          <div class="section-title">
             <svg class="custom-icon"><use href="#icon-book"></use></svg> 
             Official Academic Documents
          </div>
       </div>

       <?php if (count($academics_docs) > 1): ?>
       <div class="doc-buttons">
           <?php foreach ($academics_docs as $index => $doc): ?>
               <button class="doc-btn acad-btn <?php echo $index === 0 ? 'active' : ''; ?>" onclick="loadAcadPdf('<?php echo htmlspecialchars($doc['file_path']); ?>', '<?php echo addslashes(htmlspecialchars($doc['title'])); ?>', this)">
                   <i class="fas fa-file-pdf"></i> <?php echo htmlspecialchars($doc['title']); ?>
               </button>
           <?php endforeach; ?>
       </div>
       <?php endif; ?>

       <?php if (count($academics_docs) > 0): ?>
       <div class="custom-pdf-container" id="acad-pdf-container" style="position: relative;">
           <!-- Floating Fullscreen Button di atas PDF -->
           <button class="floating-fullscreen-btn" onclick="expandPdf()" title="Open PDF">
               <i class="fas fa-expand"></i> Open Document
           </button>
           
           <div class="pdf-body" style="cursor: pointer;" onclick="expandPdf()" title="Click to open Document">
               <div class="pdf-clip-wrapper" style="position: relative; width: 100%; aspect-ratio: 1 / 1.414; background: #fff; overflow: hidden; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid rgba(0,0,0,0.08);">
                   <canvas id="pdf-thumbnail-canvas-desktop" style="width: 100%; height: 100%; object-fit: cover; opacity: 0; transition: opacity 0.4s;"></canvas>
                   <div class="pdf-thumbnail-loader" style="position: absolute; inset: 0; display: flex; flex-direction: column; align-items: center; justify-content: center; background: #f8fafc; color: #3b82f6;">
                       <i class="fas fa-circle-notch fa-spin" style="font-size: 24px; margin-bottom: 12px;"></i>
                       <div class="pdf-load-percent" style="font-size: 13px; font-weight: 700; color: #64748b;">Loading...</div>
                   </div>
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
       <?php else: ?>
       <div class="empty-state-container" style="background: white; padding: 40px; border-radius: 12px; text-align: center; border: 1px solid var(--border-color); margin-top: 20px;">
           <div class="empty-state-icon" style="font-size: 48px; color: #cbd5e1; margin-bottom: 16px;"><i class="fas fa-file-pdf"></i></div>
           <div class="empty-state-title" style="font-size: 18px; font-weight: 700; margin-bottom: 8px;">No Documents Available</div>
           <div class="empty-state-desc" style="font-size: 14px; color: var(--text-muted); margin-bottom: 24px;">The academic documents have not been uploaded by the administration yet.</div>
       </div>
       <?php endif; ?>

    </div>
  </main>
  
  <script src="/assets/js/main.js?v=54"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
  <script>
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
    let currentPdfUrl = "<?php echo empty($academics_docs) ? '' : addslashes(htmlspecialchars($academics_docs[0]['file_path'])); ?>";
    let pdfDoc = null;
    let pdfRendered = false;

    function renderPdfThumbnail(url) {
        if (!url) return;
        pdfDoc = null;
        pdfRendered = false;
        
        const loader = document.querySelector('.pdf-thumbnail-loader');
        if(loader) loader.style.display = 'flex';
        const canvasDesktop = document.getElementById('pdf-thumbnail-canvas-desktop');
        if(canvasDesktop) canvasDesktop.style.opacity = '0';
        
        const applyThumb = (srcData) => {
            const img = new Image();
            img.onload = function() {
                if(canvasDesktop) {
                    const ctx = canvasDesktop.getContext('2d');
                    canvasDesktop.width = img.width; canvasDesktop.height = img.height;
                    ctx.drawImage(img, 0, 0); canvasDesktop.style.opacity = '1';
                }
                if(loader) loader.style.display = 'none';
            };
            img.src = srcData;
        };

        const cachedThumb = localStorage.getItem('pdf_thumb_' + url);
        const loadingTask = pdfjsLib.getDocument(url);
        
        loadingTask.onProgress = function(progress) {
            const percentEls = document.querySelectorAll('.pdf-load-percent');
            if (percentEls.length > 0 && progress.total > 0 && !cachedThumb) {
                const percent = Math.round((progress.loaded / progress.total) * 100);
                percentEls.forEach(el => el.textContent = percent + '%');
            }
        };

        if (cachedThumb) {
            applyThumb(cachedThumb);
            loadingTask.promise.then(pdf => { pdfDoc = pdf; }).catch(e => console.error(e));
        } else {
            loadingTask.promise.then(pdf => {
                pdfDoc = pdf;
                pdf.getPage(1).then(page => {
                    const viewport = page.getViewport({ scale: 1.5 });
                    const canvas = document.createElement('canvas');
                    const ctx = canvas.getContext('2d');
                    canvas.width = viewport.width; canvas.height = viewport.height;
                    page.render({ canvasContext: ctx, viewport: viewport }).promise.then(() => {
                        const dataUrl = canvas.toDataURL('image/jpeg', 0.8);
                        try { localStorage.setItem('pdf_thumb_' + url, dataUrl); } catch(e) {}
                        applyThumb(dataUrl);
                    });
                });
            }).catch(e => {
                console.error("PDF Load Error:", e);
                if(loader) loader.innerHTML = "Error loading PDF thumbnail.";
            });
        }
    }

    if (currentPdfUrl) renderPdfThumbnail(currentPdfUrl);

    function loadAcadPdf(pdfUrl, title, btnElement) {
        const buttons = document.querySelectorAll('.acad-btn');
        buttons.forEach(btn => btn.classList.remove('active'));
        if (btnElement) btnElement.classList.add('active');

        currentPdfUrl = pdfUrl;
        renderPdfThumbnail(pdfUrl);
    }

    function expandPdf(pageTarget = 1) {
        if (!currentPdfUrl) return;
        if (!pdfDoc) {
            alert('Mohon tunggu, dokumen sedang diunduh...');
            return;
        }
        
        const modal = document.getElementById('booklet-popup-modal');
        const container = document.getElementById('pdf-render-container');
        if (!modal || !container) return;
        
        modal.style.display = 'flex';

        if (!pdfRendered) {
            pdfRendered = true;
            container.innerHTML = '<div style="color: #64748b; font-weight: 600; padding: 40px; text-align: center; font-family: \'Manrope\', sans-serif;"><i class="fas fa-circle-notch fa-spin" style="font-size: 24px; margin-bottom: 12px; color: #3b82f6;"></i><br>Loading document...</div>';
            
            const screenWidth = window.innerWidth;
            let scale = 1.5;
            if (screenWidth < 600) scale = 1.0;

            const renderPage = (num) => {
                return pdfDoc.getPage(num).then(page => {
                    const viewport = page.getViewport({ scale: scale });
                    const canvas = document.createElement('canvas');
                    canvas.id = 'pdf-page-' + num;
                    const context = canvas.getContext('2d');
                    canvas.width = viewport.width; canvas.height = viewport.height;
                    canvas.style.maxWidth = '100%'; canvas.style.height = 'auto';
                    canvas.style.boxShadow = '0 10px 25px rgba(0,0,0,0.1)';
                    canvas.style.borderRadius = '8px'; canvas.style.background = '#fff';

                    const renderContext = { canvasContext: context, viewport: viewport };
                    return page.render(renderContext).promise.then(() => canvas);
                });
            };

            const renderAllPages = async () => {
                const canvases = [];
                for (let i = 1; i <= pdfDoc.numPages; i++) {
                    canvases.push(await renderPage(i));
                }
                container.innerHTML = '';
                canvases.forEach(c => container.appendChild(c));
                
                if (pageTarget > 1) {
                    setTimeout(() => {
                        const targetCanvas = document.getElementById('pdf-page-' + pageTarget);
                        if (targetCanvas) targetCanvas.scrollIntoView({ behavior: 'smooth' });
                    }, 100);
                }
            };

            renderAllPages().catch(err => {
                console.error("Error rendering pages: ", err);
                container.innerHTML = '<div style="color: #ef4444; font-weight: 600; padding: 40px; text-align: center;">Failed to load PDF pages.</div>';
            });
        } else {
            if (pageTarget > 1) {
                setTimeout(() => {
                    const targetCanvas = document.getElementById('pdf-page-' + pageTarget);
                    if (targetCanvas) targetCanvas.scrollIntoView({ behavior: 'smooth' });
                }, 100);
            }
        }
    }

    function openPdfSection(keyword, estimatedPage) {
        expandPdf(estimatedPage);
    }

    function closeBookletModal() {
        const modal = document.getElementById('booklet-popup-modal');
        if (modal) modal.style.display = 'none';
    }
    
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeBookletModal();
    });
  </script>
</body>
</html>
