<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /index.php');
    exit;
}
$current_page = basename($_SERVER['PHP_SELF']);

require_once $_SERVER['DOCUMENT_ROOT'] . '/config/koneksi.php';

// Fetch the latest finance document from the database
$finance_pdf_path = '';
$finance_pdf_title = '';

try {
    $stmt = $pdo->query("SELECT title, file_path FROM finance_documents ORDER BY id DESC LIMIT 1");
    $doc = $stmt->fetch();
    if ($doc && !empty($doc['file_path']) && file_exists($_SERVER['DOCUMENT_ROOT'] . $doc['file_path'])) {
        $finance_pdf_path = $doc['file_path'];
        $finance_pdf_title = $doc['title'];
    }
} catch (PDOException $e) {
    // If table doesn't exist yet, fallback to empty state
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cost of Attendance | JIU Student Portal</title>
  <link rel="icon" type="image/png" href="/assets/images/jiu-logo-rounded.png">
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="/assets/css/dashboard.css?v=50">
  <link rel="stylesheet" href="/assets/css/sidebar.css?v=50">
  <link rel="stylesheet" href="/assets/css/variables.css">
  <link rel="stylesheet" href="/assets/css/base.css">
  <link rel="stylesheet" href="/assets/css/responsive.css?v=55">
  <style>
      @keyframes scaleUpModal {
          from { transform: scale(0.95); opacity: 0; }
          to { transform: scale(1); opacity: 1; }
      }
      @keyframes fadeIn {
          from { opacity: 0; transform: translateY(10px); }
          to { opacity: 1; transform: translateY(0); }
      }
      .pdf-container {
          height: 600px;
          border-radius: 12px;
          overflow: hidden;
          border: 1px solid var(--border-color);
          margin-top: 16px;
          box-shadow: 0 10px 30px rgba(0,0,0,0.05);
      }
      @media (max-width: 768px) {
          .pdf-container {
              height: 400px;
          }
      }
  </style>
</head>
<body>
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/svg_icons.php'; ?>
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/sidebar.php'; ?>
  
  <main class="main">
    <div class="page-header">
       <h1><i class="fas fa-coins"></i> Cost of Attendance</h1>
       <p>Tuition, Fees, and Payment Guidelines for Domestic and International Students.</p>
    </div>
    <div class="bottom-dashboard-section" style="padding-top: 0;">

       <!-- Finance Pricing Grid -->
       <div class="finance-grid" style="margin-top: 30px;">
           <!-- Card 1: Domestic Tuition -->
           <div class="finance-card">
               <div class="finance-icon" style="background: rgba(49, 130, 206, 0.1); color: #3182ce;">
                   <i class="fas fa-graduation-cap"></i>
               </div>
               <h3>Domestic Tuition</h3>
               <div class="finance-price">
                   <span class="currency">Rp</span> <span class="amount">12.5M - 15M</span>
                   <span style="color:var(--text-muted); font-size:13px; font-weight:600;">/sem</span>
               </div>
               <ul class="finance-list">
                   <li><i class="fas fa-check-circle" style="color: #3182ce;"></i> <div class="text-content"><strong>ELL / JLL / ACC:</strong> <span class="val">Rp 12,500,000</span></div></li>
                   <li><i class="fas fa-check-circle" style="color: #3182ce;"></i> <div class="text-content"><strong>IT / IS / VCD:</strong> <span class="val">Rp 15,000,000</span></div></li>
               </ul>
               <a href="javascript:void(0)" onclick="openPdfSection('Domestic Student', 1)" class="finance-card-link" style="color: #3182ce;">Read Full Details <i class="fas fa-arrow-right"></i></a>
           </div>
           
           <!-- Card 2: One-Time Fees -->
           <div class="finance-card">
               <div class="finance-icon" style="background: rgba(213, 63, 140, 0.1); color: #d53f8c;">
                   <i class="fas fa-file-invoice-dollar"></i>
               </div>
               <h3>One-Time Fees</h3>
               <div class="finance-price">
                   <span class="currency">Rp</span> <span class="amount">13.3M</span>
                   <span style="color:var(--text-muted); font-size:13px; font-weight:600;"> total</span>
               </div>
               <ul class="finance-list">
                   <li><i class="fas fa-check-circle" style="color: #d53f8c;"></i> <div class="text-content"><strong>Registration:</strong> <span class="val">Rp 300,000</span></div></li>
                   <li><i class="fas fa-check-circle" style="color: #d53f8c;"></i> <div class="text-content"><strong>Development:</strong> <span class="val">Rp 10,000,000</span></div></li>
                   <li><i class="fas fa-check-circle" style="color: #d53f8c;"></i> <div class="text-content"><strong>Matriculation:</strong> <span class="val">Rp 3,000,000</span></div></li>
               </ul>
               <a href="javascript:void(0)" onclick="openPdfSection('Registration Fee', 1)" class="finance-card-link" style="color: #d53f8c;">Read Full Details <i class="fas fa-arrow-right"></i></a>
           </div>

           <!-- Card 3: Living Accommodations -->
           <div class="finance-card">
               <div class="finance-icon" style="background: rgba(221, 107, 32, 0.1); color: #dd6b20;">
                   <i class="fas fa-bed"></i>
               </div>
               <h3>Living Needs</h3>
               <div class="finance-price">
                   <span class="currency">Rp</span> <span class="amount">5.2M</span>
                   <span style="color:var(--text-muted); font-size:13px; font-weight:600;">/sem</span>
               </div>
               <ul class="finance-list">
                   <li><i class="fas fa-check-circle" style="color: #dd6b20;"></i> <div class="text-content"><strong>Dorm Fee:</strong> <span class="val">Rp 2,800,000</span></div></li>
                   <li><i class="fas fa-check-circle" style="color: #dd6b20;"></i> <div class="text-content"><strong>Meal Fee:</strong> <span class="val">Rp 2,400,000</span></div></li>
               </ul>
               <a href="javascript:void(0)" onclick="openPdfSection('Dorm Fee', 1)" class="finance-card-link" style="color: #dd6b20;">Read Full Details <i class="fas fa-arrow-right"></i></a>
           </div>

           <!-- Card 4: Payment Installments -->
           <div class="finance-card">
               <div class="finance-icon" style="background: rgba(128, 90, 213, 0.1); color: #805ad5;">
                   <i class="fas fa-calendar-check"></i>
               </div>
               <h3>Payment Installments</h3>
               <div class="finance-price">
                   <span class="amount">Milestones</span>
               </div>
               <ul class="finance-list">
                   <li><i class="fas fa-check-circle" style="color: #805ad5;"></i> <div class="text-content"><strong>25% Paid:</strong> <span class="val">Eligible for Enrollment</span></div></li>
                   <li><i class="fas fa-check-circle" style="color: #805ad5;"></i> <div class="text-content"><strong>50% Paid:</strong> <span class="val">Eligible for Midterms</span></div></li>
                   <li><i class="fas fa-check-circle" style="color: #805ad5;"></i> <div class="text-content"><strong>100% Paid:</strong> <span class="val">Eligible for Finals</span></div></li>
               </ul>
               <a href="javascript:void(0)" onclick="openPdfSection('Note', 1)" class="finance-card-link" style="color: #805ad5;">Read Full Details <i class="fas fa-arrow-right"></i></a>
           </div>

           <!-- Card 5: International Students -->
           <div class="finance-card">
               <div class="finance-icon" style="background: rgba(0, 181, 216, 0.1); color: #00b5d8;">
                   <i class="fas fa-globe-asia"></i>
               </div>
               <h3>International Std.</h3>
               <div class="finance-price">
                   <span class="currency">$</span> <span class="amount">2.2K - 3.5K</span>
               </div>
               <ul class="finance-list">
                   <li><i class="fas fa-check-circle" style="color: #00b5d8;"></i> <div class="text-content"><strong>In State:</strong> <span class="val">~$2,256 USD (Sem 1)</span></div></li>
                   <li><i class="fas fa-check-circle" style="color: #00b5d8;"></i> <div class="text-content"><strong>Out of State:</strong> <span class="val">~$3,500 USD (Sem 1)</span></div></li>
                   <li><i class="fas fa-info-circle" style="color: #00b5d8;"></i> <div class="text-content"><strong>Visa App:</strong> <span class="val">+ USD 650</span></div></li>
               </ul>
               <a href="javascript:void(0)" onclick="openPdfSection('International Students', 2)" class="finance-card-link" style="color: #00b5d8;">Read Full Details <i class="fas fa-arrow-right"></i></a>
           </div>

           <!-- Card 6: How to Pay -->
           <div class="finance-card">
               <div class="finance-icon" style="background: rgba(39, 174, 96, 0.1); color: #27ae60;">
                   <i class="fas fa-mobile-alt"></i>
               </div>
               <h3>How to Pay</h3>
               <div class="finance-price">
                   <span class="amount">Methods</span>
               </div>
               <ul class="finance-list" style="margin-bottom: 15px;">
                   <li><i class="fas fa-check-circle" style="color: #27ae60;"></i> <div class="text-content"><strong>SIAKAD:</strong> <span class="val">Student Portal</span></div></li>
                   <li><i class="fas fa-check-circle" style="color: #27ae60;"></i> <div class="text-content"><strong>CIVITAS:</strong> <span class="val">Mobile App</span></div></li>
                   <li><i class="fas fa-check-circle" style="color: #27ae60;"></i> <div class="text-content"><strong>Cash:</strong> <span class="val">JIU Finance Dept.</span></div></li>
               </ul>
               <a href="javascript:void(0)" onclick="openPdfSection('How to pay', 3)" class="finance-card-link" style="color: #27ae60;">Read Full Details <i class="fas fa-arrow-right"></i></a>
           </div>
       </div>

       <?php if (!empty($finance_pdf_path)): ?>
       <!-- Interactive PDF Viewer -->
             <div class="custom-pdf-container" style="position: relative;">
                 <!-- Floating Fullscreen Button di atas PDF -->
                 <button class="floating-fullscreen-btn" onclick="expandPdf()" title="Open PDF" style="position: absolute; top: 16px; right: 24px; z-index: 10; box-shadow: 0 4px 15px rgba(0,0,0,0.15); border-radius: 8px; background: #ef4444; color: white; border: none; padding: 8px 16px; font-weight: 700; cursor: pointer; transition: transform 0.2s; display: flex; align-items: center; gap: 8px;">
                     <i class="fas fa-expand"></i> Open Document
                 </button>
                 
                 <div class="pdf-body" style="cursor: pointer; position: relative; width: 100%; aspect-ratio: 1 / 1.414; background: #fff; overflow: hidden; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid rgba(0,0,0,0.08);" onclick="expandPdf()" title="Click to open Document">
                     <canvas id="pdf-thumbnail-canvas" style="width: 100%; height: 100%; object-fit: cover; opacity: 0; transition: opacity 0.4s;"></canvas>
                     <div class="pdf-thumbnail-loader" style="position: absolute; inset: 0; display: flex; flex-direction: column; align-items: center; justify-content: center; background: #f8fafc; color: #ef4444;">
                         <i class="fas fa-circle-notch fa-spin" style="font-size: 24px; margin-bottom: 12px;"></i>
                         <div class="pdf-load-percent" style="font-size: 13px; font-weight: 700; color: #64748b;">Loading...</div>
                     </div>
                 </div>
             </div>
             
             <div style="margin-top: 16px; display: flex; justify-content: flex-end;">
                 <a href="<?php echo htmlspecialchars($finance_pdf_path); ?>" download id="finance-pdf-download-btn" style="color: var(--purple-accent); font-weight: 600; text-decoration: none; font-size: 14px; display: inline-flex; align-items: center; gap: 6px;">
                     <i class="fas fa-download"></i> Download PDF
                 </a>
             </div>
         </div>
       <?php else: ?>
         <div class="empty-state-container" style="background: white; padding: 60px 40px; border-radius: 16px; text-align: center; border: 1px solid var(--border-color); box-shadow: 0 4px 20px rgba(0,0,0,0.03); margin-top: 50px;">
             <div class="empty-state-icon" style="font-size: 56px; color: #cbd5e1; margin-bottom: 20px;"><i class="fas fa-file-invoice-dollar"></i></div>
             <div class="empty-state-title" style="font-size: 22px; font-weight: 800; color: #334155; margin-bottom: 12px;">No Documents Available</div>
             <div class="empty-state-desc" style="font-size: 15px; color: #64748b; max-width: 400px; margin: 0 auto;">Official tuition and fee guidelines have not been uploaded yet. Please check back later.</div>
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
  
  <script src="/assets/js/main.js?v=54"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
  <script>
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
    let currentPdfUrl = "<?php echo empty($finance_pdf_path) ? '' : addslashes(htmlspecialchars($finance_pdf_path)); ?>";
    let pdfDoc = null;
    let pdfRendered = false;

    function renderPdfThumbnail(url) {
        if (!url) return;
        pdfDoc = null;
        pdfRendered = false;
        
        const loader = document.querySelector('.pdf-thumbnail-loader');
        if(loader) loader.style.display = 'flex';
        const canvasDesktop = document.getElementById('pdf-thumbnail-canvas');
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
            container.innerHTML = '<div style="color: #64748b; font-weight: 600; padding: 40px; text-align: center; font-family: \'Manrope\', sans-serif;"><i class="fas fa-circle-notch fa-spin" style="font-size: 24px; margin-bottom: 12px; color: #ef4444;"></i><br>Loading document...</div>';
            
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






