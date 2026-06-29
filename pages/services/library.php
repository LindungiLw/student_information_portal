<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /index.php');
    exit;
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/koneksi.php';

$library_docs = [];
try {
    $stmt = $pdo->query("SELECT * FROM library_documents ORDER BY id ASC");
    $all_docs = $stmt->fetchAll();
    foreach ($all_docs as $doc) {
        if (!empty($doc['file_path']) && file_exists($_SERVER['DOCUMENT_ROOT'] . $doc['file_path'])) {
            $library_docs[] = $doc;
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
  <title>Library | JIU Student Portal</title>
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
      .doc-btn.active { background: rgba(14, 165, 233, 0.1); border-color: rgba(14, 165, 233, 0.3); color: #0ea5e9; }
      
      .key-info-grid {
          display: grid;
          grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
          gap: 24px;
      }
      .info-box {
          background: #fff;
          border-radius: 20px;
          padding: 24px;
          border: 1px solid var(--border-color);
          box-shadow: 0 4px 15px rgba(0,0,0,0.02);
      }
      .info-icon {
          width: 48px;
          height: 48px;
          border-radius: 12px;
          background: rgba(14, 165, 233, 0.1);
          color: #0ea5e9;
          display: flex;
          align-items: center;
          justify-content: center;
          font-size: 20px;
          margin-bottom: 16px;
      }
      .info-box h4 {
          font-size: 18px;
          font-weight: 800;
          color: #1e293b;
          margin-bottom: 12px;
      }
      .info-box h5 {
          font-size: 14px;
          font-weight: 700;
          color: #475569;
          margin: 15px 0 8px 0;
      }
      .info-box p {
          font-size: 14px;
          color: #64748b;
          margin-bottom: 0;
          line-height: 1.7;
      }
      .info-box ul {
          margin: 0;
          padding-left: 20px;
          font-size: 14px;
          color: #64748b;
          line-height: 1.7;
      }
      .info-box ul li {
          margin-bottom: 8px;
      }
      .points-grid {
          display: grid;
          grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
          gap: 12px;
          margin-top: 20px;
      }
      .points-item {
          background: #f8fafc;
          padding: 12px 16px;
          border-radius: 12px;
          display: flex;
          align-items: center;
          gap: 12px;
          font-size: 13px;
          color: #475569;
          font-weight: 600;
      }
      .pts-badge {
          background: #0ea5e9;
          color: #fff;
          padding: 4px 8px;
          border-radius: 8px;
          font-size: 12px;
          font-weight: 800;
      }
      .contact-links p {
          font-size: 15px;
          margin-bottom: 10px;
      }
      .contact-links a {
          color: #0ea5e9;
          text-decoration: none;
          font-weight: 600;
      }
      .contact-links a:hover {
          text-decoration: underline;
      }
  </style>
</head>
<body>
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/svg_icons.php'; ?>
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/sidebar.php'; ?>
  
  <main class="main">
    <div class="page-header">
       <h1><i class="fas fa-book-open"></i> University Library</h1>
       <p>Access resources, borrow books, and learn about the library point system.</p>
    </div>
    
    <div class="bottom-dashboard-section" style="padding-top: 0;">
       <div style="margin-bottom: 30px;">
           <a href="/pages/services/student_services.php" class="back-btn" style="display: inline-flex; align-items: center; gap: 8px; font-weight: 600; color: var(--text-muted); text-decoration: none; padding: 10px 16px; background: #f8fafc; border-radius: 10px; transition: 0.2s;"><i class="fas fa-arrow-left"></i> Back to Student Services</a>
       </div>

       <!-- Section 1: Library Documents -->
       <h3 style="margin-bottom: 20px; font-size: 20px; color: var(--text-main);">Library Documents</h3>
       
       <?php if (empty($library_docs)): ?>
           <div class="empty-state-container" style="background: white; padding: 60px 40px; border-radius: 16px; text-align: center; border: 1px solid var(--border-color); box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
               <div class="empty-state-icon" style="font-size: 56px; color: #cbd5e1; margin-bottom: 20px;"><i class="fas fa-book-open"></i></div>
               <div class="empty-state-title" style="font-size: 22px; font-weight: 800; color: #334155; margin-bottom: 12px;">No Documents Available</div>
               <div class="empty-state-desc" style="font-size: 15px; color: #64748b; max-width: 400px; margin: 0 auto;">The library administration has not uploaded any guidelines or documents yet. Please check back later.</div>
           </div>
       <?php else: ?>
           <div class="doc-buttons">
               <?php foreach ($library_docs as $index => $doc): ?>
                   <button class="doc-btn library-btn <?php echo $index === 0 ? 'active' : ''; ?>" onclick="loadPdf('<?php echo htmlspecialchars($doc['file_path']); ?>', '<?php echo addslashes(htmlspecialchars($doc['title'])); ?>', this)">
                       <i class="fas fa-file-pdf"></i> <?php echo htmlspecialchars($doc['title']); ?>
                   </button>
               <?php endforeach; ?>
           </div>

           <!-- Interactive PDF Viewer -->
           <div class="custom-pdf-container" id="library-pdf-container">
               <div class="pdf-header">
                   <div class="pdf-title">
                       <i class="fas fa-file-pdf"></i> <span id="library-title-text"><?php echo htmlspecialchars($library_docs[0]['title']); ?></span>
                   </div>
                   <div class="pdf-actions">
                       <a href="<?php echo htmlspecialchars($library_docs[0]['file_path']); ?>" id="library-download-btn" download class="pdf-btn pdf-btn-outline">
                           <i class="fas fa-download"></i> Download PDF
                       </a>
                       <button class="pdf-btn pdf-btn-primary" onclick="toggleFullscreen('library-pdf-container')">
                           <i class="fas fa-expand"></i> Fullscreen
                       </button>
                   </div>
               </div>
               
               <div class="pdf-body">
                   <iframe 
                       id="library-pdf"
                       src="<?php echo htmlspecialchars($library_docs[0]['file_path']); ?>#toolbar=0&navpanes=0&view=FitH" 
                       type="application/pdf">
                   </iframe>
               </div>
           </div>
       <?php endif; ?>

       <!-- Section 2: Key Information -->
       <h3 style="margin: 50px 0 20px 0; font-size: 26px; color: #1e293b; font-weight: 800; letter-spacing: -0.5px;">Key Information</h3>
       
       <div class="key-info-grid">
           <!-- Card 1: Operation Hours -->
           <div class="info-box">
              <div class="info-icon"><i class="fas fa-clock"></i></div>
              <h4>Operation Hour</h4>
              <h5>Semester Operation Hour</h5>
              <p>
                  <strong>Mon - Fri:</strong> 8:00am - 5:00pm, 6:00pm - 9:00pm<br>
                  <strong>Saturday:</strong> 8:00am - 5:00pm<br>
                  <strong>Sunday:</strong> Closed
              </p>
              <h5>Vacation Operation Hour</h5>
              <p>
                  <strong>Mon - Fri:</strong> 8:00am - 5:00pm<br>
                  <strong>Sat, Sun:</strong> Closed
              </p>
              <p class="note"><i class="fas fa-info-circle"></i> Subject to change. Updates announced on Instagram.</p>
           </div>

           <!-- Card 2: Borrowing Rules -->
           <div class="info-box">
              <div class="info-icon"><i class="fas fa-book-reader"></i></div>
              <h4>How to borrow books?</h4>
              <ul>
                 <li>You can borrow <strong>5 books for 14 days</strong>.</li>
                 <li>During the vacation, you can borrow up to <strong>7 books</strong>.</li>
                 <li>Extension requests are subject to availability.</li>
                 <li>Late fee applies: <strong>Rp 1.000 / day / book</strong>.</li>
                 <li>Please reach out to the librarian to book study rooms.</li>
              </ul>
           </div>

           <!-- Card 3: Point System (Spans 2 columns on desktop if space allows) -->
           <div class="info-box" style="grid-column: 1 / -1;">
              <div class="info-icon" style="background: rgba(245, 158, 11, 0.1); color: #f59e0b;"><i class="fas fa-star"></i></div>
              <h4>Library Point System</h4>
              <p style="font-size: 15px; color: #334155;">Library is running a point system to encourage students to engage in various library programs. Each semester, two students will win a voucher to buy books <strong>(Rp 250.000/student)</strong>. Reading Ambassador will get an opportunity to order books for the library <strong>(Rp 500.000)</strong>.</p>
              
              <div class="points-grid">
                  <div class="points-item"><span class="pts-badge">10 pts</span> Write a short story (fiction)</div>
                  <div class="points-item"><span class="pts-badge">10 pts</span> Join library event</div>
                  <div class="points-item"><span class="pts-badge">10 pts</span> Feature on library IG</div>
                  <div class="points-item"><span class="pts-badge">10 pts</span> Fill library survey</div>
                  <div class="points-item"><span class="pts-badge" style="background: #8b5cf6;">3 pts</span> Borrow DVD</div>
                  <div class="points-item"><span class="pts-badge" style="background: #10b981;">2 pts</span> Borrow or extend books</div>
                  <div class="points-item"><span class="pts-badge" style="background: #10b981;">2 pts</span> Healing Corner items</div>
                  <div class="points-item"><span class="pts-badge" style="background: #64748b;">1 pt</span> Visiting</div>
              </div>
           </div>

           <!-- Card 4: Contact -->
           <div class="info-box" style="grid-column: 1 / -1; display: flex; align-items: center; gap: 30px;">
              <div class="info-icon" style="margin: 0; width: 64px; height: 64px; font-size: 28px; background: rgba(236, 72, 153, 0.1); color: #ec4899;"><i class="fas fa-id-badge"></i></div>
              <div class="contact-links" style="display: flex; gap: 40px; flex-wrap: wrap;">
                 <p style="margin: 0;"><strong>Librarian:</strong> Sena Afrina Simbolon <br><a href="mailto:sena44@k-eduplex.net"><i class="fas fa-envelope"></i> sena44@k-eduplex.net</a></p>
                 <p style="margin: 0;"><strong>Instagram:</strong> <br><a href="https://instagram.com/jiulibrary" target="_blank"><i class="fab fa-instagram"></i> @jiulibrary</a></p>
                 <p style="margin: 0;"><strong>Linktree:</strong> <br><a href="https://linktr.ee/jiulibrary" target="_blank"><i class="fas fa-link"></i> linktr.ee/jiulibrary</a></p>
              </div>
           </div>
       </div>

    </div>
  </main>
  
  <script>
    function loadPdf(pdfUrl, title, btnElement) {
        const buttons = document.querySelectorAll('.library-btn');
        buttons.forEach(btn => btn.classList.remove('active'));
        btnElement.classList.add('active');

        const iframe = document.getElementById('library-pdf');
        iframe.src = `${pdfUrl}#toolbar=0&navpanes=0&view=FitH`;

        const downloadBtn = document.getElementById('library-download-btn');
        downloadBtn.href = pdfUrl;
        
        document.getElementById('library-title-text').innerText = title;
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






