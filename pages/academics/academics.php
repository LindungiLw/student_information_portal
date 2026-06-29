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
  <link rel="stylesheet" href="/assets/css/dashboard.css?v=18">
  <link rel="stylesheet" href="/assets/css/sidebar.css?v=4">
  <link rel="stylesheet" href="/assets/css/variables.css">
  <link rel="stylesheet" href="/assets/css/base.css">
  <link rel="stylesheet" href="/assets/css/responsive.css?v=24">
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
          #acad-pdf {
              /* Removed pointer-events: none to allow interaction */
          }
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
           <button class="floating-fullscreen-btn" onclick="toggleFullscreen('acad-pdf-container')">
               <i class="fas fa-expand"></i> Fullscreen
           </button>
           
           <!-- Iframe -->
           <div class="pdf-body">
               <iframe id="acad-pdf" class="ignore-mobile-fallback" src="<?php echo htmlspecialchars($academics_docs[0]['file_path']); ?>#toolbar=0&navpanes=0&view=FitH" width="100%" height="100%" style="border: none; display: block;">
                    <div style="padding: 2rem; text-align: center;">
                        <i class="fas fa-file-pdf" style="font-size: 3rem; color: #ccc; margin-bottom: 1rem;"></i>
                        <p>Your browser does not support PDF iframes.<br><a href="<?php echo htmlspecialchars($academics_docs[0]['file_path']); ?>" target="_blank">Open Guidelines here</a></p>
                    </div>
               </iframe>
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
  
  <script>
    function loadAcadPdf(pdfUrl, title, btnElement) {
        const buttons = document.querySelectorAll('.acad-btn');
        buttons.forEach(btn => btn.classList.remove('active'));
        if (btnElement) btnElement.classList.add('active');

        const iframe = document.getElementById('acad-pdf');
        if (iframe) iframe.src = `${pdfUrl}#toolbar=0&navpanes=0&view=FitH`;

        const titleEl = document.getElementById('acad-title-text');
        if (titleEl) titleEl.innerText = title;
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

    function openPdfSection(keyword, estimatedPage) {
        const pdfContainer = document.querySelector('.custom-pdf-container');
        if(pdfContainer) {
            pdfContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
            pdfContainer.style.transition = "box-shadow 0.3s ease";
            pdfContainer.style.boxShadow = "0 0 0 4px var(--purple-accent)";
            setTimeout(() => {
                pdfContainer.style.boxShadow = "0 4px 15px rgba(0,0,0,0.02)";
            }, 1500);
        }

        const iframe = document.getElementById('acad-pdf');
        if(iframe) {
            const currentSrc = iframe.getAttribute('src') || '/assets/documents/Academics.pdf';
            const cleanBase = currentSrc.split('?')[0].split('#')[0];
            const timestamp = new Date().getTime();
            iframe.src = `${cleanBase}?t=${timestamp}#toolbar=0&navpanes=0&view=FitH&search=${encodeURIComponent(keyword)}&page=${estimatedPage}`;
        }
    }
  </script>
  <script src="/assets/js/main.js"></script>
</body>
</html>
